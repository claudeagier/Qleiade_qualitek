<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \Google_Service_Drive as DriveService;
use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;
use League\Flysystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Google\Client as GoogleClient;

class GoogleDriveServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('google', function ($app, $config) {
            $credentials_file = base_path($config['credentialsFile']);

            $client = new GoogleClient();
            $client->setScopes(DriveService::DRIVE);
            $client->setAuthConfig($credentials_file);
            $client->useApplicationDefaultCredentials();
            $client->setAuthConfig($credentials_file);
            $client->setAccessType('offline');


            $service = new DriveService($client);

            $options = [];
            $options['defaultParams'] = [
                'files.list' =>
                [
                    'driveId' => $config['folderId'],
                    'includeItemsFromAllDrives' => true,
                    'corpora' => 'drive',
                    'supportsAllDrives' => true
                ]
            ];
            if (isset($config['teamDriveId'])) {
                $options['teamDriveId'] = $config['teamDriveId'];
            }

            $adapter = new GoogleDriveAdapter($service, $config['folderId'], $options);

            return new Filesystem($adapter);
        });
    }
}
