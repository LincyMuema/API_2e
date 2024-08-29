<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>First Trial</h1>
    <?php
    require_once "load.php";
    print $obj->user_age("Alex", 2004);
    //print "Hi " .$obj-> computer_user("Alex"). " and I am ". $obj->user_age(2004);
    print "<br>";
    ?>
</body>
</html>