<?php namespace Tukecx\Base\ThemesManagement\Console\Generators;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeTheme extends Command
{
    /**
     * @var string
     */
    protected $signature = 'theme:create 
        {alias : The alias of the theme}
    ';

    /**
     * @var string
     */
    protected $description = 'Tukecx theme generator.';

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * Array to store the configuration details.
     *
     * @var array
     */
    protected $container = [];

    protected $themeFolderName;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->files = $filesystem;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->container['alias'] = str_slug($this->argument('alias'));

        $this->step1();
    }

    private function step1()
    {
        $this->themeFolderName = str_slug($this->ask('Theme folder name:', $this->container['alias']));
        $this->container['name'] = $this->ask('Name of theme:', 'Tukecx ' . $this->container['alias']);
        $this->container['author'] = $this->ask('Author of theme:');
        $this->container['description'] = $this->ask('Description of theme:', $this->container['name']);
        $this->container['namespace'] = $this->ask('Namespace of theme:', 'Tukecx\\Themes\\' . studly_case($this->container['alias']));
        $this->container['version'] = $this->ask('Theme version.', '1.0');
        $this->container['autoload'] = $this->ask('Autoloading type.', 'psr-4');
        $this->container['require'] = new \stdClass();

        $this->step2();
    }

    private function step2()
    {
        $this->generatingTheme();

        $this->info("\nYour theme generated successfully.");
    }

    private function generatingTheme()
    {
        $directory = tukecx_themes_path($this->themeFolderName);

        $source = __DIR__ . '/../../../resources/stubs/_folder-structure';

        /**
         * Make directory
         */
        $this->files->makeDirectory($directory);
        $this->files->copyDirectory($source, $directory, null);

        /**
         * Replace files placeholder
         */
        $files = $this->files->allFiles($directory);
        foreach ($files as $file) {
            $contents = $this->replacePlaceholders($file->getContents());
            $filePath = tukecx_themes_path($this->themeFolderName . '/' . $file->getRelativePathname());

            $this->files->put($filePath, $contents);
        }

        /**
         * Modify the module.json information
         */
        \File::put($directory . '/module.json', json_encode_prettify($this->container));
    }

    protected function replacePlaceholders($contents)
    {
        $find = [
            'DummyNamespace',
            'DummyAlias',
            'DummyName',
        ];

        $replace = [
            $this->container['namespace'],
            $this->container['alias'],
            $this->container['name'],
        ];

        return str_replace($find, $replace, $contents);
    }
}
