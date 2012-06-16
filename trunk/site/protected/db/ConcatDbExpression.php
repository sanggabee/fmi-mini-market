<?php
/**
 * ConcatDbExpression is a class used to abstract concat expressions for a list of fields.<br />
 * Example:<br />
 * $concatenated = new ConcatDbExpression('field1', 'field2', [$field_]);<br />
 * $criteria = new CDbCriteria();<br />
 * $criteria->compare($concatenated, $vaue);<br />
 * SomeModel::model()->find($criteria);<br />
 * 
 * @todo Test with some CDbExpression instances as parameters instead of attribue.
 * @author Nikolay Dobromirov
 * @version 1.0
 */
class ConcatDbExpression extends CDbExpression
{
    public function __construct() {
        $params = func_get_args();
        if(count($params) < 1)
            throw new CException('Invalid arguments count passed to c-tor of'.__CLASS__.'!');
        
        // Cast all params to string values
//        foreach($params as $idx => $param)
//            if(!is_string($param))
//                $params[$idx] = (string)$param;
        
        parent::__construct($this->getConcatExpression(), $params);
    }
    
    /**
     * Generates the proper expression based on a driver name.
     * If no driver name is passed, the the one in the default connection is used.
     *
     * @param string $driverName Driver name to be used. Defaults to null.
     * @return string Approporiate DB expression besed on driver name.
     */
    private function getConcatExpression($driverName = null)
    {
        if($driverName === null || !array_key_exists($driverName, Yii::app()->db->driverMap))
            $driverName = Yii::app()->db->driverName;
        
        switch($driverName) {
            case 'dblib': case 'mssql': case 'sqlsrv':
                return $this->expression = '('.implode('+', $this->params).')';
            default:
                return $this->expression = 'CONCAT('.implode(',', $this->params).')';
        }
    }
}
