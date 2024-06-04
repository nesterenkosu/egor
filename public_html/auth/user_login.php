<? //Вход под учётной записью пользователя (логины и пароли хранятся в БД)
require_once("$_SERVER[DOCUMENT_ROOT]/../auth/auth.inc.php");

$msg="";
if(isset($_POST["Enter"]))
{  
  $parsed=parse_url($_SERVER["HTTP_REFERER"]);		
  $referer="$parsed[scheme]://$parsed[host]$parsed[path]";
 
  if(auth_user($_POST["user_login"],$_POST["user_password"]))
		header("Location: http://$_SERVER[HTTP_HOST]/");
  else
	{
		$msg="Неправильный логин или пароль";
		header("Location: $referer?msg=$msg");
	}
}
