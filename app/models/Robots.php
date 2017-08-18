<?php
class Robots extends \Phalcon\Mvc\Model
{
    public function beforeValidationOnCreate()
    {
        echo "This is executed before create a Robot!";
    }  
public  function  initialize()
{
    $this->hasMany("id","RobotsParts","robots_id");
}
public function columnMap()
{
    //Keys are the real names in the table and
    //the values their names in the application
    return array(
        'id' => 'code',
        'name' => 'theName',
        'type' => 'theType',
        'year' => 'theYear'
    );
}

}