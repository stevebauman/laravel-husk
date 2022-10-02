# Laravel Husk

Larvel Husk is a thin and light scaffolded Laravel Dusk environment.

It allows you to test your JavaScript applications with PHP using [Pest](https://pestphp.com), without having to scaffold an entire Laravel application.

## Examples

| JS Framework                                                     | Tests                                                                                                             |
| ---------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------- |
| [NuxtJS](https://github.com/stevebauman/laravel-husk-nuxt)       | ![Nuxt Tests](https://github.com/stevebauman/laravel-husk-nuxt/actions/workflows/run-tests.yml/badge.svg)         |
| [NextJS](https://github.com/stevebauman/laravel-husk-next)       | ![Next Tests](https://github.com/stevebauman/laravel-husk-next/actions/workflows/run-tests.yml/badge.svg)         |
| [Svelte](https://github.com/stevebauman/laravel-husk-svelte)     | ![Svelte Tests](https://github.com/stevebauman/laravel-husk-svelte/actions/workflows/run-tests.yml/badge.svg)     |
| [Gatsby](https://github.com/stevebauman/laravel-husk-gatsby)     | ![Gatsby Tests](https://github.com/stevebauman/laravel-husk-gatsby/actions/workflows/run-tests.yml/badge.svg)     |
| [Gridsome](https://github.com/stevebauman/laravel-husk-gridsome) | ![Gridsome Tests](https://github.com/stevebauman/laravel-husk-gridsome/actions/workflows/run-tests.yml/badge.svg) |
| [Showcode (NuxtJS)](https://github.com/stevebauman/showcode)     | ![Gridsome Tests](https://github.com/stevebauman/showcode/actions/workflows/run-tests.yml/badge.svg)              |

## Installation

Inside of your JavaScript application folder, run the below command to scaffold the Laravel Husk environment:

> **Note**: This will create the folder named `browser` which will contain your Laravel Husk test environment.

```bash
composer create-project stevebauman/laravel-husk browser
```

After scaffolding the test environment, you should have the below folder structure;

```
javascript-app/
├── ...
└── browser/
    ├── bootstrap/
    ├── config/
    ├── storage/
    │   ├── log/
    │   ├── screenshots/
    │   └── source/
    └── tests/
        ├── ...
        ├── ExampleTest.php
        ├── DuskTestCase.php
        └── Pages/
            └── ExamplePage.php
```

Then, navigate into the `browser` directory and install the Chrome driver by running the below command:

```
php application dusk:chrome-driver --detect
```

## Usage

Before running your dusk tests, be sure to set the proper base URL to where your JavaScript application will be served from:

```php
// tests/DuskTestCase.php

protected function setUp(): void
{
    parent::setUp();

    $this->setupBrowser('http://localhost:3000');
}
```

After setting the base URL, serve your JavaScript application:

```bash
npm run dev
```

Then, inside of another terminal, navigate into the `browser` directory:

```bash
cd browser
```

And run the below command:

> **Important**: Make sure you've installed the Chrome driver first, via `php application dusk:chrome-driver --detect`

```bash
php application pest:dusk
```

> **Note**: You can also insert the below into the `scripts` section of your `package.json` file for a shortcut:
> ```json
> "scripts": {
>     "test": "cd browser && php application pest:dusk"
> }
> ```

## GitHub Actions

You may use the below GitHub action as a template to run your Laravel Dusk tests:

```yaml
name: run-tests

on:
    push:
    pull_request:
    schedule:
        - cron: "0 0 * * *"

jobs:
    run-tests:
        runs-on: ubuntu-latest
        steps:
            - uses: actions/checkout@v2
            - uses: actions/setup-node@v2
              with:
                  cache: "npm"

            - name: Install Javascript Dependencies
              run: npm install

            - name: Start JavaScript Application
              run: npm run dev &

            - name: Install Composer Dependencies
              working-directory: ./browser
              run: composer install --no-progress --prefer-dist --optimize-autoloader

            - name: Upgrade Chrome Driver
              working-directory: ./browser
              run: php application dusk:chrome-driver `/opt/google/chrome/chrome --version | cut -d " " -f3 | cut -d "." -f1`

            - name: Run Dusk Tests
              working-directory: ./browser
              run: php application pest:dusk

            - name: Upload Screenshots
              if: failure()
              uses: actions/upload-artifact@v2
              with:
                  name: screenshots
                  path: browser/storage/screenshots

            - name: Upload Console Logs
              if: failure()
              uses: actions/upload-artifact@v2
              with:
                  name: console
                  path: browser/storage/console
```
