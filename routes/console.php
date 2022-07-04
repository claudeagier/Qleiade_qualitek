<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

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

//DOC: artisan command project:fresh_db
Artisan::command('project:fresh_db', function(){
    Artisan::call('migrate:fresh');
    if ($this->confirm('Do you want to seed db ? [yes|no]', true)) {
        Artisan::call('db:seed DatabaseSeeder');
    }
    Artisan::call('orchid:admin', ['name'=>env('ORCHID_USER_ADMIN_NAME'), 'email'=>env('ORCHID_USER_ADMIN_MAIL'), 'password'=>env('ORCHID_USER_ADMIN_PASSWORD')]);
})->describe('fresh db seeded and admin user ready for dev env');
