<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Processus;
use Illuminate\Support\Facades\Storage;
use App\Http\Traits\FileManagement;

class InitStorage extends Command
{
    use FileManagement;

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
        if ($this->confirm('Do you wish to delete existing directories? [yes|no]', true)) {
            $count=0;
            foreach (Storage::cloud()->allDirectories() as $dir) {
                Storage::cloud()->deleteDirectory($dir);
                $count++;
            }
            
            $this->info( $count.' directories are deleted');
        }
        
        foreach (Processus::all() as $proc) {
            $name = strtolower(str_replace(' ', '_', trim($proc->name)));
            Storage::cloud()->makeDirectory($name);
            $this->info( $name.' are created');
        }

        if($this->confirm('Do you wish to generate archive directory? [yes|no]', true)){
            Storage::cloud()->makeDirectory('archive');
            $archId = $this->getDirectoryId('archive');
            foreach (Processus::all() as $proc) {
                $name = strtolower(str_replace(' ', '_', trim($proc->name)));
                Storage::cloud()->makeDirectory($archId."/".$name);
                $this->info( $name.' are created');
            }
        }
        return 0;
    }
}
