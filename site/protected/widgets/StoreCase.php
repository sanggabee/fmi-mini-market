<?php
/**
 * Description of Case
 *
 * @author nikolay
 */
class StoreCase extends CWidget
{
    public function run() {
        $this->render('StoreCase', array(
            'actives' => Product::model()->actives,
            'income' => SalesOrder::model()->overallTotal,
            'expenses' => DeliveryOrder::model()->overallTotal,
            'currency' => Yii::app()->params['currency'],
        ));
    }
    
    public function format($prize) {
        return number_format($prize, 2). Yii::app()->params['currency'];
    }
}
