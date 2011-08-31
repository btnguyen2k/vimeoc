<title><:$title:></title>
<link href="<:$ctx:>/css/style.css" rel="stylesheet" type="text/css">

<!-- jquery library -->
<script src="<:$ctx:>/script/jquery.min.js" type="text/javascript"></script>

<!-- jquery form library -->
<script src="<:$ctx:>/script/jquery.form.js" type="text/javascript"></script>

<!-- Facebox library -->
<script src="<:$ctx:>/script/facebox/facebox.js" type="text/javascript"></script>
<link href="<:$ctx:>/script/facebox/facebox.css" rel="stylesheet" type="text/css">

<!-- Global -->
<script type="text/javascript" src="<:$ctx:>/script/global.js"></script>
<script type="text/javascript">
	var ctx = '<:$ctx:>';
</script>

<meta http-equiv="content-language" content="en" />
<!-- HTTP 1.1 -->
<meta http-equiv="Cache-Control" content="no-store"/>
<!-- HTTP 1.0 -->
<meta http-equiv="Pragma" content="no-cache"/>
<!-- Prevents caching at the Proxy Server -->
<meta http-equiv="Expires" content="0"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="content-language" content="en">
<link rel="Shortcut Icon" href="/images/favicon.ico" />

<:if $keywords:>
	<meta name="keywords" content="<:$keywords|escape:'html':>" />
<:/if:>
