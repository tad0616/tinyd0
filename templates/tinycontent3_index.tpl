<{* Bootstrap 5 layout. Requires Bootstrap 5 CSS to be loaded by the theme. *}>
<{* Last Modified: <{$last_modified|date_format:"%Y-%m-%d"}> *}>

<article class="tinycontent-article">

<{if $is_display_print_icon || $is_display_friend_icon }>
	<div class="d-flex justify-content-end gap-2 mb-3 d-print-none">
	<{if $is_display_print_icon }>
		<a class="btn btn-outline-secondary btn-sm" href="<{$mod_url}>/print.php?id=<{$id}>" target="_blank" rel="noopener" title="<{$lang_printerpage}>"><img src="<{$mod_url}>/images/print.gif" height="20" alt="<{$lang_printerpage}>" /></a>
	<{/if}>
	<{if $is_display_friend_icon }>
		<a class="btn btn-outline-secondary btn-sm" href="<{$mail_link}>" target="_top" title="<{$lang_sendstory}>"><img src="<{$mod_url}>/images/friend.gif" height="20" alt="<{$lang_sendstory}>" /></a>
	<{/if}>
	</div>
<{/if}>

	<div class="tinycontent-body clearfix">
		<{$content}>
	</div>

</article>

<{if $is_display_pagenav }>
<nav class="mt-4 pt-3 border-top d-print-none" aria-label="pagination">
	<div class="row align-items-start g-2">
		<div class="col-4 text-start">
		<{if $prev_link }>
			<a class="btn btn-outline-primary btn-sm" href="<{$vmod_url}>/<{$prev_link}>" accesskey="P">&laquo; <{$lang_prevpage}></a>
			<div class="small text-muted mt-1"><{$prev_title}></div>
		<{/if}>
		</div>
		<div class="col-4 text-center">
			<a class="btn btn-outline-secondary btn-sm" href="<{$vmod_url}>/<{$top_link}>" accesskey="H"><{$lang_topofcontents}></a>
		</div>
		<div class="col-4 text-end">
		<{if $next_link }>
			<a class="btn btn-outline-primary btn-sm" href="<{$vmod_url}>/<{$next_link}>" accesskey="N"><{$lang_nextpage}> &raquo;</a>
			<div class="small text-muted mt-1"><{$next_title}></div>
		<{/if}>
		</div>
	</div>
</nav>
<{/if}>
