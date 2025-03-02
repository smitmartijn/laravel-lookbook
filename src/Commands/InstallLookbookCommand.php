<?php

namespace LaravelLookbook\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallLookbookCommand extends Command
{
    protected $signature = 'lookbook:install';
    protected $description = 'Install the Lookbook package and publish assets and configuration';

    public function handle()
    {
        $this->info('Installing Lookbook...');

        // Publish configuration file
        $this->call('vendor:publish', [
            '--provider' => 'LaravelLookbook\LookbookServiceProvider',
            '--tag' => 'lookbook-config',
        ]);

        // Publish assets
        $this->call('vendor:publish', [
            '--provider' => 'LaravelLookbook\LookbookServiceProvider',
            '--tag' => 'lookbook-assets',
        ]);

        // Publish views
        $this->call('vendor:publish', [
            '--provider' => 'LaravelLookbook\LookbookServiceProvider',
            '--tag' => 'lookbook-views',
        ]);
        $this->info('Views published successfully..');

        // Create the lookbook directory structure
        $this->createDirectoryStructure();

        $this->info('Lookbook installed successfully.');
    }

    protected function createDirectoryStructure()
    {
        $lookbookPath = resource_path('lookbook');

        // Create the base directory
        if (!File::isDirectory($lookbookPath)) {
            File::makeDirectory($lookbookPath, 0755, true);
            $this->info('Created lookbook directory at resources/lookbook');
        }
    }
}
