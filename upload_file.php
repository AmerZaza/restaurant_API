
<?php

//upload_file.php

upload_file("images/temp/", "az");

function upload_file($path,$nameFixPart){

$return["error"] = false;
$return["msg"] = "";
$return["success"] = false;
//array to return

if(isset($_FILES["file"])){
    //directory to upload file
    $target_dir = $path ; //create folder files/ to save file
    $filename = $_FILES["file"]["name"]; 
    
    // change the file's name
    $fExteinsion = explode('.', $filename); // Get the file's extension
    $fExteinsion = end($fExteinsion);
    $fExteinsion = strtolower($fExteinsion);

    $filename = rand(10,10000).$nameFixPart.rand(10,10000).'.'.$fExteinsion; // get random name


    //$_FILES["file"]["size"] get the size of file
    //you can validate here extension and size to upload file.

    $savefile = "$target_dir/$filename";
    //complete path to save file

    if(move_uploaded_file($_FILES["file"]["tmp_name"], $savefile)) {
        $return["error"] = false;
        //upload successful
    }else{
        $return["error"] = true;
        $return["msg"] =  "Error during saving file.";
    }
}else{
    $return["error"] = true;
    $return["msg"] =  "No file is sublitted.";
}

header('Content-Type: application/json');
// tell browser that its a json data
echo json_encode($return);
//converting array to JSON string

}


 

?>