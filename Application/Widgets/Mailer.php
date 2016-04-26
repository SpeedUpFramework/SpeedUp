<?php
////////////////////////////////////////////////////////////////////////////////
//                     ___  ____  _____ _____ ____  _                         //
//                    / ___||  _ \| ____| ____|  _ \( )_   _ _ __             //
//                    \___ \| |_) |  _| |  _| | | | |/| | | | '_ \            //
//                    ___) |  __/| |___| |___| |_| | | |_| | |_) |            //
//                   |____/|_|   |_____|_____|____/   \__,_| .__/             //
//                                                        |_|                 //
////////////////////////////////////////////////////////////////////////////////
  namespace Widgets;

  class Mailer{



    public function __construct($mtype, $connect_info=array()){

        $this->mtype = $mtype;
        $this->connect_info = $connect_info;
    }
    public function send($from, $to, $name_from, $sujet , $message, $altmessage)
    {
      $message = \Swift_Message::newInstance(null)
        //Give the message a subject
        ->setSubject($sujet)
        //Set the From address with an associative array
        ->setFrom(array("$from" => "$name_from"))
        //Set the To addresses with an associative array
        ->setTo(array("$to"))
        //Give it a body
        ->setBody("$message")
        //And optionally an alternative body
        ->addPart("$altmessage", 'text/html');

          //Create the Transport
          switch($this->mtype)
          {
            case "smtp":
                        if(!empty(array_filter($this->connect_info)))
                        {

                          $transport = \Swift_SmtpTransport::newInstance()
                                        ->setHost($this->connect_info['hote'])
                                        ->setPort($this->connect_info['port'])
                                        ->setEncryption($this->connect_info['encrypt'])
                                        ->setUsername($this->connect_info['identifiant'])
                                        ->setPassword($this->connect_info['password']);
                        }
                  break;
            case "mail":
                        $transport = \Swift_SmtpTransport::newInstance('127.0.0.1', 25);
                  break;
            default:
                        $transport = \Swift_SmtpTransport::newInstance('127.0.0.1', 25);

          }

          //Create the Mailer using your created Transport
          $mailer = \Swift_Mailer::newInstance($transport);

          //Send the message
          if($mailer->send($message, $fail))
          {
            return true;
          } else {
            print_r($fail);
            return false;
          }
    }
  }
?>
