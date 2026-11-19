# URL Shortener (Laravel 13)
A multi-company URL shortener with SuperAdmin, Admin and Member roles.
## Requirements
- PHP (version as required by composer.json), Composer
- SQLite (default) or MySQL
## Setup
1.git clone <repo-url>,cd <repo-folder>
2.composer install
3.cp .env.example .env
4.php artisan key:generate
5.touch database/database.sqlite
6.php artisan migrate --seed
7.php artisan serve
8.Open http://localhost:8000
# SuperAdmin
- Email: superadmin@url.com
- Password: Admin@123
# How it works
- SuperAdmin invites a new client (company + its first Admin).
- Admin can invite Admin/Member in their own company.
- Invitation links are listed under "Pending Invitations" on the dashboard (no mail setup needed).
- Admin and Member can generate short URLs. SuperAdmin cannot.
- SuperAdmin sees URLs of all companies, Admin sees URLs of own company, Member sees only own URLs.
- Short URLs (`/s/{code}`) are public and redirect to the original URL.
# AI usage
- I used Claude (AI) as a helper to plan the project, write the first draft of the code and tests, and fix errors.
- I set up and ran the project myself, tested all role flows in the browser, and made changes like the SuperAdmin login and the pending invitations list.