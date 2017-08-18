<?php
class Brands extends \Phalcon\Mvc\Model
{
    public $id;
    public $name;
    public function getSource()
    {
    return "sample_brand";
    }
    public function initialize()
    {
        $this->hasMany('id','Cars','brand_id');
    }
}