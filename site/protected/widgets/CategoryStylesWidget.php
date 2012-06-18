<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CategoryStylesWidget
 *
 * @author nikolay
 */
class CategoryStylesWidget extends CWidget
{
    
    public function run() {
        $style = '';
        $categories = Category::model()->findAll();
        foreach($categories as $category) /* @var $category Category */
        {
            $className = self::getClassNameOfCategory($category);
            $style .= ".$className{background-color:{$category->colour};}\r\n";
        }
            
        Yii::app()->clientScript->registerCss("style-$this->id", $style);
    }
    /**
     *
     * @param Category $category 
     */
    public static function getClassNameOfCategory($category)
    {
        return str_replace('#', 'colour-', $category->colour);
    }
}



