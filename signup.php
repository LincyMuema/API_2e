<?php
require_once "load.php";
$objLayouts->heading();
$objMenus->main_menu();
$objLayouts -> banner();
$objForms-> sign_up_form($ObjGlob);
$objContents->main_content();
$objContents->sidebar();
$objLayouts->footer();
