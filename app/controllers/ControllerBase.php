<?php
use Phalcon\Mvc\Controller;
//公共类库将复杂的进行工具类 上传下载文件操作 session cookie 第三方的extra api
class ControllerBase extends Controller
{
 protected function forward($uri)
 {
     $uriParts = explode('/', $uri);
     return $this->dispatcher->forward(
        array(
           'controller' => $uriParts[0],
           'action' => $uriParts[1]
        )
     );
  }
}