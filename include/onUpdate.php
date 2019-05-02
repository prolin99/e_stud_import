<?php
use XoopsModules\E_stud_import\Update;
use XoopsModules\Tadtools\Utility;

function xoops_module_update_e_stud_import(&$module, $old_version) {
    GLOBAL $xoopsDB;

    if( ! Update::chk_add_log() )
        Update::go_update_add_log();
    if( ! Update::chk_add_staff() )
        Update::go_update_add_staff();

    return true;
}


?>
