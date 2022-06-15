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

Artisan::command('project:fresh_db', function(){
    Artisan::call('migrate:fresh');
    if ($this->confirm('Do you want to seed db ? [yes|no]', true)) {
        Artisan::call('db:seed TestSeeder');
    }
    Artisan::call('orchid:admin', ['name'=>'admin', 'email'=>'cagier008@gmail.com', 'password'=>'gcNwJp4aK0Yqfx']);
})->describe('fresh db seeded and admin user ready for dev env');

Artisan::command('project:init', function(){
    Artisan::call('project:fresh_db');
    if ($this->confirm('Do you want to init storage ? [yes|no]', true)) {
        Artisan::call('project:init_storage');
    }
})->describe('Init db and file system structure');