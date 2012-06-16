<?php
/**
 * Common class for all CActive record models.
 * Will allow easy overall functionality addition.
 *
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
}
