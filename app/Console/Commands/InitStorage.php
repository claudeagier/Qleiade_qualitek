<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Processus;
use Illuminate\Support\Facades\Storage;

class InitStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:init_storage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initalize directories structure according to the processus in db';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        foreach (Storage::cloud()->allDirectories() as $dir) {
            Storage::cloud()->deleteDirectory($dir);
        }

        foreach  (Processus::all() as $proc){
            $name = strtolower(str_replace(' ', '_', trim($proc->name)));
            Storage::cloud()->makeDirectory($name);
        }
        return 0;
    }
}
