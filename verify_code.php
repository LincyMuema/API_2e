<?php
    require_once "load.php";
    $objLayouts->heading();
    $objMenus->main_menu();
    $objLayouts->banner();
    $objForms->verify_code_form($ObjGlob);
    $objContents->sidebar();
    $objLayouts->footer();