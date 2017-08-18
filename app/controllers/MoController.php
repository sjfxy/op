<?php
class MoController extends ControllerBase
{
   public function hasAction()
   {
  $robot=Robots::findFirst(2);
  foreach ($robot->getRobotsParts() as $robotparts)
  {
      echo $robotparts->getParts()->name,"\n";
  }
   }
   public function caAction()
   {
      $robot=Robots::findFirst(2);
      $robotsParts=$robot->getRobotsParts();
//       foreach ($robotsParts as $re){
//           echo $re->robots_id.",".$re->parts_id.",".$re->created_at;
//       }
      $robotsParts=$robot->getRobotsParts("created_at='2017-08-23'");
      foreach ($robotsParts as $re){
          echo $re->robots_id.",".$re->parts_id.",".$re->created_at;
      }
      $robotsParts = $robot->getRobotsParts(array(
          "created_at = :date:",
          "bind" => array("date" => "2017-08-23"
          )));
      foreach ($robotsParts as $re){
          echo $re->robots_id.",".$re->parts_id.",".$re->created_at;
      }
      $robotPart=RobotsParts::find();
      //首先根据RobotsParts 获得列表 再进行根据每一个获取 robots 或者parts都可以
      //而这里的robopats是 由Robots获取到 就是根据robots_id进行查询有多少robotsparts
     //然后获得parts robots 都可以
      foreach ($robotPart as $re){
          echo $re->getRobots()->name;
      }
      foreach ($robotPart as $s){
          echo $s->getParts()->name;
      }
      $conditions="name=:name:";
      $robots=Robots::find(
          array(
              $conditions,
              "bind"=>array('name'=>'22')
          )
          );
      $robots=$robots[0];
      $robotsparts=$robots->getRobotsParts("created_at='2017-08-23'");
      foreach ($robotsParts as $re)
      {
          echo $re->getParts()->name;
      }
      
      $robot=Robots::findFirst(2);
      //根据条件查询出robot 由robot robotsparts parts
      $robotsParts=RobotsParts::find("robots_id='".$robot->id."'");
      //var_dump($robotsParts[0]->id);
      $robotsParts=RobotsParts::find("robots_id='".$robot->id."' AND created_at='2017-08-23'");
      $robotPart=RobotsParts::findFirst(1);
      $robot=Robots::find("id='".$robotPart->robots_id."'");
      
      //robots query where order condition bind robopatrs 
      $robot=Robots::findFirst(2);
      echo "The robot have",$robot->countRobotsParts(),"parts\n";
      
      //虚拟外键
      
     $rowcount=Robots::count();
     echo $rowcount;
    
   }
   public function fyAction()
   {
   $rowcount=Robots::count(array("distinct"=>"type"));
   var_dump($rowcount);
   
   $r2=RobotsParts::count(array("distinct"=>'robots_id'));
   echo $r2;
   
   $r3=Robots::count("type='22'");
   echo $r3;
   
   $condition="type=:type:";
   $r4=Robots::count(array(
       $condition,
       "bind"=>array("type"=>'22'),
       "order"=>'id'
   ));
   echo $r4;
   }
   public function sumAction()
   {
       $total=Robots::sum(array("column"=>"type"));
       echo $total;
       
       $total=Robots::sum(array("column"=>'year'));
       echo $total;
       
       $averg=Robots::average(array("column"=>'year'));
       echo $averg;
       
       //max/min examples;
       $age=Robots::maximum(array("column"=>'year'));
       echo $age;
       
       $age=Robots::maximum(
           array(
               "column"=>'type',
               "conditions"=>"id>2"
           )
           );
       echo $age;
   }
   public function cacheAction()
   {
       //Get robots without caching
//        $robots=Robots::find();
//        foreach ($robots as $robot){
//            echo $robot->name;
//        }
       //Juest cache the resultset The cache will expire in 1 hour (3600 seconds)
     $robots = Robots::find(array(
         "cache"=>array(
             "key"=>'sj'
         ),
         
     ));
       foreach ($robots as $robot){
           echo $robot->name;
       }
       //Cache the result for only for 5 mintutes
       $RobotsParts=RobotsParts::find(
           array(
             "cache"=>array(
                 "key"=>'fy',
                 "lifetime"=>300,
             )  ,
               
           )
           );
       //Use the 'cache' service from the DI instead of 'modelsCache'
       $robots=Robots::find(
           array(
               "cache"=>array(
                   "key"=>'i',
                   "cacheService"=>'cache',
               )
               
           )
           
           );
       $autokey=$robots->getCache();
       var_dump($autokey);
      // $cache = $di->getModelsCache();
       
   }
   public function ReAction()
   {
       $robot       = new Robots();
       $robot->type = "mechanical";
       $robot->name = "Astro Boy";
       $robot->year = 1952;
       if ($robot->save() == false) 
       {
           echo "Umh, We can't store robots right now: \n";
           foreach ($robot->getMessages() as $message)
           {
               echo $message, "\n";
           }
       } else 
       {
           echo "Great, a new robot was saved successfully!";
       } 
       $robot = new Robots();
       $robot->save(array(
           "type" => "mechanical",
           "name" => "Astro Boy",
           "year" => 1952
       ));
   }
   public function sAction()
   {
       $robot       = new Robots();
       $robot->type = "mechanical";
       $robot->name = "Astro Boy";
       $robot->year = 1952;
       
       //This record only must be created
       if ($robot->create() == false) {
           echo "Umh, We can't store robots right now: \n";
           foreach ($robot->getMessages() as $message) {
               echo $message, "\n";
           }
       } else {
           echo "Great, a new robot was created successfully!";
       } 
       echo "The generated id is: ", $robot->id;
   }
   public function hAction()
   {
       $root=new Robots();
     
   }
}