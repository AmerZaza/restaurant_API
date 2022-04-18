<?php

include './models/database.php';
include './models/category_model.php';
include '../models/language_model.php';


class CategoryController extends CategoryModel{


    // To return all users in DB
    public function getAllCategories($languageCode){
        
        $database = new Database();
        $conn = $database->getConnection();

        $query = "SELECT * FROM ".$this->table_name."
                  INNER JOIN ".$this->table_ml_name." 
                  ON ".$this->table_name.".group_id = ".$this->table_ml_name.".ig_id " 
                  ."INNER JOIN language
                  ON language.language_id = ".$this->table_ml_name.".language_id" 
                 ." WHERE  language.code = '".$languageCode."'" 
                  ;
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

        // To return one selected cateory by userID
        public function getCategory($categoryId, $languageCode){
        
            $database = new Database();
            $conn = $database->getConnection();
    
            $query = "SELECT * FROM ".$this->table_name."
            INNER JOIN ".$this->table_ml_name." 
            ON ".$this->table_name.".group_id = ".$this->table_ml_name.".ig_id
            INNER JOIN language
            ON language.language_id = ".$this->table_ml_name.".language_id 
            WHERE ".$this->table_name.".group_id = " .$categoryId
            ." AND language.code = '".$languageCode."'" 
            ;  
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }
        // To insert new Category
        public Function insertCategory($categoryModel){

            $database = new Database();
            $conn = $database->getConnection();

           // $categoryId =  $categoryModel->categoryId;
            $disable = '1';//$categoryModel->disable;
            $itemCategoryMlId = $categoryModel->itemCategoryMlId;
            $languageId = '1';//$categoryModel->languageId;  // Main Language
            $itemCategoryName = $categoryModel->itemCategoryName;
            $description = $categoryModel->itemCategoryDescription ;

            $query1 = "INSERT INTO ".$this->table_name." (disable) VALUES (?)";
            $query2 = "INSERT INTO ".$this->table_ml_name." (ig_id, language_id, name, description) VALUES (LAST_INSERT_ID() ,?,?,?)";
                        
            $stmt1 = $conn->prepare($query1);
            $stmt2 = $conn->prepare($query2);

             $stmt1->execute([$disable]);
            return $stmt2->execute([$languageId, $itemCategoryName, $description]);
        }

         // To insert new translate for excist Category (just of category_ml)
         public Function insertCategoryMl($categoryModel){

            $database = new Database();
            $conn = $database->getConnection();

            $categoryId =  $categoryModel->categoryId;
            $languageId = $categoryModel->languageId;  
            $itemCategoryName = $categoryModel->itemCategoryName;
            $description = $categoryModel->itemCategoryDescription ;

            $query = "INSERT INTO ".$this->table_ml_name." (ig_id, language_id, name, description) VALUES (? ,?,?,?)"; 
            $stmt = $conn->prepare($query);
            return $stmt->execute([$categoryId, $languageId, $itemCategoryName, $description]);
        }

        // To update current Category-Ml for exist Category by CategoryId  AND LanguageId
        public Function updateteCategoryMl($categoryModel){

            $database = new Database();
            $conn = $database->getConnection();

            $categoryId =  $categoryModel->categoryId;
            $languageId = $categoryModel->languageId; 
            $itemCategoryName = $categoryModel->itemCategoryName;
            $description = $categoryModel->itemCategoryDescription ;

            $query = "UPDATE ".$this->table_ml_name." SET name =?,description =?   WHERE ig_id =? AND language_id =? ";

            $stmt = $conn->prepare($query);
            return $stmt->execute([$itemCategoryName, $description, $categoryId, $languageId]);
        }


        // To Delete current Category by userID
        public Function deleteCategory($categoryId){

            $database = new Database();
            $conn = $database->getConnection();

            $query = "DELETE FROM ".$this->table_name."  WHERE group_id =?";
            $stmt = $conn->prepare($query);
            return $stmt->execute([$categoryId]);
        }





     
    
    
}










?>