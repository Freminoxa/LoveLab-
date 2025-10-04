<?php

use Illuminate\Support\Facades\Artisan;

uses(Tests\TestCase::class)->in('Feature', 'Unit');

// Run migrations before tests
beforeAll(function () {
    Artisan::call('migrate', ['--database' => 'sqlite', '--force' => true]);
});
