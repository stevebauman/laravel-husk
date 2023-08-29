<?php

use Laravel\Dusk\Browser;
use Tests\Pages\ExamplePage;

it('loads', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit(new ExamplePage)->assertSee('Hello World');
    });
});