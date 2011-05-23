{config_load file="template.conf" section="setup"}
<html>
<head>
{include file="{$base_dir_decorator}/default_header.tpl"}
</head>
<body>
<center>
<div id="main">
{include file="{$body_code}"}

{include file="{$base_dir_decorator}/default_footer.tpl"}
</div>
</center>
</body>
</html>