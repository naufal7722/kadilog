# Agent Guidance for KasaLog

## Project Overview
- Laravel 13 application running on PHP 8.3.
- UI is rendered by Blade views and `routes/web.php` returns views directly.
- There is currently no `routes/api.php` loaded, and no API-specific controllers exist.
- The app bootstrap uses Laravel 13 style `bootstrap/app.php` with `Application::configure()`.

## API-specific guidance
- If asked to add or modify API behavior, do not assume `api` routes already exist.
- For real API endpoints, add a `routes/api.php` file and update `bootstrap/app.php` to include it via `withRouting(api: __DIR__.'/../routes/api.php')`.
- Use standard Laravel JSON response patterns: `return response()->json(...)`, API resources, or resource controllers.
- Keep API logic separate from the Blade UI routes in `web.php` unless the feature is intentionally shared.
- `App\Http\Controllers` currently contains only the abstract base controller, so new API controllers should be added there.

## Key files
- `routes/web.php` — current frontend route definitions returning Blade views.
- `bootstrap/app.php` — Laravel bootstrap and routing configuration.
- `resources/views/` — Blade templates for UI pages.
- `resources/js/app.js` — global JavaScript utilities and UI interactions.
- `app/Models/` — Eloquent models used by the application.
- `composer.json` and `package.json` — dependencies and scripts.

## Recommended commands
- `composer install`
- `npm install --ignore-scripts`
- `php artisan key:generate`
- `php artisan migrate --force`
- `npm run build`
- `npm run dev`
- `php artisan test`

## Agent instructions
- Prefer minimal changes: avoid altering UI Blade routes unless the task directly targets frontend navigation.
- For API feature requests, explain that the app currently uses only web routes and needs explicit `api` routing support.
- If working on API endpoints, add tests under `tests/Feature` for new JSON responses.
- Do not modify vendor or node modules.
