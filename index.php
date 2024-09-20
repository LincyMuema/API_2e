<?php
require_once "load.php";
$objLayouts->heading();
$objMenus->main_menu();
$objLayouts -> banner();
$objContents->main_content();
$objContents->sidebar();
$objLayouts->footer();