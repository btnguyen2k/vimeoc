{config_load file="template.conf" section="setup"}
<html>
<head>
{include file="{$base_dir_decorator}/default_header.tpl"}
</head>
<body>
{include file="{$body_code}"}

{include file="{$base_dir_decorator}/default_footer.tpl"}
</body>
</html>