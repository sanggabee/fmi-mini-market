<?php
/**
 * Performs db engine abstraction for conversion of Str to lower case.
 * 
 * @todo Test in DB engines other than MySQL.
 * @author Nikolay Dobromirov
 */
class StrLowerDbExpression extends CDbExpression
{
    private $_toLower;
    public function __construct($toLower) {
        $this->_toLower = $toLower;
        parent::__construct($this->generateExpression());
    }
    
    private function generateExpression($driverName = null) {
        if($driverName === null || !array_key_exists($driverName, Yii::app()->db->driverMap))
            $driverName = Yii::app()->db->driverName;
        
        switch($driverName) {
            default:
                return $this->expression = 'LOWER('.$this->_toLower.')';
        }
    }
}
