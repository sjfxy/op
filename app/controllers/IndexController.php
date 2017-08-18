<?php
class IndexController extends \Phalcon\Mvc\Controller
{
    public function indexAction(){
       // echo("<h1>hello word!</h1>");
        
    }
    //这里的Phalcon是基于java struts2.0 action indexAction 
    //这里注意的就是前端控制器在初始化web启动时java是spring 进行管理applciation web mybatis orm 
    //所以扫描注解开发 迭代是的开发基于对象的扩展类 包装类的 比如定制开发基本的功能定了之后
    //为了以后的扩展或者其实就是数据模型的扩展 都是基于此 所以spring spirmngvc mybatis就完全可以满足这种要求
    //配置的时候将配置到public/index.php作为路口文件进行每次的注册缓存 开启了opcache之后利用php7的新特性完全可以
    //apcu 所以.htaccess就可以开发了底层用C进行路由扩展 数据库扩展 日志路由解析 控制器 业务逻辑数据模型 页面视图 中间件都是可以的你可以随意的组合
    //这里完全可以进行index admin ->tp5.0 ci2.0 ci3.0 ci4.0 yii2.0
    // IndexController index views index index User 
    public function reAction(){
        echo("ss");
        
    }
}