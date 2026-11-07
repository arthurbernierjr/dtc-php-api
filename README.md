# Todos API (PHP · Laravel)

A Deeper Than Code backend example by Arthur Bernier Jr. Laravel 13 on PHP 8.4 with Postgres, deployed on Railway.

The repo is an overlay: the Dockerfile runs `composer create-project laravel/laravel:13.11.0` and `php artisan install:api`, then copies `overlay/` over the fresh skeleton. `boot` writes `.env` from the Railway `PG*` variables, runs the migrations, and serves on `$PORT`.

Live: https://api-production-2278d.up.railway.app

## Contract

| Request | Response |
|---|---|
| GET /health | 200 `{"ok":true}` |
| GET /todos | 200 `[{id,subject,details}]` ordered by id |
| GET /todos/:id | 200 object, or 404 `{"error":"not found"}` |
| POST /todos `{subject,details}` | 201 object |
| PUT /todos/:id `{subject,details}` | 200 object, or 404 `{"error":"not found"}` |
| DELETE /todos/:id | 204 empty, or 404 `{"error":"not found"}` |
| blank or missing subject/details | 400 `{"error":"<message>"}` |

Objects carry exactly `id`, `subject`, `details`. CORS is open to any origin. `GET /` is a small HTML page.

## Check it

```
node check.mjs https://api-production-2278d.up.railway.app
```

All 16 checks should print PASS.

## Environment

Read at boot: `PGHOST`, `PGPORT`, `PGDATABASE`, `PGUSER`, `PGPASSWORD` (Railway injects them from the Postgres service) and `PORT` (falls back to 8080). Do not commit `.env` or any secrets.
