<?php

namespace Tests;

use LaravelZero\Framework\Testing\TestCase;

abstract class DuskTestCase extends TestCase
{
    use CreatesApplication, CreatesBrowser;

    /**
     * Register the base URL with Dusk.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Here you may setup the Chrome browser to execute all
        // Laravel Dusk tests using the below URL as the base.
        $this->setupBrowser('http://localhost:3000');
    }
}
