<?php


namespace Tofaha\Helper\Console;


use Illuminate\Console\GeneratorCommand;

class NewForm extends GeneratorCommand
{
    protected $name = 'tofaha:form';
    protected $signature = 'tofaha:form {name}';
    protected $description = 'Create a new form class';

    protected $type = 'From';

    protected function getStub()
    {
        return __DIR__ . '/stubs/form.php.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Forms';
    }

    public function handle()
    {
        parent::handle();

        $this->doOtherOperations();
        $this->info('checkout App\Forms Directory Habibi ^_^');
    }

    protected function doOtherOperations()
    {
        $name = $this->argument('name');
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
