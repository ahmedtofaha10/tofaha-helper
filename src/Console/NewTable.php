<?php


namespace Tofaha\Helper\Console;


use Illuminate\Console\GeneratorCommand;

class NewTable extends GeneratorCommand
{
    protected $name = 'tofaha:table';
    protected $signature = 'tofaha:table {name} ';
    protected $description = 'Create a new TofahaTable class';

    protected $type = 'TofahaTable';

    protected function getStub()
    {
        return __DIR__ . '/stubs/table.php.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\TofahaTables';
    }

    public function handle()
    {
        parent::handle();

        $this->doOtherOperations();
        $this->info('checkout App\TofahaTables Directory Habibi ^_^');
    }

    protected function doOtherOperations()
    {
        $name = $this->argument('name');
        $model = $this->option('model');
        $baseModel = class_basename($model);
        // Get the fully qualified class name (FQN)
        $class = $this->qualifyClass($this->getNameInput());

        // get the destination path, based on the default namespace
        $path = $this->getPath($class);

        $content = file_get_contents($path);
        $content = str_replace('$![name]',$name,$content);
        // Update the file content with additional data (regular expressions)

        file_put_contents($path, $content);
    }
}
