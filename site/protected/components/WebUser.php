<?php
/**
 * Description of WebUser
 *
 * @property User $model User Instance of the currently logged user. If a guest -> null. Lazy loaded.
 * @author nikolay
 */
class WebUser extends CWebUser
{
    public function getIsAdmin() {
        return $this->model && $this->model->type == User::TYPE_ADMIN;
    }
    
    public function getIsClient() {
        return $this->model && $this->model->type == User::TYPE_CLIENT;
    }
    
    public function getIsOperator() {
        return $this->model && $this->model->type == User::TYPE_OPERATOR;
    }
    
    private $_model;
    
    public function getModel()
    {
        if($this->isGuest)
            return null;
        
        if($this->_model === null)
            $this->_model = User::model()->findByPk($this->id);
        
        return $this->_model;
    }
}
