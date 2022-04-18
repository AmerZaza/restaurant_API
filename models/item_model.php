<?php


class ItemModel  extends ItemMl {
  public $itemId ;
  public $itemGroupId ;
  //public $name ;
  public $isMain ;
  public $mainItemId ;
  public $diseplay ;
  public $fixed ;
  public $price;

  public $table_name = "item";

}

class ItemMl {
    public $itemMlId ;
    public $itemId ;
    public $languageId;
    public $name ;
    public $description ;
    public $foodInfo ;

    public $table_ml_name = "item_ml";
  
    
}


class itemImage {
    public $itemImageId ;
    public $iemId ;
    public $imageLink ;

    public $table_img_name = "item_images";
  
  

    
}



?>