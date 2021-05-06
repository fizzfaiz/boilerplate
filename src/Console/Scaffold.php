<?php

namespace Sebastienheyd\Boilerplate\Console;

use FilesystemIterator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Scaffold extends BoilerplateCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boilerplate:scaffold {--r|remove : restore configuration and files to the original state}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold all files to Laravel application';

    /**
     * @var Filesystem
     */
    private $fileSystem;

    /**
     * Create a new command instance.
     */
    public function __construct(Filesystem $fileSystem)
    {
        parent::__construct();
        $this->fileSystem = $fileSystem;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->title();

        if ($this->option('remove')) {
            $this->remove();
        } else {
            $this->install();
        }
    }

    private function install()
    {
        $this->warn('-------------------------------------------------------------------------------------------------------------------------------');
        $this->warn(' This command will install files in your project and configure your project to customize the use of sebastienheyd/boilerplate. ');
        $this->warn('-------------------------------------------------------------------------------------------------------------------------------');

        if (! $this->confirm('Continue?')) {
            return;
        }

        $this->publishRoutes();
        $this->publishControllers();
        $this->publishModels();
        $this->publishEvents();
        $this->publishNotifications();
        $this->call('vendor:publish', ['--tag' => ['boilerplate', 'boilerplate-views', 'boilerplate-lang']]);

        try {
            if (Schema::hasTable('role_user')) {
                $this->info('Updating user_type in database complete');
                DB::table('role_user')
                    ->where('user_type', 'Sebastienheyd\Boilerplate\Models\User')
                    ->update(['user_type' => 'App\Models\Boilerplate\User']);
            }
        } catch (\Exception $e) {
        }
    }

    private function remove()
    {
        $this->warn('---------------------------------------------------------------------------------------');
        $this->warn(' This command will remove all files published by boilerplate:scaffold in your project. ');
        $this->warn('---------------------------------------------------------------------------------------');

        if (! $this->confirm('Continue?')) {
            return;
        }

        $this->fileSystem->delete(base_path('routes/boilerplate.php'));
        $this->fileSystem->deleteDirectory(app_path('Http/Controllers/Boilerplate'));
        $this->fileSystem->deleteDirectory(app_path('Models/Boilerplate'));
        $this->fileSystem->deleteDirectory(app_path('Events/Boilerplate'));
        $this->fileSystem->deleteDirectory(app_path('Notifications/Boilerplate'));
        $this->fileSystem->deleteDirectory(resource_path('lang/vendor/boilerplate'));
        $this->fileSystem->deleteDirectory(resource_path('views/vendor/boilerplate'));

        $this->replaceInFile([
            'App\Models\Boilerplate' => 'Sebastienheyd\Boilerplate\Models',
        ], config_path('boilerplate/laratrust.php'));

        $this->replaceInFile([
            'App\Models\Boilerplate' => 'Sebastienheyd\Boilerplate\Models',
        ], config_path('boilerplate/auth.php'));

        $this->replaceInFile([
            '\App\Http\Controllers\Boilerplate' => '\Sebastienheyd\Boilerplate\Controllers',
        ], config_path('boilerplate/menu.php'));

        try {
            if (Schema::hasTable('role_user')) {
                $this->info('Updating user_type in database complete');
                DB::table('role_user')
                    ->where('user_type', 'App\Models\Boilerplate\User')
                    ->update(['user_type' => 'Sebastienheyd\Boilerplate\Models\User']);
            }
        } catch (\Exception $e) {
        }
    }

    private function publishRoutes()
    {
        $to = base_path('routes/boilerplate.php');
        $this->copy(__DIR__.'/../routes/boilerplate.php', $to);
        $this->replaceInFile(['\Sebastienheyd\Boilerplate\Controllers' => '\App\Http\Controllers\Boilerplate'], $to);
    }

    private function publishControllers()
    {
        $to = app_path('Http/Controllers/Boilerplate');
        $this->copy(__DIR__.'/../Controllers', $to);

        $files = $this->fileSystem->allFiles($to);

        foreach ($files as $file) {
            $this->replaceInFile([
                'Sebastienheyd\Boilerplate\Controllers' => 'App\Http\Controllers\Boilerplate',
                'Sebastienheyd\Boilerplate\Models' => 'App\Models\Boilerplate',
            ], $file->getRealPath());
        }

        $this->replaceInFile([
            '\Sebastienheyd\Boilerplate\Controllers' => '\App\Http\Controllers\Boilerplate',
        ], config_path('boilerplate/menu.php'));
    }

    private function publishModels()
    {
        $to = app_path('Models/Boilerplate');
        $this->copy(__DIR__.'/../Models', $to);

        $files = $this->fileSystem->allFiles($to);

        foreach ($files as $file) {
            $this->replaceInFile([
                'Sebastienheyd\Boilerplate\Models' => 'App\Models\Boilerplate',
                'Sebastienheyd\Boilerplate\Events' => 'App\Events\Boilerplate',
                'Sebastienheyd\Boilerplate\Notifications' => 'App\Notifications\Boilerplate',
            ], $file->getRealPath());
        }

        $this->replaceInFile([
            'Sebastienheyd\Boilerplate\Models' => 'App\Models\Boilerplate',
        ], config_path('boilerplate/laratrust.php'));

        $this->replaceInFile([
            'Sebastienheyd\Boilerplate\Models' => 'App\Models\Boilerplate',
        ], config_path('boilerplate/auth.php'));
    }

    private function publishEvents()
    {
        $to = app_path('Events/Boilerplate');
        $this->copy(__DIR__.'/../Events', $to);

        $files = $this->fileSystem->allFiles($to);

        foreach ($files as $file) {
            $this->replaceInFile([
                'Sebastienheyd\Boilerplate\Events' => 'App\Events\Boilerplate',
                'Sebastienheyd\Boilerplate\Models' => 'App\Models\Boilerplate',
            ], $file->getRealPath());
        }
    }

    private function publishNotifications()
    {
        $to = app_path('Notifications/Boilerplate');
        $this->copy(__DIR__.'/../Notifications', $to);

        $files = $this->fileSystem->allFiles($to);

        foreach ($files as $file) {
            $this->replaceInFile([
                'Sebastienheyd\Boilerplate\Notifications' => 'App\Notifications\Boilerplate',
            ], $file->getRealPath());
        }
    }

    /**
     * Replace content in the given file.
     *
     * @param array $values
     * @param string $file
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function replaceInFile($values, $file)
    {
        $content = $this->fileSystem->get($file);
        foreach ($values as $from => $to) {
            $content = str_replace($from, $to, $content);
        }
        $this->fileSystem->put($file, $content);
    }

    /**
     * Copy a file or a directory and display a message.
     *
     * @param string $from
     * @param string $to
     */
    private function copy($from, $to)
    {
        if (is_dir($from)) {
            $type = 'Directory';
            $this->copyDirectory($from, $to);
        } else {
            $type = 'File';
            if (! $this->fileSystem->exists($to)) {
                $this->fileSystem->copy($from, $to);
            }
        }

        $from = str_replace(base_path(), '', realpath($from));
        $to = str_replace(base_path(), '', realpath($to));
        $this->line('<info>Copied '.$type.'</info> <comment>['.$from.']</comment> <info>To</info> <comment>['.$to.']</comment>');
    }

    /**
     * Secure copy that will not override existing files.
     *
     * @param string $directory
     * @param string $destination
     *
     * @return bool
     */
    private function copyDirectory($directory, $destination)
    {
        if (! $this->fileSystem->isDirectory($directory)) {
            return false;
        }

        $this->fileSystem->ensureDirectoryExists($destination, 0777);

        $items = new FilesystemIterator($directory, FilesystemIterator::SKIP_DOTS);

        foreach ($items as $item) {
            $target = $destination.'/'.$item->getBasename();

            if ($item->isDir()) {
                $path = $item->getPathname();

                if (! $this->copyDirectory($path, $target)) {
                    return false;
                }
            } else {
                if (! $this->fileSystem->exists($target)) {
                    if (! $this->fileSystem->copy($item->getPathname(), $target)) {
                        return false;
                    }
                }
            }
        }

        return true;
    }
}