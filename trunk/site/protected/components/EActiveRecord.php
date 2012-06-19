<?php
/**
 * Common class for all CActive record models.
 * Will allow easy overall functionality addition.
 *
 * @property-read array $listData
 * @author nikolay
 */
class EActiveRecord extends CActiveRecord {
    
    /**
     * Generic implementation of an attribute parametrised named scope.
     *
     * @param string $attribute
     * @param mixed $value
     * @return EActiveRecord 
     */
    protected function attributeNamedScope($attribute, $value)
    {
        $alias = $this->getTableAlias(true, true);
        $column = $this->getDbConnection()->quoteColumnName($attribute);
        $this->getDbCriteria()->mergeWith(new CDbCriteria(array(
            'condition' => "$alias.$column=:$attribute",
            'params' => array(":$attribute" => $value),
        )));
        return $this;
    }
    
    /**
     * Returns list data that can be used in dorpDownList activeDropdownList, etc.
     *
     * @return array
     */
    public function getListData() {
        return $this->getListDataHelper('id', 'name');
    }
    
    /**
     * Generates a drop down list data.
     *
     * @param string $valueAttribute
     * @param strign $labelAttribute
     * @return array
     */
    protected function getListDataHelper($valueAttribute, $labelAttribute) {
        $models = $this->findAll(array(
            'select'=>"$valueAttribute, $labelAttribute",
            'order' => "$labelAttribute asc",
        ));
        return CHtml::listData($models, $valueAttribute, $labelAttribute);
    }
    
    /**
     * Extracts all errors generated in a given $model( different from $this ) 
     * and places them as errors in a specified attribute.
     * 
     * @param mixed $model Some model instance
     * @param string $attribute 
     */
    protected function proxyErrors($model, $attribute) {
        foreach($model->errors as $fieldErrors)
            foreach($fieldErrors as $error)
                $this->addError($attribute, $error);
    }
    
    /**
     * Chack wether the curent AR instance can be deleted or not.
     *
     * @return boolean Allow flag.
     */
    public function getCanBeDeleted(){
        return true;
    }
    
    /**
     * Before-delete hook
     *
     * @return type 
     */
    protected function beforeDelete() {
        if(!$this->canBeDeleted)
            return false;
        
        return parent::beforeDelete();
    }
}
