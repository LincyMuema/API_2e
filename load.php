<?php
// Class Auto load

function ClassAutoLoad($ClassName){
    $directories=["forms","processes","structure","tables","global","store"];
    
    foreach($directories as $dir){
        $FileName = dirname(__FILE__) . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $ClassName . '.php';
        if(is_readable($FileName)){
            require $FileName;
        }
    }
   
}

spl_autoload_register('ClassAutoLoad');

//creating instances of all classes
$objLayouts = new layouts();
$objMenus = new menus();
$obj = new fnc();


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