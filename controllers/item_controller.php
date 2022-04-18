<?php

include './models/database.php';
include './models/item_model.php';
include '../models/language_model.php';



class ItemController  extends ItemModel {

    // To return all users in DB
    public function getAllItems($languageCode){
        
        $database = new Database();
        $conn = $database->getConnection();

        $query = " SELECT * FROM ". $this->table_name .
                 " INNER JOIN ".$this->table_ml_name." 
                  ON ".$this->table_name.".item_id = ".$this->table_ml_name.".item_id" 
                ." INNER JOIN language ON "
                .$this->table_ml_name.".language_id = language.language_id 
                 WHERE language.code = '".$languageCode ."'" 
                ;
        
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

        // To return one selected cateory by userID
        public function getItemMlById($itemId, $languageCode){
        
            $database = new Database();
            $conn = $database->getConnection();
    
            $query = "SELECT * FROM ".$this->table_name."
            INNER JOIN ".$this->table_ml_name." 
            ON ".$this->table_name.".item_id = ".$this->table_ml_name.".item_id
            INNER JOIN language
            ON language.language_id = ".$this->table_ml_name.".language_id 
            WHERE ".$this->table_name.".item_id = " .$itemId
            ." AND language.code = '".$languageCode."'" 
            ;  
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }

        // To return one selected item by ItemId to use it with checking if the item is in system
        public function getItemById($itemId){
        
            $database = new Database();
            $conn = $database->getConnection();
    
            $query = "SELECT * FROM ".$this->table_name."
             WHERE ".$this->table_name.".item_id = '" .$itemId."'" 
            ;  
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }
      
        // To insert new Category
        public Function insertNewItem($itemModel){

            $database = new Database();
            $conn = $database->getConnection();

             $itemGroupId = $itemModel->itemGroupId ;
             $isMain =  $itemModel->isMain ;
             $mainItemId =  $itemModel->mainItemId ;
             $diseplay = 1; //$itemModel->diseplay ;
             $fixed = $itemModel->fixed ;
             $price = $itemModel->price ;

              $name = $itemModel->name ;
              $description = $itemModel->description ;
              $food_info = $itemModel->food_info ;

              $languageId = 1;  

            $query1 = "INSERT INTO ".$this->table_name." (ig_id, is_main, maini_id, diseplay, fixed, price) 
                                                 VALUES (?,?,?,?,?,?)";
            $query2 = "INSERT INTO ".$this->table_ml_name." (item_id, language_id, name, description, food_info) 
                                                VALUES (LAST_INSERT_ID() ,?,?,?,?)";
                        
            $stmt1 = $conn->prepare($query1);
            $stmt2 = $conn->prepare($query2);

            
            $stmt1->execute([$itemGroupId, $isMain, $mainItemId, $diseplay ,$fixed, $price]);
            return $stmt2->execute([$languageId ,$name ,$description ,$food_info]);
        }
        

         // To insert new translate for excist Category (just of category_ml)
         public Function insertItemMl($itemModel){

            $database = new Database();
            $conn = $database->getConnection();

            $itemId =  $itemModel->itemId;
            $languageId = $itemModel->languageId;;  
            $name = $itemModel->name;
            $description = $itemModel->description ;
            $foodInfo = $itemModel->foodInfo ;

            $query = "INSERT INTO ".$this->table_ml_name." (item_id, language_id, name, description, food_info) 
                                                    VALUES (?,?,?,?,?)"; 
            $stmt = $conn->prepare($query);
            return $stmt->execute([$itemId, $languageId, $name, $description,$foodInfo]);
        }
          

        // To update current Category-Ml for exist Category by CategoryId  AND LanguageId
        public Function updateteItemMl($itemModel){

            $database = new Database();
            $conn = $database->getConnection();

            $itemId =  $itemModel->itemId;
            $languageId = $itemModel->languageId;;  
            $name = $itemModel->name;
            $description = $itemModel->description ;
            $foodInfo = $itemModel->foodInfo ;

            $query = "UPDATE ".$this->table_ml_name." SET name =?,description =?, food_info =?   WHERE item_id =? AND language_id =? ";

            $stmt = $conn->prepare($query);
            return $stmt->execute([$name, $description, $foodInfo, $itemId, $languageId]);
        }


        // To Delete current Category by userID
        public Function deleteItemById($itemId){

            $database = new Database();
            $conn = $database->getConnection();

            $query = "DELETE FROM ".$this->table_name."  WHERE item_id =?";
            $stmt = $conn->prepare($query);
            return $stmt->execute([$itemId]);
        }





     
    
    
}


?>