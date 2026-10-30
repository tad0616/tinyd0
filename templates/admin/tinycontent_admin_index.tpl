<h4 class="mb-3"><{$module_name}></h4>

<div class="d-flex flex-wrap gap-2 mb-3">
    <a class="btn btn-primary btn-sm" href="?op=submit"><{$smarty.const._TC_ADDCONTENT}></a>
</div>

<div class="text-end small text-muted mb-2">
    <b><{$smarty.const._TC_TH_VISIBLE}></b>:<{$smarty.const._TC_VISIBLE}> &nbsp;
    <b><{$smarty.const._TC_TH_SUBMENU}></b>:<{$smarty.const._TC_SUBMENU}>
</div>

<form action="index.php" name="MainForm" method="post">
    <{$ticket_html}>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th class="text-end"><{$smarty.const._TC_STORYID}></th>
                    <th class="text-center"><{$smarty.const._TC_HOMEPAGE}></th>
                    <th><{$smarty.const._TC_LINKNAME}></th>
                    <th class="text-center"><{$smarty.const._TC_LINKID}></th>
                    <th class="text-center"><{$smarty.const._TC_TH_VISIBLE}></th>
                    <th class="text-center"><{$smarty.const._TC_TH_SUBMENU}></th>
                    <th><{$smarty.const._TC_CONTENTTYPE}></th>
                    <th class="text-center">最後編輯日期</th>
                    <th class="text-end"><{$smarty.const._TC_ACTION}></th>
                </tr>
            </thead>
            <tbody>
                <{foreach from=$rows item=row}>
                    <tr>
                        <td class="text-end"><{$row.id}><input type="hidden" name="id[]" value="<{$row.id}>"></td>
                        <td class="text-center"><input class="form-check-input" type="radio" name="homepage" value="<{$row.id}>"<{if $row.homepage}> checked="checked"<{/if}>></td>
                        <td><a href="../index.php?id=<{$row.id}>"><{$row.title}></a></td>
                        <td class="text-center"><input class="form-control form-control-sm text-end" style="width:5rem;display:inline-block;" type="text" name="blockid[<{$row.id}>]" size="3" maxlength="8" value="<{$row.weight}>"></td>
                        <td class="text-center"><input class="form-check-input" type="checkbox" name="visible[<{$row.id}>]"<{if $row.visible}> checked="checked"<{/if}>></td>
                        <td class="text-center"><input class="form-check-input" type="checkbox" name="submenu[<{$row.id}>]"<{if $row.submenu}> checked="checked"<{/if}>></td>
                        <td><span class="badge text-bg-secondary"><{$row.content_type}></span></td>
                        <td class="text-center text-nowrap small"><{$row.date}></td>
                        <td class="text-end">
                            <{if $row.edit_label}><a href="index.php?op=<{$row.op_for_edit}>&amp;id=<{$row.id}>"><{$row.edit_label}></a> | <{/if}>
                            <a class="text-danger" href="index.php?op=delete&amp;id=<{$row.id}>"><{$smarty.const._TC_DELETE}></a> |
                            <input class="form-check-input" type="checkbox" name="checked_ids[<{$row.id}>]">
                        </td>
                    </tr>
                <{/foreach}>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="9" class="text-end">
                        <div class="d-inline-flex align-items-center gap-2">
                            <{$smarty.const._TC_CHECKED_ITEMS_ARE}>
                            <select class="form-select form-select-sm w-auto" name="dest_tinyd" onchange="document.MainForm.moveto.disabled=false;">
                                <option value="">--</option>
                                <{foreach from=$dest_options item=opt}>
                                    <option value="<{$opt.mid}>"><{$opt.name}></option>
                                <{/foreach}>
                            </select>
                            <input class="btn btn-outline-primary btn-sm" type="submit" name="moveto" value="<{$smarty.const._TC_BUTTON_MOVETO}>" disabled="disabled">
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="text-center mb-4">
        <input type="hidden" name="op" value="update">
        <input class="btn btn-primary" type="submit" name="submit" value="<{$smarty.const._SUBMIT}>">
        <input class="btn btn-outline-secondary" type="reset">
    </div>
</form>
