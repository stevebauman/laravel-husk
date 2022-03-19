# Laravel Husk

A thin wrapper around Laravel Dusk, allowing you to test your JavaScript applications with Pest.

## Examples

| JS Framework                                                 | Tests                                                                                                         |
| ------------------------------------------------------------ | ------------------------------------------------------------------------------------------------------------- |
| [NuxtJS](https://github.com/stevebauman/laravel-husk-nuxt)   | ![Nuxt Tests](https://github.com/stevebauman/laravel-husk-nuxt/actions/workflows/run-tests.yml/badge.svg)     |
| [NextJS](https://github.com/stevebauman/laravel-husk-next)   | ![Next Tests](https://github.com/stevebauman/laravel-husk-next/actions/workflows/run-tests.yml/badge.svg)     |
| [Svelte](https://github.com/stevebauman/laravel-husk-svelte) | ![Svelte Tests](https://github.com/stevebauman/laravel-husk-svelte/actions/workflows/run-tests.yml/badge.svg) |
| [Gatsby](https://github.com/stevebauman/laravel-husk-gatsby) | ![Gatsby Tests](https://github.com/stevebauman/laravel-husk-gatsby/actions/workflows/run-tests.yml/badge.svg) |

## Installation

Inside of your JavaScript application folder, run the below command to scaffold the Laravel Husk environment inside of your JavaScript application:

> **Note**: This will create the folder named `browser` which will contain your Laravel Husk test environment.

```bash
composer create-project stevebauman/laravel-husk browser
```

## Folder Structure

After scaffolding the test environment, y

```
javascript-app/
├── ...
└── browser/
    └── tests/
        ├── ExampleTest.php
        ├── DuskTestCase.php
        └── Pages/ExamplePage.php
```

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
