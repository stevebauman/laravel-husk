<?php

use Laravel\Dusk\Browser;

it('loads', function () {
    $this->browse(function (Browser $browser) {
        $browser->assertSee('Text');
    });
});
