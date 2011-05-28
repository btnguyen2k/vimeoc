{config_load file="template.conf" section="setup"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
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