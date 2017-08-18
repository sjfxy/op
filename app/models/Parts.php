<?php
class Parts extends \Phalcon\Mvc\Model
{

    public function initialize()
    {
        $this->hasMany("id", "RobotsParts", "parts_id");
    }

}