<?php
/**
 * Description of DialogFormWidget
 *
 * @property-read CClientScript $cs
 * @author nikolay
 */
class DialogFormWidget extends CWidget
{    
    public $linkSelector;
    public $gridId;
    public $formId;
    public $afterAjaxReloadFunction;
    
    public function init() {
        
        if($this->afterAjaxReloadFunction === null)
            $this->afterAjaxReloadFunction = "grid_afterAjaxReload_$this->id";
        
        $this->cs
            ->registerCoreScript('jquery')
            ->registerScriptFile("$this->assetsUrl/js/jquery.dialog.form.js", CClientScript::POS_HEAD);
    }
    
    public function run() {
        $this->render('DialogFormWidget');
    }
    
    /**
     * Proxy method for Yii::app()->clientScript
     * 
     * @return CClientScript
     */
    public function getCs() {
        return Yii::app()->clientScript;
    }
    
    private $_assetsUrl;
 
    public function getAssetsUrl()
    {
        if ($this->_assetsUrl === null)
        {
            $path = dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
            $this->_assetsUrl = Yii::app()->getAssetManager()->publish($path);
        }
        return $this->_assetsUrl;
    }

}

