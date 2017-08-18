<?php
use Phalcon\Mvc\Model\Message;
class Cars extends \Phalcon\Mvc\Model
{
    public $id;
    public $name;
    public $brand_id;
    public $price;
    public $year;
    public $style;
   
    public function beforeCreate()
    {
        if ($this->price < 10000)
        {
            $this->appendMessage(new Message("A car cannot cost less than $ 10,000"));
            return false;
        }
    }
    
    public function getSource()
    {
        return 'sample_cars';
    }
 /**
     * A car only has a Brand, but a Brand have many Cars
     */
    public function initialize()
    {
        $this->belongsTo('brand_id', 'Brands', 'id');
    }
}