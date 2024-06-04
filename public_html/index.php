<?php 
	error_reporting(~E_WARNING);

	require_once("$_SERVER[DOCUMENT_ROOT]/../auth/auth.inc.php");
	
	if(user_authorized()) {
		echo "Пользователь авторизован. Данные пользователя:";
		echo "<xmp>";
		print_r($_SESSION);
		echo "</xmp>";
		echo "<a href=\"/auth/exit.php\">Разлогиниться</a>";
	}else{
		echo "Пользователь не авторизован. <a href=\"authorization.php\">Аутентификация</a>";
	}
	