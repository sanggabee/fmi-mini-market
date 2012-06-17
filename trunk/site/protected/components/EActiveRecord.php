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
            'condition' => "$alias.$column=:$attribue",
            'params' => array(":$attribue" => $value),
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
}
