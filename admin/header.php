<?php
// Admin header/footer helpers (same structure as tadtools: Xmf admin navigation + stylesheet)

require_once dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';

xoops_loadLanguage('modinfo', $xoopsModule->getVar('dirname'));
xoops_loadLanguage('admin', $xoopsModule->getVar('dirname'));

function tinyd_cp_header($menu = '')
{
    global $xoTheme;

    xoops_cp_header();

    $xoTheme->addStylesheet('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');

    echo "<style>
	.CPbigTitle { display: none; }
	.tinyd-admin table.outer { width: 100%; margin-bottom: 1rem; border-collapse: collapse; border: 1px solid #dee2e6; }
	.tinyd-admin table.outer th { background: #f8f9fa; padding: .5rem .75rem; border: 1px solid #dee2e6; }
	.tinyd-admin table.outer td { padding: .5rem .75rem; border: 1px solid #dee2e6; vertical-align: middle; }
	.tinyd-admin table.outer td.head { background: #f8f9fa; font-weight: 600; width: 25%; }
	.tinyd-admin input[type=text], .tinyd-admin input[type=file], .tinyd-admin input[type=password], .tinyd-admin select, .tinyd-admin textarea { display: inline-block; max-width: 100%; padding: .375rem .75rem; border: 1px solid #ced4da; border-radius: .375rem; }
	.tinyd-admin input[type=submit], .tinyd-admin input[type=button], .tinyd-admin input[type=reset], .tinyd-admin button { display: inline-block; padding: .375rem .75rem; color: #fff; background: #0d6efd; border: 1px solid #0d6efd; border-radius: .375rem; cursor: pointer; }
	.tinyd-admin input[type=reset] { color: #212529; background: #e9ecef; border-color: #ced4da; }
	.tinyd-admin input[type=submit]:disabled { opacity: .65; cursor: not-allowed; }
</style>\n";

    $adminObject = \Xmf\Module\Admin::getInstance();
    $adminObject->displayNavigation($menu);

    echo "<div class='tinyd-admin container-fluid'>\n";
}

function tinyd_cp_footer()
{
    echo "</div>\n";
    xoops_cp_footer();
}
