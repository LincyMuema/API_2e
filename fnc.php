<?php
class fnc{

    var $name;
    public $fname;
    protected $username;
    private $password;

    public function computer_user($fname){
        return $fname;
    }
    public function user_age($fname, $yob ){
        $user = $this -> computer_user($fname);
        $age = date('Y')-$yob;
        return $user . " is " .$age;
    }
    public function hash_pass($pass){
        return md5($pass, PASSWORD_DEFAULT);
    }
}
$obj = new fnc();
print $obj->user_age("Alex", 2004);
//print "Hi " .$obj-> computer_user("Alex"). " and I am ". $obj->user_age(2004);
print "<br>";

print $obj-> hash_pass('123');
?>