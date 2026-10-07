# MMJ Greenland dashboard — dev environment notes

Plain PHP (no framework, no Composer dependencies) + MySQL. Runs via
`docker-compose.base44.yml`: a PHP 8.2 dev server on host port 3000 plus a
MySQL 8 service.

## Non-obvious setup facts

- `mysqli` is **not** in the official `php:8.2-cli` image, so `Dockerfile.base44`
  installs it with `docker-php-ext-install mysqli`. Anything that uses mysqli
  (all of `config.php`, `db.php` and the entry points) needs that image.
- The source is bind-mounted at `/app` and served by PHP's built-in server
  (`php -S 0.0.0.0:3000 -t /app`). There is no build step and no hot-reload
  daemon — every request re-reads the files from disk, so edits are live on the
  next page load.
- The app originally pointed at a remote cPanel MySQL host that no longer
  resolves. `config.php` now reads `DB_HOST`/`DB_NAME`/`DB_USER`/`DB_PASS` from
  the environment (falling back to the local dev values) and is the single
  source of truth: `db.php`, `dashboard.php`, `fetch_sales.php`, `verify.php`
  and `export_csv.php` all `require_once 'config.php'`. Do not re-introduce
  hardcoded credentials in those files.
- The local MySQL credentials are development infrastructure, not secrets —
  they live inline under the `db` service in compose and match the fallbacks in
  `config.php`.
- `docker/initdb/01-schema.sql` creates `users` and `land_sales` and seeds sample
  rows. It only runs when the `db_data` volume is empty, i.e. on first start.
  To re-seed from scratch: `docker compose -f docker-compose.base44.yml down -v`
  then `up -d` (this deletes local data).

## Entry points

- `/index.php` is the login/register page. It contains PHP, so it must be served
  as `.php` — `login.php`, `register.php`, `logout.php` and `verify.php` all
  redirect back to `index.php`.
- `/dashboard.php` is the sales dashboard and requires a session (`index.php` →
  `login.php` → `dashboard.php`).
- Seed login: `admin@mmj.test` / `green123` (matches `users.txt`).
- `/dashboard.html`, `/account.html` and `/admin.html` are older static pages kept
  in the repo; `account.html` posts `new_username`/`new_password` while
  `update_account.php` expects `name`/`email`/`password`, so that page is not part
  of the working flow. `admin.html` relies on a `role` session key nothing sets.

## How to verify

```sh
curl -s -o /dev/null -w '%{http_code}\n' http://localhost:3000/          # 200, login page
curl -s -c /tmp/j -b /tmp/j -d 'email=admin@mmj.test&password=green123' \
     http://localhost:3000/login.php                                     # 302 -> dashboard.php
curl -s -b /tmp/j http://localhost:3000/dashboard.php | grep 'Total Contracts'  # 12
curl -s http://localhost:3000/fetch_sales.php                            # JSON with daily/weekly/monthly
```

Container logs: `docker compose -f docker-compose.base44.yml logs -f web`.
