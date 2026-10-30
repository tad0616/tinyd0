<!DOCTYPE html>
<html lang="zh-Hant">
<head>
	<meta charset="<{$charset|default:'UTF-8'}>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title><{$title}> - <{$sitename}></title>
	<meta name="GENERATOR" content="TinyContent-Duplicatable with XOOPS" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
	<style>
		@media print { .container { max-width: 100%; } a { text-decoration: none; } }
	</style>
</head>
<body onload="window.print()">
	<main class="container my-4" style="max-width: 900px;">
		<header class="text-center mb-4 pb-3 border-bottom">
			<img src="<{$xoops_url}>/images/logo.gif" class="img-fluid mb-2" alt="<{$sitename}>" />
			<h1 class="h3"><{$title}></h1>
		</header>

		<div class="mb-4"><{$content}></div>

		<footer class="border-top pt-3 small text-muted">
			<div><{$lang_comesfrom}> <a href="<{$site_url}>/"><{$site_url}></a></div>
			<div><{$lang_contentfrom}> <a href="<{$content_url}>"><{$content_url}></a></div>
		</footer>
	</main>
</body>
</html>
