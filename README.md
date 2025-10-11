# FundGuardian

A modern, theme-aware personal finance dashboard built with PHP, MySQL, Bootstrap, and Chart.js. It supports light/dark themes (blue/navy palette with gradients), registration/login, a rich animated dashboard with multiple charts, advanced filters, CSV/PDF export, budget tracking, printing, and session-based authentication.

## Features
- Authentication: Register, Login, Logout (PHP sessions)
- Dashboard: Summary cards (Income, Expenses, Balance)
- Transactions: Add, list recent, delete
- Charts: Income vs Expenses (Pie), Category breakdown (Doughnut), Monthly trend (Line), Spending profile (Radar)
- Filters: Search, Type, Category (updates stats, charts, lists, and CSV export)
- CSV Export: Export current filtered transactions; dates normalized to YYYY-MM-DD
- Theming: Light/Dark with persisted preference, blue/navy UI palette

## Tech Stack
- PHP 8+ (sessions, PDO in auth.php/api.php)
- MySQL 5.7+/MariaDB 10+
- Bootstrap 5.3, Font Awesome 6.4
- Chart.js (latest)
- jsPDF 2.5.1 (for PDF generation)

## Project Structure
- index.php — Auth UI: sign in/sign up, dark/light theme toggle, password strength validation
- dashboard.php — Main dashboard UI: navbar, sidebar navigation, animated charts, transaction form, recent activity list, modals (inline styles/scripts for compactness)
- auth.php — Authentication endpoints (login/register/logout)
- api.php — Transactions API (get/add/delete), user-specific queries

## Prerequisites
- XAMPP with PHP + MySQL
- phpMyAdmin for database setup

## Setup
1. Place this folder under your web root, e.g. `C:\xampp\htdocs\FundGuardian`.
2. Create the database and tables:
```
CREATE DATABASE IF NOT EXISTS budget_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE budget_db;

CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(191) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS transactions (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  description VARCHAR(255) NOT NULL,
  amount DECIMAL(12,2) NOT NULL,
  type ENUM('income','expense') NOT NULL,
  category VARCHAR(100) NOT NULL,
  date DATE NOT NULL DEFAULT (CURRENT_DATE),
  INDEX idx_user_date (user_id, date),
  CONSTRAINT fk_tx_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```
3. Configure database credentials if needed:
   - `auth.php` and `api.php` default to: host `localhost`, db `budget_db`, user `root`, password empty (XAMPP default). Update if your environment differs.
4. Start Apache and MySQL via XAMPP. Visit:
   - `http://localhost/FundGuardian/loading.php`

## Usage
- Register an account, then sign in to access the dashboard.
- Add Transactions: Use the "New Transaction" card or sidebar quick actions, supports income/expense with categories.
- View & Filter: Recent activity auto-updates; use toolbar for search/type/category filters.
- Manage Budgets: Navigate to "Budgets" modal to set monthly limits per category, progress tracks against expenses.
- Reports: Click "Reports" in sidebar for CSV export, print dashboard (optimized for clarity), or PDF generation (includes stats and recent transactions).
- Theme & Settings: Toggle dark/light via navbar moon/sun icon, settings modal for preferences (e.g., animations).
- Exports and prints respect current filters, budgets persist across sessions.

## API Overview
- `POST auth.php` with `action=register|login|logout`
  - register: `name, email, password`
  - login: `email, password`
  - responses: `{ success: boolean, message?: string }`
- `GET api.php?action=get_transactions` → `{ success, transactions: [{id, description, amount, type, category, date}] }`
- `POST api.php` with `action=add_transaction` and `description, amount, type, category`
- `POST api.php` with `action=delete_transaction` and `id`

## Security Notes
- Passwords hashed using PHP `password_hash`
- PDO prepared statements prevent SQL injection
- Session-based auth protects API/dashboard, user-specific transaction queries

## Theming
- CSS custom properties for light/dark modes (blue/navy gradients, shadows, accents)
- Charts auto-adapt colors for theme (e.g., text/grid lines, legends)
- Responsive: Mobile-optimized with stacked layouts and touch-friendly buttons

## CSV Export
- Includes headers: ID, Description, Amount, Type, Category, Date (normalized to YYYY-MM-DD)
- Filtered data only, amounts as decimals for easy import to spreadsheets

## PDF Report
- Generated client-side: Title, stats (income/expenses/balance), recent transactions list, generation date
- Simple text layout, saves as `budget_report.pdf`

## Print Dashboard
- Custom `@media print` CSS: Hides UI elements (navbar/sidebar/modals), forces black/white with borders, preserves chart colors
- Ensures clear, readable output on paper/PDF via browser print

## Troubleshooting
- Database connection issues: verify MySQL is running and credentials in `auth.php`/`api.php`
- Auth Errors: Clear browser cookies/sessions, inspect Network tab for 500 errors.
- Charts Empty: Add transactions first; check console for Chart.js errors or API failures.
- PDF/Print Fails: Ensure jsPDF loads (CDN), test in modern browser (Chrome/Firefox).
- Theme Not Persisting: Check localStorage in dev tools, disable ad-blockers if CDNs blocked.

## License
This project is licensed under the MIT License. See `LICENSE`.

## Credits
- Bootstrap 5.3, Chart.js, Font Awesome 6.4, jsPDF 2.5.1
- Google Fonts (Inter) for typography
