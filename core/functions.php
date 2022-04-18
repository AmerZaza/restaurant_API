<?php


class CoreFunction {

/**
 * To convert the JSON String as input to ARRAY in output
 */
static Function fromJson($json){
    $itemsArray = [];
    $eachDetailArray = [];
    $mainArrayIndex = 0; // Because the autput array not include null items 
    // A
    $allItemsArray = explode('{', $json);
    for( $i =0; $i< count($allItemsArray) ; $i++){
        if(strlen($allItemsArray[$i]) > 2){
            $allItemsArray[$i] = str_replace('}' , '', $allItemsArray[$i]);
            $allItemsArray[$i] = str_replace(']' , '', $allItemsArray[$i]);
            
            //B
            $itemDetailArray = explode(',' , $allItemsArray[$i]);
            for($d =0; $d < count($itemDetailArray); $d++){

                if(strlen($itemDetailArray[$d]) > 2){

                //C
                $detailKeyArray = explode(':',$itemDetailArray[$d]);
                if(!empty($detailKeyArray[0] ) && !empty($detailKeyArray[1] )){
                    //$eachDetailArray[$i][$d][$detailKeyArray[0]] = $detailKeyArray[1] ; 
                    $eachDetailArray[$mainArrayIndex][ ltrim($detailKeyArray[0], ' ') ] = ltrim($detailKeyArray[1], ' ') ;
                } 
                

                /*
                for($k=0; $k< count($detailKeyArray); $k++){
                    $eachDetailArray[$i][$d][$k] = $detailKeyArray[$k];
                }
                */
            }
        }  
        $mainArrayIndex++;
      }
    }
    return ($eachDetailArray ); 
}


}

?>