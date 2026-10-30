<?php

use XoopsModules\Tadtools\CkEditor;
use XoopsModules\Tadtools\Utility;

$mydirname = basename(dirname(dirname(__FILE__)));

if (!preg_match('/^(\D+)(\d*)$/', $mydirname, $regs)) {
    echo ("invalid dirname: " . htmlspecialchars($mydirname));
}

$mydirnumber = $regs[2] === '' ? '' : intval($regs[2]);

// includes

include '../../../include/cp_header.php';

include_once "../include/constants.inc.php";

include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

include_once '../class/tinyd.textsanitizer.php';

include_once '../include/gtickets.php';

require_once __DIR__ . '/header.php';

// branch for altsys

if (defined('XOOPS_TRUST_PATH') && !empty($_GET['lib'])) {

    $mydirname = basename(dirname(dirname(__FILE__)));

    $mydirpath = dirname(dirname(__FILE__));

    // common libs (eg. altsys)

    $lib = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['lib']);

    $page = preg_replace('/[^a-zA-Z0-9_-]/', '', @$_GET['page']);

    if (file_exists(XOOPS_TRUST_PATH . '/libs/' . $lib . '/' . $page . '.php')) {

        include XOOPS_TRUST_PATH . '/libs/' . $lib . '/' . $page . '.php';

    } else if (file_exists(XOOPS_TRUST_PATH . '/libs/' . $lib . '/index.php')) {

        include XOOPS_TRUST_PATH . '/libs/' . $lib . '/index.php';

    } else {

        die('wrong request');

    }

    exit;

}

// also reading language files of modinfo & main

if (file_exists("../language/{$xoopsConfig['language']}/modinfo.php")) {

    include "../language/{$xoopsConfig['language']}/modinfo.php";

    include "../language/{$xoopsConfig['language']}/main.php";

} else {

    include "../language/english/modinfo.php";

    include "../language/english/main.php";

}

// emulates mb functions

if (!function_exists('mb_convert_encoding')) {

    function mb_convert_encoding($str)
    {return $str;}

}

if (!function_exists('mb_internal_encoding')) {

    function mb_internal_encoding($str)
    {return "UTF-8";}

}

// these initializing code is provisional. they will be removed

$globals = array(

    'op' => '',

    'id' => 0,

);

foreach ($globals as $global => $default) {

    if (isset($_GET[$global])) {
        $$global = $_GET[$global];
    } else if (isset($_POST[$global])) {
        $$global = $_POST[$global];
    } else {
        $$global = $default;
    }

}

$id = intval($id);

// end of initialization

// submit redirection

if (!empty($_POST['preview']) && $op == 'add') {
    $op = 'submit';
}

if (!empty($_POST['preview']) && $op == 'editit') {
    $op = 'edit';
}

if (!empty($_POST['moveto']) && $op == 'update') {
    $op = 'moveto';
}

if (!empty($_POST['cancel'])) {

    redirect_header('index.php?op=show', 0, _CANCEL);

    exit;

}

// utility variables

$mymodpath = XOOPS_ROOT_PATH . "/modules/$mydirname";

$mymodurl = XOOPS_URL . "/modules/$mydirname";

$mytablename = $xoopsDB->prefix("tinycontent{$mydirnumber}");

$myts = &TinyDTextSanitizer::getInstance();

// ------------------------------------------------------------------------- //

// Switch Statement for the different operations                             //

// ------------------------------------------------------------------------- //

$xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();

switch ($op) {

// ------------------------------------------------------------------------- //

// Show Content Page -> Overview                                             //

// ------------------------------------------------------------------------- //

    default:

    case "show":

        tinyd_cp_header('index.php?op=show');

        $submitlink_with_spaw = '';

        // get all instances of TinyD using newblocks table

        $rs = $xoopsDB->query("SELECT mid FROM " . $xoopsDB->prefix("newblocks") . " WHERE func_file='tinycontent_navigation.php'");

        $whr_mid = 'mid IN (';

        while (list($mid) = $xoopsDB->fetchRow($rs)) {

            $whr_mid .= intval($mid) . ',';

        }

        $whr_mid .= "0)";

        $rs = $xoopsDB->query("SELECT mid,dirname,name FROM " . $xoopsDB->prefix("modules") . " WHERE $whr_mid ORDER BY weight,mid");

        $dest_tinyd_options = "<option value=''>--</option>\n";

        while (list($mid, $dirname, $name) = $xoopsDB->fetchRow($rs)) {

            if ($dirname == $mydirname) {
                continue;
            }

            if (!$xoopsUser->isAdmin($mid)) {
                continue;
            }

            $name4disp = htmlspecialchars($name, ENT_QUOTES);

            $dest_tinyd_options .= "<option value='$mid'>$name4disp</option>\n";

        }

        echo "

		<h4 class='mb-3'>" . $xoopsModule->getVar('name') . "</h4>

		<div class='d-flex flex-wrap gap-2 mb-3'>

			<a class='btn btn-primary btn-sm' href='?op=submit'>" . _TC_ADDCONTENT . "</a> $submitlink_with_spaw

		</div>

		<div class='text-end small text-muted mb-2'>

			<b>" . _TC_TH_VISIBLE . "</b>:" . _TC_VISIBLE . " &nbsp;

			<b>" . _TC_TH_SUBMENU . "</b>:" . _TC_SUBMENU . "

		</div>

		<form action='index.php' name='MainForm' method='post'>

		" . $xoopsGTicket->getTicketHtml(__LINE__) . "

		<div class='table-responsive'>

		<table class='table table-striped table-hover table-bordered align-middle'>

		<thead class='table-light'>

		<tr>

			<th class='text-end'>" . _TC_STORYID . "</th>

			<th class='text-center'>" . _TC_HOMEPAGE . "</th>

			<th>" . _TC_LINKNAME . "</th>

			<th class='text-center'>" . _TC_LINKID . "</th>

			<th class='text-center'>" . _TC_TH_VISIBLE . "</th>

			<th class='text-center'>" . _TC_TH_SUBMENU . "</th>

			<th>" . _TC_CONTENTTYPE . "</th>

			<th class='text-end'>" . _TC_ACTION . "</th>

		</tr>

		</thead>

		<tbody>\n";

        $result = $xoopsDB->query("SELECT storyid,blockid,title,visible,homepage,        link,submenu,nohtml,UNIX_TIMESTAMP(last_modified) FROM $mytablename ORDER BY blockid");

                while (list($id, $weight, $title, $visible, $homepage, $link, $submenu, $nohtml, $last_modified) = $xoopsDB->fetchRow($result)) {

            $title4show = $myts->makeTboxData4Show($title);

            $visible_checked = $visible ? "checked='checked'" : "";

            $submenu_checked = $submenu ? "checked='checked'" : "";

            // db content

            $line_class = 'odd';

            $op_for_edit = 'edit';

            $opname_for_edit = _TC_EDIT;

            $opname_for_delete = _TC_DELETE;

            $link_to_spaw = '';

            if ($link > 0) {

                // legacy wrapped page (can no longer be created or edited)

                $op_for_edit = 'show';

                $opname_for_edit = '';

                $content_type = "WRAP$link";

                $extended_link = '';

            } else {

                switch ($nohtml) {

                    case '18':

                        $content_type = "Text_Wiki (+bb)";

                        $extended_link = "(<a href='?op=edit&amp;id=$id&amp;useplain=1' style='font-size:xx-small;'>PLAIN</a>)";

                        break;

                    case '16':

                        $content_type = "Text_Wiki";

                        $extended_link = "(<a href='?op=edit&amp;id=$id&amp;useplain=1' style='font-size:xx-small;'>PLAIN</a>)";

                        break;

                    case '10':

                        $content_type = "PHP (+bb)";

                        $extended_link = "(<a href='?op=edit&amp;id=$id&amp;useplain=1' style='font-size:xx-small;'>PLAIN</a>)";

                        break;

                    case '8':

                        $content_type = "PHP";

                        $extended_link = "(<a href='?op=edit&amp;id=$id&amp;useplain=1' style='font-size:xx-small;'>PLAIN</a>)";

                        break;

                    case '3':

                        $content_type = "TEXT (-bb)";

                        $extended_link = '';

                        break;

                    case '2':

                        $content_type = "HTML (-bb)";

                        $extended_link = $link_to_spaw;

                        break;

                    case '1':

                        $content_type = "TEXT (+bb)";

                        $extended_link = '';

                        break;

                    case '0':

                        $content_type = "HTML (+bb)";

                        $extended_link = $link_to_spaw;

                        break;

                    default:

                        $content_type = "unknown";

                        $extended_link = '';

                }

                // editing is always done with CKEditor, so no per-editor links
                $extended_link = '';

            }

            echo "

		<tr>

			<td class='text-end'>$id<input type='hidden' name='id[]' value='$id' /></td>

			<td class='text-center'><input class='form-check-input' type='radio' name='homepage' value='$id' " . ($homepage ? "checked='checked'" : "") . " /></td>

			<td><a href='../index.php?id=$id'>$title4show</a></td>

			<td class='text-center'><input class='form-control form-control-sm text-end' style='width:5rem;display:inline-block;' type='text' name='blockid[$id]' size='3' maxlength='8' value='$weight' /></td>

			<td class='text-center'><input class='form-check-input' type='checkbox' name='visible[$id]' $visible_checked /></td>

			<td class='text-center'><input class='form-check-input' type='checkbox' name='submenu[$id]' $submenu_checked /></td>

			<td><span class='badge text-bg-secondary'>$content_type</span></td>

			<td class='text-end'><a href='index.php?op=$op_for_edit&amp;id=$id'>$opname_for_edit</a> $extended_link | <a class='text-danger' href='index.php?op=delete&amp;id=$id'>$opname_for_delete</a> | <input class='form-check-input' type='checkbox' name='checked_ids[$id]' /><br /><small class='text-muted'>" . formatTimestamp($last_modified, "m") . "</small></td>

		</tr>\n";

        }

        echo "

		</tbody>

		<tfoot>

		<tr>

			<td colspan='8' class='text-end'>

				<div class='d-inline-flex align-items-center gap-2'>

				" . _TC_CHECKED_ITEMS_ARE . "

				<select class='form-select form-select-sm w-auto' name='dest_tinyd' onchange='document.MainForm.moveto.disabled=false;'>

					$dest_tinyd_options

				</select>

				<input class='btn btn-outline-primary btn-sm' type='submit' name='moveto' value='" . _TC_BUTTON_MOVETO . "' disabled='disabled' />

				</div>

			</td>

		</tr>

		</tfoot>

	</table>

	</div>

	<div class='text-center mb-4'>

		<input type='hidden' name='op' value='update' />

		<input class='btn btn-primary' type='submit' name='submit' value='" . _SUBMIT . "' />

		<input class='btn btn-outline-secondary' type='reset' />

	</div>

	</form>\n";

        tinyd_cp_footer();

        break;

// ------------------------------------------------------------------------- //

// Update Content -> Show Content Page                                       //

// ------------------------------------------------------------------------- //

    case "update":

        // Ticket Check

        if (!$xoopsGTicket->check()) {

            redirect_header(XOOPS_URL . '/', 3, $xoopsGTicket->getErrors());

        }

        if (!is_array($_POST['id'])) {
            break;
        }

        $homepage = empty($_POST['homepage']) ? 0 : intval($_POST['homepage']);

        foreach ($_POST['id'] as $storyid) {

            $storyid = intval($storyid);

            if ($homepage == 0) {

                $hp_flag = 1;

                $homepage = $storyid;

            } else {

                $hp_flag = $storyid == $homepage ? 1 : 0;

            }

            $blockid = empty($_POST['blockid'][$storyid]) ? 0 : intval($_POST['blockid'][$storyid]);

            $visible = empty($_POST['visible'][$storyid]) ? 0 : 1;

            $submenu = empty($_POST['submenu'][$storyid]) ? 0 : 1;

            $sql = "UPDATE $mytablename SET blockid='$blockid',visible='$visible',homepage='$hp_flag',submenu='$submenu',last_modified=last_modified WHERE storyid='$storyid'";

            $xoopsDB->query($sql) or die(_TC_ERRORINSERT);

        }

        redirect_header("index.php?op=show", 1, _TC_DBUPDATED);

        exit;

        break;

// ------------------------------------------------------------------------- //

// Show add or edit content Page                                             //

// ------------------------------------------------------------------------- //

    case "submit":

    case "edit":

        tinyd_cp_header('index.php?op=submit');

        // initialization

        if (!empty($_POST['preview'])) {

            $globals = array(

                'id' => 0,

                'title' => '',

                'message' => '',

                'visible' => 0,

                'nohtml' => 0,

                'nosmiley' => 0,

                'nobreaks' => 0,

                'submenu' => 0,

                'last_modified' => 0,

                'created' => 0,

                'html_header' => '',

            );

            foreach ($globals as $global => $default) {

                if (isset($_POST[$global])) {
                    $$global = $myts->stripSlashesGPC($_POST[$global]);
                } else {
                    $$global = $default;
                }

            }

            $storyid = intval($id);

            // write posted data into sesion

            $_SESSION['tinyd_preview_post'] = array(

                'message' => $message,

                'nohtml' => intval($nohtml),

                'nosmiley' => intval($nosmiley),

                'nobreaks' => intval($nobreaks),

            );

            /* $content_cache = "{$mydirname}_preview_" . time() ;

        $fp = fopen( XOOPS_CACHE_PATH . '/' . $content_cache , 'w' ) ;

        if( $fp === false ) {

        unset( $_POST['preview'] ) ;

        } else {

        fwrite( $fp , $message , 65536 ) ;

        fclose( $fp ) ;

        }*/

        } else if ($op == 'edit') {

            $result = $xoopsDB->query("SELECT storyid,title,text,visible,nohtml,nosmiley,            nobreaks,submenu,UNIX_TIMESTAMP(last_modified),UNIX_TIMESTAMP(created),html_header FROM $mytablename WHERE storyid='$id'");

                        list($storyid, $title, $message, $visible, $nohtml, $nosmiley, $nobreaks, $submenu, $last_modified, $created, $html_header) = $xoopsDB->fetchRow($result);

        } else {

                        list($storyid, $title, $message, $visible, $nohtml, $nosmiley, $nobreaks, $submenu, $last_modified, $created, $html_header) = array(0, '', '', 1, 0, 0, 1, 1, 0, 0, '');

        }

        if ($op == 'edit') {

            $form_title = _TC_EDITCONTENT;

            $next_op = "editit";

        } else {

            $form_title = _TC_ADDCONTENT;

            $next_op = "add";

        }

        // get configs

        $header_tarea_height = empty($xoopsModuleConfig['tc_header_tarea_height']) ? 0 : intval($xoopsModuleConfig['tc_header_tarea_height']);

        $tarea_width = empty($xoopsModuleConfig['tc_tarea_width']) ? 35 : intval($xoopsModuleConfig['tc_tarea_width']);

        echo "

		<h4 class='mb-3'>" . $xoopsModule->getVar('name') . "</h4>\n";

        $form_target = 'index.php';

        // beggining of xoopsForm

        $form = new XoopsThemeForm($form_title, "MainForm", $form_target);

        // title

        $form->addElement(new XoopsFormText(_TC_LINKNAME, "title", 50, 255, htmlspecialchars($title, ENT_QUOTES)));

        // html header

        if ($header_tarea_height > 0) {

            $h_area = new XoopsFormTextArea(_TC_HTML_HEADER, 'html_header', htmlspecialchars($html_header, ENT_QUOTES), $header_tarea_height, $tarea_width);

            $h_area->setExtra("style='width: {$tarea_width}em;'");

            $form->addElement($h_area);

        } else {

            $form->addElement(new XoopsFormHidden('html_header', htmlspecialchars($html_header, ENT_QUOTES)));

        }

        // content body (CKEditor from tadtools)

        Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/$mydirname/");
        Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/$mydirname/image");
        Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/$mydirname/file");
        $ck = new CkEditor($mydirname, "message", $message);
        $ck->setHeight(500);
        $editor = $ck->render();

        $form->addElement(new XoopsFormLabel(_TC_CONTENT, $editor));

        // options

        $option_tray = new XoopsFormElementTray(_OPTIONS, '<br />');

        // smiley

        $smiley_checkbox = new XoopsFormCheckBox('', 'nosmiley', $nosmiley);

        $smiley_checkbox->addOption(1, _DISABLESMILEY);

        $option_tray->addElement($smiley_checkbox);

        // nobreaks (CKEditor content is HTML)

        $form->addElement(new XoopsFormHidden('nobreaks', 1));

        // visible

        $visible_checkbox = new XoopsFormCheckBox('', 'visible', $visible);

        $visible_checkbox->addOption(1, _TC_VISIBLE);

        $option_tray->addElement($visible_checkbox);

        // submenu

        $submenu_checkbox = new XoopsFormCheckBox('', 'submenu', $submenu);

        $submenu_checkbox->addOption(1, _TC_SUBMENU);

        $option_tray->addElement($submenu_checkbox);

        $form->addElement($option_tray);

        // content type is always HTML (CKEditor)

        $form->addElement(new XoopsFormHidden('nohtml', 0));

        // last_modified

        $lm_tray = new XoopsFormElementTray(_TC_LASTMODIFIED, '&nbsp;');

        $lm_tray->addElement(new XoopsFormLabel('', formatTimestamp($last_modified)));

        $lm_checkbox = new XoopsFormCheckBox('', 'dont_update_last_modified', 0);

        $lm_checkbox->addOption(1, _TC_DONTUPDATELASTMODIFIED);

        $lm_tray->addElement($lm_checkbox);

        $form->addElement($lm_tray);

        // created

        $form->addElement(new XoopsFormLabel(_TC_CREATED, formatTimestamp($created)));

        // buttons

        $submit_tray = new XoopsFormElementTray('', ' &nbsp; &nbsp; ');

        $submit_tray->addElement(new XoopsFormButton("", "preview", _PREVIEW, "submit"));

        $submit_tray->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));

        if ($op == 'edit') {
            $submit_tray->addElement(new XoopsFormButton("", "saveas", _TC_SAVEAS, "submit"));
        }

        $submit_tray->addElement(new XoopsFormButton("", "cancel", _CANCEL, "submit"));

        $form->addElement($submit_tray);

        // hiddens

        $form->addElement(new XoopsFormHidden('op', $next_op));

        $form->addElement(new XoopsFormHidden('id', $storyid));

        $form->addElement(new XoopsFormHidden('last_modified', $last_modified));

        // Ticket

        $GLOBALS['xoopsGTicket']->addTicketXoopsFormElement($form, __LINE__);

        // end of xoopsForm

        $form->display();

        tinyd_cp_footer();

        // preview popup

        if (!empty($_POST['preview'])) {

            // Ticket Check

            if (!$xoopsGTicket->check()) {

                redirect_header(XOOPS_URL . '/', 3, $xoopsGTicket->getErrors());

            }

            echo '

		<script type="text/javascript">

		<!--//

		preview_window = openWithSelfMain( "' . $mymodurl . '/preview.php" , "popup" , 680 , 450 ) ;

		//-->

		</script>';

        }

        break;

// ------------------------------------------------------------------------- //

// INSERT or UPDATE content to database                                      //

// ------------------------------------------------------------------------- //

    case "add":

    case "editit":

        // Ticket Check

        if (!$xoopsGTicket->check()) {

            redirect_header(XOOPS_URL . '/', 3, $xoopsGTicket->getErrors());

        }

        $title4save = addslashes($_POST['title']);

        $html_header4save = addslashes($_POST['html_header']);

        $text4save = addslashes($_POST['message']);

        $visible = empty($_POST['visible']) ? 0 : 1;

        $nohtml = empty($_POST['nohtml']) ? 0 : intval($_POST['nohtml']);

        $nosmiley = empty($_POST['nosmiley']) ? 0 : 1;

        $nobreaks = empty($_POST['nobreaks']) ? 0 : 1;

        $submenu = empty($_POST['submenu']) ? 0 : 1;

        // hp flag is set if there are no records which has flag of homepage

        $result = $xoopsDB->query("SELECT COUNT(*) FROM $mytablename WHERE homepage>0");

        list($count_home) = $xoopsDB->fetchRow($result);

        $hp_flag = $count_home > 0 ? 0 : 1;

        $sql_set = "SET title='$title4save',text='$text4save',visible='$visible',nohtml='$nohtml',nosmiley='$nosmiley',nobreaks='$nobreaks',link='0',submenu='$submenu',html_header='$html_header4save'";

        if ($op == 'add' || !empty($_POST['saveas'])) {

            $sql = "INSERT INTO $mytablename $sql_set,created=NOW(),homepage='$hp_flag'";

        } else {

            // not to update last_modified

            if (!empty($_POST['dont_update_last_modified'])) {
                $sql_set .= ",last_modified=last_modified";
            }

            // change homepage only when it should be turned on

            if ($hp_flag) {
                $sql_set .= ",homepage='$hp_flag'";
            }

            $id = empty($_POST['id']) ? 0 : intval($_POST['id']);

            $sql = "UPDATE $mytablename $sql_set WHERE storyid='$id'";

        }

        $result = $xoopsDB->query($sql) or die(_TC_ERRORINSERT);

        redirect_header("index.php?op=show", 1, _TC_DBUPDATED);

        exit;

        break;

// ------------------------------------------------------------------------- //

// Delete Content - Confirmation Question                                    //

// ------------------------------------------------------------------------- //

    case "delete":

        tinyd_cp_header();

        xoops_confirm(array('id' => intval($_GET['id']), 'op' => 'deleteit') + $xoopsGTicket->getTicketArray(__LINE__), 'index.php', _TC_RUSUREDEL, _YES);

                tinyd_cp_footer();

        break;

// ------------------------------------------------------------------------- //

// Delete it definitely                                                      //

// ------------------------------------------------------------------------- //

    case "deleteit":

        // Ticket Check

        if (!$xoopsGTicket->check()) {

            redirect_header(XOOPS_URL . '/', 3, $xoopsGTicket->getErrors());

        }

        $id = empty($_POST['id']) ? 0 : intval($_POST['id']);

        $result = $xoopsDB->query("DELETE FROM $mytablename WHERE storyid='$id'");

        redirect_header("index.php?op=show", 1, _TC_DBUPDATED);

        exit;

        break;

// ------------------------------------------------------------------------- //

// Export to the other TinyD

// ------------------------------------------------------------------------- //

    case "moveto":

        // Ticket Check

        if (!$xoopsGTicket->check()) {

            redirect_header(XOOPS_URL . '/', 3, $xoopsGTicket->getErrors());

        }

        $destModule = $module_handler->get(intval($_POST['dest_tinyd']));

        // error check

        if (empty($_POST['checked_ids']) || !is_object($destModule)) {

            redirect_header("index.php?op=show", 1, _TC_DBUPDATED);

            exit;

        }

        $dest_dirname = $destModule->getVar('dirname');

        if (!preg_match('/^(\D+)(\d*)$/', $dest_dirname, $regs)) {
            echo ("invalid dirname: " . htmlspecialchars($dest_dirname));
        }

        $dest_dirnumber = $regs[2] === '' ? '' : intval($regs[2]);

        $dest_tablename = $xoopsDB->prefix("tinycontent{$dest_dirnumber}");

        $src_mid = $xoopsModule->getVar('mid');

        $dest_mid = $destModule->getVar('mid');

        // authority check

        if (!$xoopsUser->isAdmin($dest_mid)) {

            redirect_header(XOOPS_URL . '/', 1, _NOPERM);

            exit;

        }

        foreach ($_POST['checked_ids'] as $src_id => $val) {

            if (!$val) {
                continue;
            }

            $rs = $xoopsDB->query("SELECT * FROM $mytablename WHERE storyid='" . intval($src_id) . "'");

            if (!($rows = $xoopsDB->fetchArray($rs))) {
                continue;
            }

            $set_sql = '';

            foreach ($rows as $colname => $colval) {

                if ($colname == 'storyid' || $colname == 'homepage') {
                    continue;
                }

                $set_sql .= "$colname='" . addslashes($colval) . "',";

            }

            $set_sql = substr($set_sql, 0, -1);

            $ins_rs = $xoopsDB->query("INSERT INTO $dest_tablename SET $set_sql");

            $dest_id = $xoopsDB->getInsertId();

            if (!$ins_rs || $dest_id <= 0) {

                redirect_header("index.php?op=show", 5, 'The target module should be updated');

                exit;

            }

            // delete the record

            $del_rs = $xoopsDB->query("DELETE FROM $mytablename WHERE storyid='" . intval($src_id) . "'");

        }

        redirect_header("index.php?op=show", 1, _TC_DBUPDATED);

        exit;

        break;

}
