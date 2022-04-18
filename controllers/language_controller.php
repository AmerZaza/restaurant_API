<?php
include '../models/database.php';
include './models/language_model.php';

class LanguageController extends LanguageModel
{  

    // This function must to be debrecated .. 
     function getLanguageCode($languageCode){
        $laguageId = '1';
    
        if($languageCode == 'en'){
            $laguageId = '1';
        }elseif($languageCode == 'de'){
            $laguageId = '2';
        }
    
        return $laguageId ;
        
    }

}

?>