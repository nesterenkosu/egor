<?php
require_once("$_SERVER[DOCUMENT_ROOT]/../db/databases.php");
require_once("$_SERVER[DOCUMENT_ROOT]/../db/dal.inc.php");

error_reporting(E_ALL);
//ВАЛИДАЦИЯ ВВОДА НА PHP
	$errmsg=""; $isvalid=true; $selectors="";
	function set_error($message, $input_selector="") {
		global $errmsg, $isvalid, $selectors;
		static $comma;
		$errmsg.=$message."<br/>";
		if(trim($input_selector)!="")
			$selectors.="$comma $input_selector";
		$comma=",";
		$isvalid=false;
	}

if(isset($_POST["btn_reg_user"])) {	
	$name=mysqli_real_escape_string($connection,$_POST["name"]);
	$mail=mysqli_real_escape_string($connection,$_POST["mail"]);
	$password=md5($_POST["pass"]);
	$login=mysqli_real_escape_string($connection,$_POST["login"]);
	
	/*die("
		INSERT INTO	users(Role,Name,Mail,Password) VALUES(2,'$name','$mail','$password')
	");*/
	
	mysqli_query($connection,"
		INSERT INTO	users
			(Role,Name,Full_name,Number,Mail,Passport_data,Inn,Login,Password) 
		VALUES
			(2,'$name','','','$mail','','','$login','$password')
	");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="shortcut icon" href="icons/skif.png" />
  <title>Регистарция</title>
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
  <!-- action="/actions/register.php" -->
<form action="" method="POST">
  <h2>Регистрация</h2>
	<div class="mb-3 mt-3">
      <label for="email">Роль:</label>
      <select class="form-select">
	  <?while($role=DBFetchRole()):?>
	  <option value="<?=$role["ID"]?>"><?=$role["Role_name"]?></option>
	  <?endwhile;?>
	  </select>
    </div>
    <div class="mb-3 mt-3">
      <label for="email">Имя:</label>
      <input type="text" class="form-control" id="email" placeholder="Иван" name="name">
    </div>
    <div class="mb-3">
      <label for="pwd">Фамилия:</label>
      <input type="login" class="form-control" id="pwd" placeholder="Иванов" name="Sname">
    </div>
    <div class="mb-3">
      <label for="cds">Номер:</label>
      <input type="login" class="form-control" id="cds" placeholder="7 812 348 52 16" name="number">
    </div>
    <div class="mb-3">
      <label for="nnh">Почта:</label>
      <input type="login" class="form-control" id="nnh" placeholder="yourmail@gmail.com" name="mail">
    </div>
    <div class="mb-3">
      <label for="kyt">Паспортные данные:</label>
      <input type="login" class="form-control" id="kyt" placeholder="56 12 544327" name="passd">
    </div>
    <div class="mb-3">
      <label for="clh">ИНН:</label>
      <input type="login" class="form-control" id="clh" placeholder="772331755151" name="inn">
    </div>
    <div class="mb-3">
      <label for="qwe">Логин:</label>
      <input type="login" class="form-control" id="qwe" placeholder="Придумайте логин" name="login">
    </div>
    <div class="mb-3">
      <label for="zdf">Пароль:</label>
      <input type="password" class="form-control" id="zdf" placeholder="Придумайте пароль" name="pass">
    </div>
    <div class="mb-3">
      <label for="ymm">Подтверждение пароля:</label>
      <input type="password" class="form-control" id="ymm" placeholder="Введите пароль повторно" name="pass2">
    </div>
    <div class="form-check mb-3">
      <label class="form-check-label">
      <p>У меня уже есть <a href="/authorization.php">аккаунт</a></p>
      </label>
    </div>
    
        <button name="btn_reg_user" class="btn btn-outline-secondary">Зарегистрироваться</button><br/>
    </form>
<!-- </form> -->
</div>

</body>
</html>
