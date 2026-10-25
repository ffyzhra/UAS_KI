# Scholarship Management System

A web application for managing student scholarships at Esa Unggul University. Students apply for scholarships, upload required documents and track their status; admins verify documents, run the selection and manage recipients.

Built with **Laravel 12** and **Filament v3**, containerised with **Docker**, and hardened and tested for the Information Security (*Keamanan Informasi*) course.

## Features

**Students**
- Register and log in
- Apply for a scholarship
- Upload documents (ID card, family card, salary slip, transcript)
- Track application status from a student dashboard

**Admin**
- Manage scholarships, students, majors and applications
- Verify uploaded documents
- Run the selection process and manage recipients
- Role-based access control (Filament Shield + Spatie Permission)
- Dashboard widget showing the latest access logs

## Security

The app was scanned with **OWASP ZAP**: 0 high, 0 medium and 0 low findings. The one informational finding (cookie without the HttpOnly flag) has been fixed.

Hardening in place:
- CSRF protection on all forms
- Session cookies set to `HttpOnly`, `Secure` and `SameSite=strict` (`config/session.php`)
- `SecurityHeaders` middleware: `Content-Security-Policy`, `Strict-Transport-Security`, `X-Frame-Options: DENY`, `X-Content-Type-Options: nosniff`
- HTTPS during testing via an ngrok tunnel
- Role-based authorization on every admin resource

## Tech stack

| Layer          | Tools                                            |
| -------------- | ------------------------------------------------ |
| Backend        | PHP 8.2, Laravel 12                              |
| Admin panel    | Filament v3, Filament Shield, Spatie Permission  |
| Database       | MariaDB 10.2                                     |
| Infrastructure | Docker Compose (PHP-FPM, Nginx, MariaDB)         |
| Security tests | OWASP ZAP                                        |

## Running locally with Docker

```bash
git clone https://github.com/ffyzhra/UAS_KI.git
cd UAS_KI
cp src/.env.example src/.env      # then fill in DB_* to match docker-compose.yml
docker compose up -d --build
docker compose exec ksi php artisan key:generate
docker compose exec ksi php artisan migrate --seed
```

Open `http://localhost`. The seeder creates demo accounts (local only):

| Role    | Email               | Password       |
| ------- | ------------------- | -------------- |
| Admin   | `admin@admin.com`   | `password`     |
| Student | `fayza@student.com` | `mahasiswa123` |

## Project structure

```
src/                  # Laravel application
├── app/Filament/     # admin resources: Beasiswa, Mahasiswa, Pendaftaran, Dokumen, Seleksi, User
├── app/Models/
├── app/Http/Middleware/SecurityHeaders.php
└── database/migrations, seeders
php/  nginx/  db/     # Docker images and config
docker-compose.yml
```

## Author

**Fayza Azzahra** · [GitHub](https://github.com/ffyzhra) · [LinkedIn](https://www.linkedin.com/in/ffyzhra)
