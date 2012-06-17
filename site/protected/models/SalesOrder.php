<?php
/**
 * Description of SalesOrder
 *
 * @author nikolay
 */
class SalesOrder extends Order
{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function defaultScope() {
        $table = $this->getTableAlias(true, false);
        $attribute = $this->dbConnection->quoteColumnName('type');
        return array(
            'condition' => "$table.$attribute=".self::TYPE_SALE,
        );
    }
    
    public function behaviors() {
        return array_merge(parent::behaviors(), array(
        ));
    }
}
