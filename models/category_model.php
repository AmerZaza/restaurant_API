<?php


class  CategoryModel extends CategoryMlModel
{
    public $categoryId;
    public $disable;

    public $table_name = "item_category";

}

class CategoryMlModel 
{
    public $itemCategoryMlId;
    public $categoryId;
    public $languageId;
    public $itemCategoryName;
    public $itemCategoryDescription;

    public $table_ml_name = "item_category_ml";
    
}

?>