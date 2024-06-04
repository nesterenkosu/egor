<?php
	error_reporting(~E_WARNING);

	require_once("$_SERVER[DOCUMENT_ROOT]/../auth/auth.inc.php");	
	
	$login_ok=true;
	if(isset($_POST["Enter"])) {
		$login_ok=auth_user($_POST["email"],$_POST["pswd"]);
		if($login_ok) 
			header("Location: http://$_SERVER[HTTP_HOST]/");	
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="shortcut icon" href="icons/skif.png" />
  <title>Авторизация</title>
  <style>
        body {
            background-image: url('/img/fon.jpg');
            background-size: cover;
            }
    </style>
  <link rel="stylesheet" href="/css/regist.css"/>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="contain">
  <h2>Авторизация</h2>
	<form action="" method="POST">
		<div class="mb-3 mt-3">
		  <label for="email">Логин:</label>
		  <input type="text" class="form-control" id="email" placeholder="Введите логин" name="email">
		</div>
		<div class="mb-3">
		  <label for="pwd">Пароль:</label>
		  <input type="password" class="form-control" id="pwd" placeholder="Введите пароль" name="pswd">
		</div>
		<div class="form-check mb-3">
		  <label class="form-check-label">
		  <p>У меня еще нет <a href="/registration.php">аккаунта</a></p>
		  </label>
		</div>    
		<button name="Enter" class="btn btn-outline-secondary">Войти</button><br/>
		<?if(!$login_ok):?>
			<div class="alert alert-danger" style="margin-top: 17px;">
				Неправильное имя пользователя или пароль
			</div>
		<?endif;?>
    </form>
</div>
</body>
</html>
