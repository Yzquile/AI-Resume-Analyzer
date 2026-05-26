<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIAnalyzerService
{
    public function analyzeResume(string $resumeText): array
    {
        $prompt = $this->buildPrompt($resumeText);

        try {
            // Try the primary model first
            $result = $this->callPrimary($prompt);

            // If primary fails, fallback to other models
            if ($result === null) {
                $result = $this->callWithFallback($prompt);
            }

            $content = $result['choices'][0]['message']['content'] ?? '';

            // Clean up potential markdown wrapping
            $content = $this->cleanJsonResponse($content);

            $data = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('JSON parse failed', ['content' => $content]);
                throw new \Exception('AI returned invalid JSON');
            }

            // Normalize the response to match our expected schema
            return [
                'full_name' => $data['full_name'] ?? $data['name'] ?? 'Unknown',
                'skills' => is_array($data['skills'] ?? null) ? $data['skills'] : [],
                'years_experience' => is_numeric($data['years_experience'] ?? null)
                    ? (int) $data['years_experience']
                    : null,
                'education' => $data['education'] ?? 'Not specified',
                'suggested_role' => $data['suggested_role'] ?? $data['role'] ?? 'Not specified',
            ];
        } catch (\Exception $e) {
            Log::error('AI Analysis failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Try the primary model (DeepSeek). Returns raw API response array or null on failure.
     */
    private function callPrimary(string $prompt): ?array
    {
        try {
            $response = Http::timeout(60)->withHeaders([
                'Authorization' => 'Bearer ' . config('services.openrouter.key'),
                'HTTP-Referer' => url('/'),
                'X-Title' => 'ResumeAI',
                'Content-Type' => 'application/json',
            ])->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'deepseek/deepseek-v4-flash:free',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a resume parsing engine. You extract structured data from resumes. You MUST return ONLY valid JSON. No markdown, no explanations, no code blocks. Just raw JSON.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ],
                ],
                'temperature' => 0.1,
                'max_tokens' => 2048,
            ]);

            if ($response->successful()) {
                Log::info('Primary model (deepseek) succeeded');
                return $response->json();
            }

            if ($response->status() === 429) {
                Log::warning('Primary model rate limited (429), will try fallback');
                return null;
            }

            Log::error('Primary model failed', ['status' => $response->status()]);
            return null;
        } catch (\Exception $e) {
            Log::warning('Primary model exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Fallback to other models when primary fails. Returns raw API response array.
     */
    private function callWithFallback(string $prompt): array
    {
        $models = [
            'openai/gpt-oss-120b:free',
            'google/gemma-4-31b-it:free',
            'meta-llama/llama-3.2-3b-instruct:free',
        ];

        foreach ($models as $model) {
            try {
                // Add small delay between fallback attempts to avoid hammering
                sleep(1);

                $response = Http::timeout(60)->withOptions([
                    'verify' => false,
                ])->withHeaders([
                    'Authorization' => 'Bearer ' . config('services.openrouter.key'),
                    'HTTP-Referer' => url('/'),
                    'X-Title' => 'ResumeAI',
                ])->post('https://openrouter.ai/api/v1/chat/completions', [
                    'model' => $model,
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a resume parser. Return ONLY valid JSON.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'temperature' => 0.1,
                    'max_tokens' => 2048,
                ]);

                if ($response->successful()) {
                    Log::info("Fallback model succeeded: {$model}");
                    return $response->json();
                }

                if ($response->status() === 429) {
                    Log::warning("Fallback model rate limited: {$model}");
                    continue;
                }

                Log::warning("Fallback model failed: {$model} (HTTP {$response->status()})");
            } catch (\Exception $e) {
                Log::warning("Fallback model exception: {$model} - " . $e->getMessage());
            }
        }

        throw new \Exception('All models failed or rate limited');
    }

    private function buildPrompt(string $resumeText): string
    {
        return <<<PROMPT
        Analyze this resume and extract the following information. Return ONLY a JSON object.

        Required fields:
        - full_name: The candidate's full name
        - skills: Array of technical and professional skills (e.g., ["Laravel", "React", "Project Management"])
        - years_experience: Total years of professional work experience as a number
        - education: Highest degree or educational qualification
        - suggested_role: The most suitable job title based on skills and experience

        Rules:
        - Return ONLY valid JSON
        - No markdown formatting
        - No explanations
        - If information is missing, use null or empty arrays
        - years_experience must be a number, not a string

        Resume text:
        ---
        {$resumeText}
        ---

        JSON:
        PROMPT;
    }

    private function cleanJsonResponse(string $content): string
    {
        $content = preg_replace('/```json\s*/', '', $content);
        $content = preg_replace('/```\s*/', '', $content);
        $content = trim($content);

        $start = strpos($content, '{');
        $end = strrpos($content, '}');

        if ($start !== false && $end !== false && $end > $start) {
            $content = substr($content, $start, $end - $start + 1);
        }

        return $content;
    }
}
