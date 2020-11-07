<?php

namespace Kineticamobile\Duna\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Kineticamobile\Duna\Duna;
use Kineticamobile\Lumki\Facades\Lumki;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\Process\Process;

/**
 * Setup Lumki package
 *
 * @author raultm
 **/
class CreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'duna:create {name : The Name of the App}';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Prepare all assets/views/routes for a new pwa/spa/app project.';

    public function handle(): void
    {
        $name = Str::lower(Str::snake($this->argument('name')));
        $this->info("App Code : $name");

        // Views in {app}/resources/vendors/kineticamobile/duna/$name
        $packageViewsPath = Duna::folder('/resources/views');
        $viewsPath = base_path("resources/views/vendor/duna/$name");
        $packageAssetsPath = Duna::folder('/assets');
        $assetsPath = base_path("public/duna/$name");
        $packageRoutesPath = Duna::folder('/approutes');
        $routesPath = base_path("routes/vendors/kineticamobile/duna/$name");

        $this->replaceArray([
            '{{ route("duna.mobile.tailwind", $mobile) }}' => '{{ route("duna.mobile.tailwind") }}',
            '{{ route("duna.mobile.sw-register-helpers", $mobile) }}' => '{{ route("duna.mobile.sw-register-helpers") }}',
            '{{ route("duna.mobile.idbKeyval", $mobile) }}' => '{{ route("duna.mobile.idbKeyval") }}',
            '{{ route("duna.mobile.axios", $mobile) }}' => '{{ route("duna.mobile.axios") }}',
            '{{ route("duna.mobile.sql", $mobile) }}' => '{{ route("duna.mobile.sql") }}',
            '{{ route("duna.mobile.index", $mobile) }}' => '{{ route("duna.mobile.index") }}',
            '{{ route("duna.mobile.basic", $mobile) }}' => '{{ route("duna.mobile.basic") }}',
            '{{ route("duna.mobile.manifest", $mobile) }}' => '{{ route("duna.mobile.manifest") }}',
            '{{ route("duna.mobile.dashboard", $mobile) }}' => '{{ route("duna.mobile.dashboard") }}',
            '{{ route("duna.mobile.bg", $mobile) }}' => '{{ route("duna.mobile.bg") }}',
            '{{ route("duna.mobile.alt-bg", $mobile) }}' => '{{ route("duna.mobile.alt-bg") }}',
            '{{ route("duna.mobile.profile-image", $mobile) }}' => '{{ route("duna.mobile.profile-image") }}',
            '{{ route("duna.mobile.profile-desktop", $mobile) }}' => '{{ route("duna.mobile.profile-desktop") }}',
            '{{ $mobile }}' => $name,
            'duna::' => "duna::$name.",
            'duna.mobile.' => "duna.$name.",
            ':lc:appname' => $name,
            //'{{ route("duna.mobile.manifest", $mobile) }}' => '{{ route("duna.mobile.manifest") }}',
            //'{{ route("duna.mobile.basic", $mobile) }}' => '{{ route("duna.mobile.basic") }}',

        ]);

        if( is_dir($viewsPath) )  {
            $this->info("Views of '$name' already created.");
        } else {
            $this->info("Views of '$name' not created.");
            $this->copyfolder($packageViewsPath, $viewsPath);
            $this->fill($viewsPath);
        }

        // Assets in {public}/duna/$name
        if( is_dir($assetsPath) ) {
            $this->info("Assets of '$name' already created.");
        } else {
            $this->info("Assets of '$name' not created.");
            $this->copyfolder($packageAssetsPath, $assetsPath);
            $this->fill($assetsPath);
        }

        // Routes in {routes}/duna/api.php | web.php
        if( is_dir($routesPath) ) {
            $this->info("Routes of '$name' already created.");
        } else {
            $this->info("Routes of '$name' not created.");
            $this->copyfolder($packageRoutesPath, $routesPath);
            $this->fill($routesPath);
        }

    }

    public $placeholders = [];

    public $replacements = [];

    private function directories($path)
    {
        return glob($path . '*' , GLOB_ONLYDIR);
    }

    public function replaceArray($replaces)
    {
        $this->replace(array_keys($replaces), array_values($replaces));
        return $this;
    }

    public function replace($placeholder, $replacement)
    {
        if (is_array($placeholder)) {
            $this->placeholders = array_merge($this->placeholders, $placeholder);
        } else {
            $this->placeholders[] = $placeholder;
        }
        if (is_array($replacement)) {
            $this->replacements = array_merge($this->replacements, $replacement);
        } else {
            $this->replacements[] = $replacement;
        }

        return $this;
    }

    public function fill($path)
    {
        $files = new RecursiveDirectoryIterator($path);
        foreach (new RecursiveIteratorIterator($files) as $file) {
            if (! $file->isFile()) {
                continue;
            }

            $this->fillInFile($file->getPath().'/'.$file->getFilename());
        }
    }

    public function fillInFile($template, $destination = null)
    {
        $destination = ($destination === null) ? $template : $destination;

        $filledFile = str_replace($this->placeholders, $this->replacements, file_get_contents($template));
        file_put_contents($destination, $filledFile);

        return $this;
    }

    private function copyfolder($source, $dest, $permissions = 0755)
    {
        $sourceHash = $this->hashDirectory($source);
        // Check for symlinks
        if (is_link($source)) {
            return symlink(readlink($source), $dest);
        }

        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $dest);
        }

        // Make destination directory
        if (!is_dir($dest)) {
            mkdir($dest, $permissions, true);
        }

        // Loop through the folder
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            // Deep copy directories
            if($sourceHash != $this->hashDirectory($source."/".$entry)){
                $this->copyfolder("$source/$entry", "$dest/$entry", $permissions);
            }
        }

        // Clean up
        $dir->close();
        return true;
    }

    function hashDirectory($directory){
        if (! is_dir($directory)){ return false; }

        $files = array();
        $dir = dir($directory);

        while (false !== ($file = $dir->read())){
            if ($file != '.' and $file != '..') {
                if (is_dir($directory . '/' . $file)) { $files[] = $this->hashDirectory($directory . '/' . $file); }
                else { $files[] = md5_file($directory . '/' . $file); }
            }
        }

        $dir->close();

        return md5(implode('', $files));
    }

}
