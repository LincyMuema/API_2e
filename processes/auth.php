
<?php
class auth{
    public function signup($conn){
        if(isset($_POST["signup"])){
            $fullname = $_POST["fullname"];
            $email_address = $_POST["email"];
            $username = $_POST["username"];

$cols = ['fullname', 'email', 'username', 'genderId', 'roleId'];
$vals = [$fullname, $email_address, $username, 1, 1];

$data = array_combine($cols, $vals);

$insert = $conn->insert('users', $data);
    if($insert === TRUE){
        header('Location: signup.php');
        exit();
    }else{
        die($insert);
    }
        }
    }
}
