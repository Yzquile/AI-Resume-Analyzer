<?php

namespace App\Services;

use Smalot\PdfParser\Parser as PdfParser;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\Element\Text;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\Element\Cell;

class ResumeParserService
{
    public function extractText(string $filePath): string
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        return match ($extension) {
            'pdf' => $this->parsePdf($filePath),
            'docx' => $this->parseDocx($filePath),
            default => throw new \InvalidArgumentException("Unsupported file type: {$extension}"),
        };
    }

    private function parsePdf(string $filePath): string
    {
        $parser = new PdfParser();
        $pdf = $parser->parseFile($filePath);
        
        return $pdf->getText() ?? '';
    }

    private function parseDocx(string $filePath): string
    {
        $phpWord = IOFactory::load($filePath);
        $text = [];

        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                $text[] = $this->extractElementText($element);
            }
        }

        return trim(implode(' ', array_filter($text)));
    }

    /**
     * Recursively extract text from any PhpWord element
     */
    private function extractElementText($element): string
    {
        // Simple text element
        if ($element instanceof Text) {
            return $element->getText() ?? '';
        }

        // TextRun — container with nested text elements
        if ($element instanceof TextRun) {
            $parts = [];
            foreach ($element->getElements() as $child) {
                $parts[] = $this->extractElementText($child);
            }
            return implode('', $parts);
        }

        // Table — extract text from all cells
        if ($element instanceof Table) {
            $rows = [];
            foreach ($element->getRows() as $row) {
                foreach ($row->getCells() as $cell) {
                    foreach ($cell->getElements() as $cellElement) {
                        $rows[] = $this->extractElementText($cellElement);
                    }
                }
            }
            return implode(' ', $rows);
        }

        // Cell (standalone, not inside table iteration)
        if ($element instanceof Cell) {
            $parts = [];
            foreach ($element->getElements() as $child) {
                $parts[] = $this->extractElementText($child);
            }
            return implode(' ', $parts);
        }

        // Generic fallback — try getText() if method exists
        if (method_exists($element, 'getText')) {
            $result = $element->getText();
            return is_string($result) ? $result : '';
        }

        // Last resort — try to cast or skip
        if (is_string($element)) {
            return $element;
        }

        return '';
    }
}