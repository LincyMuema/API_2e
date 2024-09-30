<?php
// Class Auto load
session_start();
require "includes/constants.php";
require "includes/dbConnection.php";
function ClassAutoLoad($ClassName){
    $directories=["forms","processes","structure","tables","global","store"];
    
    foreach($directories as $dir){
        $FileName = dirname(__FILE__) . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $ClassName . '.php';
        if(file_exists($FileName) AND is_readable($FileName)){
            require $FileName;
           }
    }
   
}

spl_autoload_register('ClassAutoLoad');
$conn = new dbConnection(DBTYPE, HOSTNAME, DBPORT, HOSTUSER, HOSTPASS, DBNAME);
//creating instances of all classes
$objLayouts = new layouts();
$objMenus = new menus();
//$obj = new fnc();
$objContents = new contents();
$objForms = new forms();
$objAuth = new auth();
$objAuth->signup($conn);





?>