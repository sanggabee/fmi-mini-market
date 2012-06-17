<?php
/**
 * Description of FlashMessage
 *
 * @author nikolay
 */
class FlashMessage extends CWidget
{
    public $key;
    
    public function init() {
        if(empty($this->key))
            throw new CException('No flash message KEY passed for tracking!');
    }
    
    public function run() {
        $user = Yii::app()->user;
        if($user->hasFlash($this->key)) {
            $content = $user->getFlash($this->key);
            echo CHtml::tag('div', array('class'=>$this->key), $content);
        }
    }
}
