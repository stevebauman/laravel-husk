<?php

use Laravel\Dusk\Browser;
use Tests\Pages\HomePage;

it('loads', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit(new HomePage)->assertSee('Welcome to your Nuxt Application');
    });
});
