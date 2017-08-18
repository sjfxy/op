<?php
class RobotsParts extends \Phalcon\Mvc\Model
{

    public function initialize()
    {
        $this->belongsTo("robots_id", "Robots", "id");
        $this->belongsTo("parts_id", "Parts", "id");
    }

}