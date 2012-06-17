<?php
/**
 * Description of DeliveryOrder
 *
 * @author nikolay
 */
class DeliveryOrder extends Order
{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function defaultScope() {
        $table = $this->getTableAlias(true, false);
        $attribute = $this->dbConnection->quoteColumnName('type');
        return array(
            'condition' => "$table.$attribute=".self::TYPE_DELIVERY,
        );
    }
    
    public function behaviors() {
        return array_merge(parent::behaviors(), array(
        ));
    }
}
