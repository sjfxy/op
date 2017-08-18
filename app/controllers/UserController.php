<?php
class UserController extends ControllerBase
{
    public function beforeExecuteRoute($dispatcher)
    {
        if($dispatcher->getActionName()=='save')
        {
            $this->flash->error("You do not promiss");
            return false;
        }
    }
  
    public function testAction()
    {
        $this->forward('user/index');
    }
   
        public function indexAction()
        {
            echo "ces";
        }
        
        public function modelAction()
        {
           $user=Users::find();
           echo "There are",count($user);
$user=Users::find("username='demo'");
echo "There are",count($user);

//mysql mysqli pdo pgsql mongoose reids mencaded
//apcu opacache 

$user=Users::find(
    array(
        "username='demo'",
        "id=1"
        
    )
    );
echo count($user);

foreach ($user as $u)
{
   echo $u->username."\n"; 
}

$user=Users::find(array(
    "username='demo'",
    "order"=>'id',
    "limit"=>10
    
    
));
foreach ($user as $u)
{
echo $u->username;    
}
//where order limit mysqli row object fetch_all array assoc
$user=Users::find(array(
    "order"=>'id'
));
foreach ($user as $u)
{
echo $u->username."\n";    
}
$user=Users::findFirst();
echo "The user name is ",$user->username,"\n";


$user=Users::findFirst(array(
    "username='demo'",
    "order"=>'id'  
));

echo "The first value:",$user->username,"\n";
$arr=array();
$arr[]="username='demo'";
$arr['order']="id desc";
$user=Users::find($arr);
foreach ($user as $u){
    echo $u->username,"\n";
}
$user=Users::find(array(
    "conditions"=>"username= ?1",
    "bind"=>array(1=>'demo')
));
foreach ($user as $u)
{
echo $u->username,"\n";    
}
$user=Users::query()
->where("username=:username:")
->bind(array("username"=>'demo'))
->order("id")
->execute();
foreach ($user as $u)
{
echo $u->username,"\n";    
}
//Get all user
$user=Users::find();
foreach ($user as $u)
{
echo $u->username,"\n";    
}
//Traversing with a while
//多用这个进行发、切开数组的执行
$user->rewind();
while($user->valid())
{
    $u=$user->current();
    echo $u->username,"\n";
    $user->next();
}
echo count($user);
echo $user->count();
//使用数组迭代器进行spl的进行生成器的操作进行数组的 
//多使用这些技巧数组的切开分开遍历 array_map array_filter array_merg 
//Move the internal cursor to the third user
$user->seek(2);
$u=$user->current();

var_dump($u->username);

$u=$user[1];
if(isset($user[0]))
{
$u=$user[0];    
}
      $u=$user->getFirst();
      
      $u=$user->getLast();
        }
        
        public function fyAction()
        {
            $users=Users::find();
            file_put_contents('cache.txt',serialize($users));
            $users=unserialize(file_get_contents('cache.txt'));
            foreach ($users as $u)
            {
            echo $u->id;    
            }
        }
        public function paAction()
        {
            //参数绑定
            $conditions="username=:username: AND id= :id:";
            $bind=array(
                "username"=>'demo',
                "id"=>1
            );
            $types=array(
                Phalcon\Db\Column::BIND_PARAM_STR,
                Phalcon\Db\Column::BIND_PARAM_INT
            );
            $user=Users::find(
                array(
                    $conditions,
                    "bind"=>$bind,
                    "bindTypes" => $types
                )
                );
            foreach ($user as $u)
            {
            echo $u->username;    
            }
        }
        public function auAction()
        {
           $robot=Robots::findFirst(2);
           foreach ($robot->getRobotsParts() as $parts)
           {
               echo $parts->getParts()->name,"\n";
           }
           
        }
        public function axAction()
        {
        $robot=Robots::findFirst(2);
        var_dump($robot->name);
        }
        
        public function MapAction()
        {
            //这里就是进行数据库的字段列 进行视图对象的映射 
            //就不需要关系数据库的相关属性的改变
            //只需要修改面向对象orm进行相关的对象的操作 
            //属性的映射改变 处理好对象与对象之间的关系 关联关系
            //对象之间的复杂的关系
            //之后都使用 映射的对象的属性进行数据库结果集的访问 就可以了
            //具体代码看下面
            $conditions="theName=:name:";
            $robots=Robots::find(array(
                $conditions,
                "bind"=>array('name'=>'22'),
                "order"=>"theType Desc"
                
            ));
            var_dump($robots[0]->code);
            $r=new Robots();
            $r->code=NULL;
            $r->theName='ss';
            $r->theType='34';
            $r->theYear=2009;
            $r->save();
        }
        
        public function meAction()
        {
//             $robot=new Robots();
//             $metaData=$robot->getDI()->getModelsMetaData();
//             $attributes=$metaData->getAttributes($robot);
//             print_r($attributes);
//             $dataTypes=$metaData->getDataTypes($robot);
//             print_r($dataTypes);
//             $metaData = new Phalcon\Mvc\Model\MetaData\Memory();
//             $attributes = $metaData->getAttributes(new Robots());
//             print_r($attributes);
            
//             $dataTypes = $metaData->getDataTypes(new Robots());
//             print_r($dataTypes);
// $robot=new Robots();
// $metaData=$robot->getDI()->getSjMetaData();
// $attributs=$metaData->getAttributes($robot);
// print_r($attributs);
// $types=$metaData->getDataTypes($robot);
// print_r($types);

//这里注册一个服务就可以在index.php中间进行基于中间注册依赖注入控制反转即可
//为了不过多的进行注册表注册这里使用缓存
//APC扩展仅支持php5.1至php5.4，从php5.5开始不再支持apc，可以使用opcache或xcache
// $robot=new Robots();
// $metaData=$robot->getDI()->getSjApcData();
// print_r($metaData-> getAttributes($robot));
        }
        public function proAction()
        {
            $robot=new Robots();
          Robots::find();
         $di=$this->di;
           $pro=$di->getProfiler();
           $profiles=$pro->getProfiles();
           var_dump($profiles);
            die;
            foreach ($profiles as $profile) {
                echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
                echo "Start Time: ", $profile->getInitialTime(), "\n";
                echo "Final Time: ", $profile->getFinalTime(), "\n";
                echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";
            }
        }
        public function pAction(){
//            $query=$this->modelsManager->createQuery("select * from Cars");
          
//           $query=$this->modelsManager->createQuery('select * from Cars order by Cars.name');
//           $query=$this->modelsManager->createQuery('SELECT Cars.name FROM Cars ORDER BY Cars.name');
//           $r=$query->execute();
//           var_dump($r[0]->name);
          $manager=$this->modelsManager;
      $phql   = "INSERT INTO Cars VALUES (NULL, 'Nissan Versa', 7, 9999.00, 2012, 'Sedan')";
      $result = $manager->executeQuery($phql);
      if ($result->success() == false)
      {
          foreach ($result->getMessages() as $message)
          {
              echo $message->getMessage();
          }
      }
        }
        
        public function cAction(){
          //Check if the cache with key "downloads" exists or has expired
        if (!$this->viewCache->get('lastest2'))
        {

            //Query the latest downloads
            $latest = Users::find(array('order' => 'created_at DESC'));
            $this->viewCache->save("lastest2",$latest);
            $this->view->setVar('latest', $latest);
           
        }
$latest=$this->viewCache->get('lastest2');
$this->view->setVar('latest', $latest);
        //Enable the cache with the same key "downloads"
     
    
          
        }
        
}