<?php

Yii::import('zii.widgets.jui.CJuiDatePicker');

/**
 * Description of DatePicker
 *
 * @author nikolay
 */
class DatePicker extends CJuiDatePicker
{
    public function init() {
        $this->options = array(
            'showAnim'=>'fold',
            'dateFormat'=>'yy-mm-dd',
        );
        $this->htmlOptions = array(
            'style'=>'height:20px;'
        );
        parent::init();
    }
}

?>
