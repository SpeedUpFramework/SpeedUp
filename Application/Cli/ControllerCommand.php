<?php
namespace Cli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Widgets\ReservedWords;

class ControllerCommand extends Command
{
    private $controllerName;
    private $methods;

    protected function configure()
    {
        $this
            ->setName('make:controller')
            ->setDescription('Creer un controller')
            ->addArgument(
                'controllerName',
                InputArgument::REQUIRED,
                'Quel nom désirez vous pour votre controller?'
            )
            ->addArgument(
                'methods',
                InputArgument::IS_ARRAY,
                'Quel méthodes avez vous (Séparez les méthodes par des espaces)?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->controllerName = $input->getArgument('controllerName');
        $this->methods = $input->getArgument('methods');

        $error = null;
        if (in_array($this->controllerName, ReservedWords::getList())) {
            $output->writeln("<error>Le controller ne peux pas avoir un nom réservé</>");
            $error = true;
        }

        if (is_array($this->methods)) {
            foreach ($this->methods as $method) {
                if (in_array($method, ReservedWords::getList())) {
                    $output->writeln("<error>La méthode ($method) ne peux pas avoir un nom réservé</>");
                    $error = true;
                }
            }
        }

        if ($error == true) {
            exit;
        }

        if (!is_dir("Application/Views/".ucwords($this->controllerName))) {
            mkdir("Application/Views/".ucwords($this->controllerName));
        }

        $this->makeViews();
        $this->makeRoutes();
        $this->makeController();

        $output->writeln("<info>Controller ".$this->controllerName." Crée avec ".count($this->methods)." methodes</>");
    }

    private function makeViews()
    {
        if (!is_dir("Application/Views/".ucwords($this->controllerName))) {
            mkdir("Application/Views/".ucwords($this->controllerName));
        }
        if (is_array($this->methods)) {
            foreach ($this->methods as $method) {
                file_put_contents("Application/Views/".ucwords($this->controllerName)."/".ucwords($method.".html.twig"), null);
            }
        }
    }

    public function makeRoutes()
    {
        $methods = null;
        if (is_array($this->methods)) {
            foreach ($this->methods as $method) {
                if ($method == 'index') {
                    $methods .="Router::any('".strtolower($this->controllerName)."', 'Controllers\\".ucwords($this->controllerName)."@$method');\n";
                } else {
                    $methods .="Router::any('".strtolower($this->controllerName)."/$method', 'Controllers\\".ucwords($this->controllerName)."@$method');\n";
                }
            }
            $file = file_get_contents("Application/Core/routes.php");
            $file = str_replace("/** End default routes */", "$methods/** End default routes */", $file);
            file_put_contents("Application/Core/routes.php", $file);
        }
    }

    public function makeController()
    {
        $data = "<?php
////////////////////////////////////////////////////////////////////////////////
//                     ___  ____  _____ _____ ____  _                         //
//                    / ___||  _ \| ____| ____|  _ \( )_   _ _ __             //
//                    \___ \| |_) |  _| |  _| | | | |/| | | | '_ \            //
//                     ___) |  __/| |___| |___| |_| | | |_| | |_) |           //
//                    |____/|_|   |_____|_____|____/   \__,_| .__/            //
//                                                        |_|                 //
////////////////////////////////////////////////////////////////////////////////
namespace Controllers;
use Core\Controller;

use Widgets\Session;
class ".ucwords($this->controllerName)." extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    ";
        if (is_array($this->methods)) {
            foreach ($this->methods as $method) {
                $data .="
    public function $method()
    {
        \$data['title'] = '$method';


        echo \$this->twig->render('".ucwords($this->controllerName)."/".ucwords($method).".html.twig', \$data);

    }\n";
            }
        }
        $data .="}
";
        file_put_contents("Application/Controllers/".ucwords($this->controllerName).".php", $data);
    }
}