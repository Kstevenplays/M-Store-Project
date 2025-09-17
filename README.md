# M-Store

A lightweight PHP app for sari-sari store management: sales tracking, inventory, expenses, and optional credits.

## Requirements
- XAMPP (Apache + MySQL)
- PHP 7.4+ (works with 8+)

## Setup (Windows XAMPP)
1. Copy this folder to `C:\xampp\htdocs\M-Store-Project` (already done).
2. Start Apache and MySQL in XAMPP.
3. Create database and tables:
	- Open phpMyAdmin → Import → select `database/schema.sql` → Go.
4. Configure DB if needed in `config/config.php` (defaults: root/no password, DB `m_store`).
5. Set DocumentRoot to `public/` or access via `http://localhost/M-Store-Project/public/`.
6. Ensure Apache `mod_rewrite` is enabled (XAMPP → Apache config → httpd.conf).

## Login
- Default admin: `admin` / `admin` (seeded). Change password later.

## Next Steps
- Build Products CRUD, Sales entry, Expenses, and Dashboard charts.

## Notes
- Uses Bootstrap 5 for UI.
- Router: `public/index.php?route=...`.
