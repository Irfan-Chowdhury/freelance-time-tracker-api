<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $serviceContent =
        "<?php\n\nnamespace App\Services;\n\nclass {$name}\n{\n    // Add your service logic here\n}";

        $filePath = app_path("Services/{$name}.php");

        if (file_exists($filePath)) {
            $this->error("Service {$name} already exists!");
            return;
        }

        file_put_contents($filePath, $serviceContent);

        $this->info("Service {$name} created successfully!");
    }

}