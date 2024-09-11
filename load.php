<?php
// Class Auto load

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

//creating instances of all classes
$objLayouts = new layouts();
$objMenus = new menus();
$obj = new fnc();
$objContents = new contents();

require "includes/constants.php";
require "includes/dbConnection.php";

$conn= new dbConnection(DBTYPE,HOSTNAME, DBPORT,HOSTUSER,HOSTPASS,DBNAME);

// $arr=["Green","Black","Red","White"];

// foreach($arr as $color){
//     print $color . "<br>";
// }
// print "<br>";
// $file = "index.php";
// if(is_readable($file)){
//     print "yes";

// }else 
// print"no";
?>