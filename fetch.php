<?php
class mysqli{
    private static $_inkInstance;
    private static $_Source;
    private static $a_config=array(
        'Host'=>'localhost',
        'User'=>'root',
        'Password'=>'root',
        'database'=>'database'
    );
   function __construct(){
       
   }
   public static function getInstance(){
       if(!self::$_inkInstance instanceof  self){
           self::$_inkInstance=new self();
           
       }
       return self::$_inkInstance;
   }
   public function connect(){
       $link=@mysqli_connect(self::$a_config['Host'],self::$a_config['User'],self::$a_config['Password'],self::$a_config['database']);
       
       try {
           if(!$link){
               mysqli_query($link, "set names utf8");
               self::$_Source=$link;
           }
           return self::$_Source;
           
       }catch (Exception $e){
           throw new Exception("connected failed");
       }
   }
}