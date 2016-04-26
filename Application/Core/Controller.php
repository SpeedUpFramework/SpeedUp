<?php
////////////////////////////////////////////////////////////////////////////////
//                     ___  ____  _____ _____ ____  _                         //
//                    / ___||  _ \| ____| ____|  _ \( )_   _ _ __             //
//                    \___ \| |_) |  _| |  _| | | | |/| | | | '_ \            //
//                    ___) |  __/| |___| |___| |_| | | |_| | |_) |            //
//                   |____/|_|   |_____|_____|____/   \__,_| .__/             //
//                                                        |_|                 //
////////////////////////////////////////////////////////////////////////////////
namespace Core;
use Widgets\Session;

class Controller {

  public function __construct()
  {
    $this->loader = new \Twig_Loader_Filesystem("Application/Views");
    $this->twig = new \Twig_Environment($this->loader, array(
    //'cache' => DIR.'cache',
        ));
        $this->twig->addGlobal('theme', TEMPLATE);
        $this->twig->addGlobal('admin', TEMPLATE_ADMIN);
        $this->twig->addGlobal('site', DIR);
      //Global sessions
        $this->twig->addGlobal('Username', Session::get("Username"));
        $this->twig->addGlobal('Grade', Session::get("Grade"));
  }
}


 ?>
