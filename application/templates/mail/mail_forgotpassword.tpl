<:$forgotpassword|escape:'html':>
<:$dear|escape:'html':> <:$user.full_name|escape:'html':> ,
<:$yourname|escape:'html':> <:$user.username|escape:'html':>
<:$pleaseclick|escape:'html':> <a href="<:$user.domain:>/auth/resetPassword/?email=<:$user.username|escape:'html':>&secret=<:$user.code:>"><:$here|escape:'html':></a>
<:$regard|escape:'html':>