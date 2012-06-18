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
    /**
     *
     * @param Category $category 
     */
    public static function getClassNameOfCategory($category)
    {
        return '" style="background-color:'.$category->colour.';';
    }
}



