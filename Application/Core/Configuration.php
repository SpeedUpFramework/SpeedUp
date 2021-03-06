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



 use Widgets\Url;
 use Widgets\Session;
 use Illuminate\Database\Capsule\Manager as Capsule;
 use Illuminate\Events\Dispatcher;
 use Illuminate\Container\Container;

 class Configuration{

   public function __construct(){
     define('DIR', '/Audrey/');
     define('TEMPLATE', DIR.'/Application/Template/Default/');
     define('TEMPLATE_ADMIN', DIR.'/Application/Template/Admin/');



     Session::init();
     $capsule = new Capsule;

     $capsule->addConnection(array(
         'driver'    => 'mysql',
         'host'      => 'localhost',
         'database'  => 'Audrey',
         'username'  => 'root',
         'password'  => 'root',
         'charset'   => 'utf8',
         'collation' => 'utf8_unicode_ci',
         'prefix'    => ''
     ));

     $capsule->setEventDispatcher(new Dispatcher(new Container));

     // Make this Capsule instance available globally via static methods... (optional)
     $capsule->setAsGlobal();

     // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
     $capsule->bootEloquent();




      }
   }


 ?>
