
<?php
class auth{
    public function bind_to_template($replacements, $template) {
        return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) {
            return $replacements[$matches[1]];
        }, $template);
    }

    public function signup($conn, $ObjGlob, $ObjSendMail, $lang, $conf){
        if(isset($_POST["signup"])){

            $errors = array();

            $fullname = $_SESSION["fullname"] = $conn->escape_values(ucwords(strtolower($_POST["fullname"])));
            $email = $_SESSION["email"] = $conn->escape_values(strtolower($_POST["email"]));
            $username = $_SESSION["username"] = $conn->escape_values(strtolower($_POST["username"]));



// verify that the fullname has only letters, space, dash, quotation
if(ctype_alpha(str_replace(" ", "", str_replace("\'", "", $fullname))) === FALSE){
    $errors['nameLetters_err'] = "Invalid name format: Full name must contain letters and spaces only etc " . $fullname;
}

// verify that the email has got the correct format
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors['email_format_err'] = 'Wrong email format';
}

$arr_email_address = explode("@", $email);
$spot_dom = end($arr_email_address);
$spot_user = reset($arr_email_address);

if(!in_array($spot_dom, $conf['valid_domains'])){
    $errors['mailDomain_err'] = "Invalid email address domain. Use only: " . implode(", ", $conf['valid_domains']);
}
$exist_count = 0;
// Verify Email Already Exists
$spot_email_address_res = $conn->count_results(sprintf("SELECT email FROM users WHERE email = '%s' LIMIT 1", $email));
if ($spot_email_address_res > $exist_count){
    $errors['mailExists_err'] = "Email Already Exists";
}

// Verify Username Already Exists
$spot_username_res = $conn->count_results(sprintf("SELECT username FROM users WHERE username = '%s' LIMIT 1", $username));
if ($spot_username_res > $exist_count){
    $errors['usernameExists_err'] = "Username Already Exists";
}

// Verify if username contain letters only
if (!ctype_alpha($username)) {
    $errors['usernameLetters_err'] = "Invalid username format. Username must contain letters only without space";
}

// Verify that the password is identical to the repeat passsword
// verify that the password length is between 4 and 8 characters
if(!count($errors)){



            $cols = ['fullname', 'email', 'username', 'ver_code', 'ver_code_time'];
            $vals = [$fullname, $email, $username, $conf['verification_code'], $conf['ver_code_time']];

            $data = array_combine($cols, $vals);

            $insert = $conn->insert('users', $data);

            if($insert === TRUE){

                $replacements = array('fullname' => $fullname, 'email_address' =>
                $email, 'verification_code' => $conf['verification_code'], 'site_full_name' => strtoupper($conf['site_initials']));
        
                $ObjSendMail->SendMail([
                    'to_name' => $fullname,
                    'to_email' => $email,
                    'subject' => $this->bind_to_template($replacements, $lang["AccountVerification"]),
                    'message' => $this->bind_to_template($replacements, $lang["AccRegVer_template"])
                ]);
                
                header('Location: verify_code.php');
                unset($_SESSION["fullname"], $_SESSION["email"], $_SESSION["username"]);
                exit();
            }else{
                die($insert);
            }
        }else{
            $ObjGlob->setMsg('msg', 'Error(s)', 'invalid');
            $ObjGlob->setMsg('errors', $errors, 'invalid');
        }
    }
    }


    public function verify_code($conn, $ObjGlob, $ObjSendMail, $lang, $conf){
        if(isset($_POST["verify_code"])){

            $errors = array();

            $ver_code = $_SESSION["ver_code"] = $conn->escape_values($_POST["ver_code"]);

            if(!is_numeric($ver_code)){
                $errors['Not_numeric'] = "Invalid code. The code should be a digit";
            }

            if(strlen($ver_code) < 5 || strlen($ver_code) > 5) {
                $errors['invalid_len'] = "Invalid code. The code should have 5 digits";
            }
            $spot_ver_code_res = $conn->count_results(sprintf("SELECT ver_code FROM users WHERE ver_code = '%d' LIMIT 1", $ver_code));
            if ($spot_ver_code_res != 1){
                $errors['ver_code_not_exist'] = "Invalid code.";
            }


            if(!count($errors)){
                die('All Correct');
            }else{
                $ObjGlob->setMsg('msg', 'Error(s)', 'invalid');
                $ObjGlob->setMsg('errors', $errors, 'invalid');
            }


            }

        }
    }