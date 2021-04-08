<?php


namespace Tofaha\Helper\Console;


use Illuminate\Console\Command;

class InstallHelperPackage extends Command
{
    protected $signature = 'tofaha:install';

    protected $description = 'install the package';

    public function handle()
    {
        $this->info('Installing Tofaha Package...');

        $this->info('Publishing views... ^_^ ');

        $this->call('vendor:publish', [
            '--provider' => "Tofaha\Helper\Services\TableServiceProvider",
            '--tag' => "views"
        ]);
        $this->info('TofahaHelper Installed .. Mabrouk ya beh <3 ');
    }
}
