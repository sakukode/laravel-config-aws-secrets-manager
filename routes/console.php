<?php

use Illuminate\Support\Env;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('test:env', function () {
    // putenv('DEBUG_FOOBAR="true"');
    echo env('DEBUG_FOOBAR');

    Env::getRepository()->set('DEBUG_FOOBAR', "123");

    dd(config('test.foo'));
});
