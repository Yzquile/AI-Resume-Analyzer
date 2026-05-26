

# AI Resume Analyzer

AI-powered resume analyzer built with Laravel that extracts structured candidate information from uploaded PDF/DOCX resumes using LLMs.

## Features

- Resume upload system
- PDF and DOCX parsing
- AI-powered candidate analysis
- Structured candidate data extraction
- Authentication system
- User dashboard
- Clean Blade + Tailwind UI

## Extracted Information

The system analyzes resumes and extracts:

- Full Name
- Skills
- Years of Experience
- Education
- Suggested Job Role

---

# Tech Stack

## Backend
- Laravel 12
- PHP 8.3+
- Blade Templates
- Tailwind CSS

## Database
- SQLite (development)
- PostgreSQL-ready

## AI Integration
- Google Gemini API / OpenRouter

## File Parsing
- smalot/pdfparser
- phpoffice/phpword

## Deployment
- Docker
- Render

---

# Project Architecture

```txt
Upload Resume
      ↓
Extract Resume Text
      ↓
AI Analysis
      ↓
Structured JSON Output
      ↓
Dashboard Display
```

---

# Installation

## Clone Repository

```bash
git clone https://github.com/your-username/ai-resume-analyzer.git

cd ai-resume-analyzer
```

## Install Dependencies

```bash
composer install
npm install
```

## Setup Environment

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

---

# Database Setup

Using SQLite:

```bash
touch database/database.sqlite
```

Update `.env`:

```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite
```

Run migrations:

```bash
php artisan migrate
```

---

# Install Resume Parsing Packages

## PDF Parser

```bash
composer require smalot/pdfparser
```

## DOCX Parser

```bash
composer require phpoffice/phpword
```

---

# Run Development Server

```bash
npm run dev
php artisan serve
```

---

# Docker Deployment

This project is configured for Docker deployment on Render.

## Build Docker Container

```bash
docker build -t ai-resume-analyzer .
```

## Run Container

```bash
docker run -p 10000:10000 ai-resume-analyzer
```

---

# Future Improvements

- Resume scoring
- AI job matching
- Candidate ranking
- OCR support
- Interview question generation
- Export functionality
- Advanced filtering

---

# License

This project is for educational and portfolio purposes.
