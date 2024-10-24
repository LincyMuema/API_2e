<?php
date_default_timezone_set("AFRICA/Nairobi");
define('DBTYPE','PDO');
define('HOSTNAME','localhost');
define('DBPORT','3308');
define('HOSTUSER','root');
define('HOSTPASS','1@3mys0lwork');
define('DBNAME','2E_ics');

$protocol = isset($_SERVER['HTTPS']) && 
$_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$base_url = $protocol . $_SERVER['HTTP_HOST'] . '/';

$conf['ver_code_time'] = date("Y-m-d H:i:s", strtotime("+ 1 days"));
$conf['verification_code'] = rand(10000,99999);
$conf['site_initials'] = "ICS 2024";
$conf['site_url'] = "$base_url/". DBNAME;


// verify that the email domain
$conf['valid_domains'] = ["strathmore.edu", "gmail.com", "yahoo.com", "mada.co.ke", "outlook.com"];