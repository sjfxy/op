<?php
try {
    date_default_timezone_set("Asia/Shanghai");
    //Register an autoloader
    $loader = new \Phalcon\Loader();
    $loader->registerDirs(array(
        '../app/controllers/',
        '../app/models/'
    ))->register();

    //Create a DI
    $di = new Phalcon\DI\FactoryDefault();
    
    $di->set('modelsManager',function (){
        return new Phalcon\Mvc\Model\Manager();
    });
    
    $di->set('profiler', function(){
        return new Phalcon\Db\Profiler();
    });
    //Set the database service
    $di->set('db', function() use ($di){
        $eventsManager = new Phalcon\Events\Manager();
        //Get a shared instance of the DbProfiler
        $profiler = $di->getProfiler();
        $logger = new Phalcon\Logger\Adapter\File("../app/logs/debug.log");
        $eventsManager->attach('db', function($event, $connection) use ($logger,$profiler) {
            if ($event->getType() == 'beforeQuery') {
                $profiler->startProfile($connection->getSQLStatement());
                $logger->log($connection->getSQLStatement(), \Phalcon\Logger::INFO);
            }
            if ($event->getType() == 'afterQuery') {
                $profiler->stopProfile();
            }
        });
        $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
        "host" => "localhost",
        "username" => "root",
        "password" => "root",
        "dbname" => "fy"
    ));
        $connection->setEventsManager($eventsManager);
        
        return $connection;
    });
    
    $di->set('modelsMetaData',function (){
        return  new Phalcon\Mvc\Model\MetaData\Memory();
    });
    $di->set('sjMetaData',function (){
        return new Phalcon\Mvc\Model\Metadata\Files(array(
    'metaDataDir' => '../app/cache/metadata/'));
    });
    $di->set("sjApcData",function (){
        return new Phalcon\Mvc\Model\Metadata\Apc(array(
    'suffix' => 'my-app-id',
    'lifetime' => 86400
 ));
    });
      //Set the models cache service
$di->set('modelsCache', function(){

    //Cache data for one day by default
    $frontCache = new Phalcon\Cache\Frontend\Data(array(
        "lifetime" => 86400
    ));

    //Memcached connection settings
    //这里在windows是memcache 在linux上面是memcached 注意这个坑 
    //在设置缓存时注意缓存的key
    $cache = new Phalcon\Cache\Backend\Memcache($frontCache, array(
        "host" => "localhost",
        "port" => "11211"
    ));

    return $cache;
});
    
    //Set the views cache service
    $di->set('viewCache', function(){
    
        //Cache data for one day by default
        $frontCache = new Phalcon\Cache\Frontend\Output(array(
            "lifetime" => 86400
        ));
    
        //Memcached connection settings
        $cache = new Phalcon\Cache\Backend\Memcache($frontCache, array(
            "host" => "localhost",
            "port" => "11211"
        ));
    
        return $cache;
    }, true);

    //Setting up the view component
    $di->set('view', function(){
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir('../app/views/');
        return $view;
    });

    //Handle the request
    $application = new \Phalcon\Mvc\Application();
    $application->setDI($di);
    echo $application->handle()->getContent();

} catch(\Phalcon\Exception $e) {
     echo "PhalconException: ", $e->getMessage();
}