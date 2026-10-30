<h4 class="mb-3"><{$module_name}></h4>

<form action="index.php" name="MainForm" method="post">
    <{$ticket_html}>
    <input type="hidden" name="op" value="<{$next_op}>">
    <input type="hidden" name="id" value="<{$storyid}>">
    <input type="hidden" name="last_modified" value="<{$last_modified}>">
    <input type="hidden" name="nohtml" value="0">
    <input type="hidden" name="nobreaks" value="1">

    <div class="card shadow-sm mb-4">
        <div class="card-header fw-bold"><{$form_title}></div>
        <div class="card-body">

            <div class="mb-3">
                <label class="form-label fw-bold" for="tinyd-title"><{$smarty.const._TC_LINKNAME}></label>
                <input class="form-control" type="text" id="tinyd-title" name="title" maxlength="255" value="<{$title|escape}>">
            </div>

            <{if $show_html_header}>
                <div class="mb-3">
                    <label class="form-label fw-bold" for="tinyd-html-header"><{$smarty.const._TC_HTML_HEADER}></label>
                    <textarea class="form-control font-monospace" id="tinyd-html-header" name="html_header" rows="<{$header_rows}>"><{$html_header|escape}></textarea>
                </div>
            <{else}>
                <input type="hidden" name="html_header" value="<{$html_header|escape}>">
            <{/if}>

            <div class="mb-3">
                <label class="form-label fw-bold"><{$smarty.const._TC_CONTENT}></label>
                <div><{$editor}></div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold"><{$smarty.const._OPTIONS}></label>
                <div class="d-flex flex-wrap gap-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="tinyd-nosmiley" name="nosmiley" value="1"<{if $nosmiley}> checked="checked"<{/if}>>
                        <label class="form-check-label" for="tinyd-nosmiley"><{$smarty.const._DISABLESMILEY}></label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="tinyd-visible" name="visible" value="1"<{if $visible}> checked="checked"<{/if}>>
                        <label class="form-check-label" for="tinyd-visible"><{$smarty.const._TC_VISIBLE}></label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="tinyd-submenu" name="submenu" value="1"<{if $submenu}> checked="checked"<{/if}>>
                        <label class="form-check-label" for="tinyd-submenu"><{$smarty.const._TC_SUBMENU}></label>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold"><{$smarty.const._TC_LASTMODIFIED}></label>
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <span><{$last_modified_text}></span>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="tinyd-dont-update" name="dont_update_last_modified" value="1">
                            <label class="form-check-label" for="tinyd-dont-update"><{$smarty.const._TC_DONTUPDATELASTMODIFIED}></label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold"><{$smarty.const._TC_CREATED}></label>
                    <div><{$created_text}></div>
                </div>
            </div>
        </div>

        <div class="card-footer d-flex flex-wrap gap-2">
            <input class="btn btn-outline-secondary" type="submit" name="preview" value="<{$smarty.const._PREVIEW}>">
            <input class="btn btn-primary" type="submit" name="submit" value="<{$smarty.const._SUBMIT}>">
            <{if $is_edit}>
                <input class="btn btn-outline-primary" type="submit" name="saveas" value="<{$smarty.const._TC_SAVEAS}>">
            <{/if}>
            <input class="btn btn-outline-danger" type="submit" name="cancel" value="<{$smarty.const._CANCEL}>">
        </div>
    </div>
</form>
