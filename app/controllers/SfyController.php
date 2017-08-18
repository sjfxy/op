<?php
class SfyController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {
        //echo("ss");
        
    }
    public function registerAction()
    {
    $name=$this->request->getPost('name','string');
    $email=$this->request->getPost('email','email');
    $user=new Users();
    $user->name=$name;
    $user->email=$email;
    if($user->save()==true)
    {
        echo "Thanks for register!";
    }else 
   {
        echo "Sorry,the following proboms were gennerated!";
     foreach ($user->getMessages() as $message) 
     {
                echo $message->getMessage(), "<br/>";
     }
   }
  }
}