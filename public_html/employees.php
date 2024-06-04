<?php
require_once("$_SERVER[DOCUMENT_ROOT]/../db/databases.php");

error_reporting(~E_WARNING);

if(isset($_POST["btn_go"])) {
    //Защита от SQL-инъекций
    $F_name=mysqli_real_escape_string($connection,$_POST["F_name"]);
    $S_name=mysqli_real_escape_string($connection,$_POST["S_name"]);
    $Num=mysqli_real_escape_string($connection,$_POST["Num"]);
    $mail=mysqli_real_escape_string($connection,$_POST["mail"]);
    $Pass=mysqli_real_escape_string($connection,$_POST["Pass"]);
    $inn=mysqli_real_escape_string($connection,$_POST["inn"]);
    $log=mysqli_real_escape_string($connection,$_POST["log"]);
    $pass2=mysqli_real_escape_string($connection,$_POST["pass2"]);


    if(isset($_POST["f_ID"])) {
        $id=(int)$_POST["f_ID"];
        mysqli_query($connection,"
            UPDATE users
            SET
                Name='$F_name',
                Full_name='$S_name',
                Number='$Num',
                Mail='$mail',
                Passport_data='$Pass',
                Inn='$inn',
                Login='$log',
                Password='$pass2'
            WHERE
                ID=$id
        "); 
    }        
    else
        mysqli_query($connection,"
            INSERT INTO users(Name,Full_name,Number,Mail,Passport_data,Inn,Login,Password) 
            VALUES('$F_name','$S_name','$Num','$mail','$Pass','$inn','$log','$pass2')
        ");

    //Сброс значений формы после успешной её обработки
    header("Location: $_SERVER[PHP_SELF]");

}

$form_fields=$_POST;

if(isset($_GET["edit_id"])) {
    $id=(int)$_GET["edit_id"];

    $res=mysqli_query($connection,"SELECT * FROM users WHERE ID=$id");

    $emp=mysqli_fetch_array($res,MYSQLI_BOTH);

    $form_fields["f_ID"]=$emp["ID"];
    $form_fields["F_name"] = $emp["Name"];
    $form_fields["S_name"] = $emp["Full_name"];
    $form_fields["Num"] = $emp["Number"];
    $form_fields["mail"] = $emp["Mail"];
    $form_fields["Pass"] = $emp["Passport_data"];
    $form_fields["inn"] = $emp["Inn"];
    $form_fields["log"] = $emp["Login"];
    $form_fields["pass2"] = $emp["Password"];
}

if(isset($_GET["confirm_delete_id"])) {
    $id=(int)$_GET["confirm_delete_id"];

    $res=mysqli_query($connection,"DELETE FROM users WHERE ID=$id");

     //Сброс значений формы после успешной её обработки
     header("Location: $_SERVER[PHP_SELF]");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="icons/skif.png" />
    <title>Сотрудники</title>
    <style>
        body {
            background-image: url('/img/fon.jpg');
            background-size: cover;
            }
    </style>
    <!-- Подключаем ваш CSS файл -->
    <link rel="stylesheet" href="/css/style.css"/>
    <link rel="stylesheet" href="/css/bootstrap.min.css"/>
    
</head>
<body>
    <header>
        <!-- лого/верхнее меню -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-1">
                    <img src="icons/skif.png" width="40px" height="40px">
                </div>
                <div class="col-9">
                    <h4>Главная страница</h4>
                </div>
                <div class="col-2">
                    <form action="/profile.php">
                        <button class="btn btn-outline-light text-light">Профиль</button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <main>
    <aside>
            <!-- боковое меню -->
            <form action="/main.php">
            <button class="btn">Главная страница</button><br/><br/>
            </form>
            <form action="/goods.php">
            <button class="btn">Товары</button><br/><br/>
            </form>
            <form action="/client.php">
            <button class="btn">Клиенты</button><br/><br/>
            </form>
            <form action="/employees.php">
            <button class="btn">Сотрудники</button><br/><br/>
            </form>
            <form action="/tasks.php">
            <button class="btn">Задачи</button><br/><br/>
            </form>
            <button class="btn">Анализ работы</button><br/><br/>
            <button class="btn">Накладные</button><br/><br/>
            <form action="/chat.php">
            <button class="btn">Мессенджер</button><br/><br/>
            </form>
            <form action="/authorization.php">
            <button class="btn">Авторизация(временно)</button><br/><br/>
            </form>
            <form action="/registration.php">
            <button class="btn">Регистрация(временно)</button><br/><br/>
            </form>
            <form action="/map.php">
            <button class="btn">Карта</button><br/><br/>
            </form>
        </aside>
        <section>



        <!-- Button to Open the Modal -->
        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#myModal">
        Добавить
        </button><br/><br/>

        <!-- The Modal -->
        <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form action="" method="POST">
                    <div class="mb-3 mt-3">
                        <label for="na" class="form-label">Имя:</label>
                        <input name="F_name" type="text" class="form-control" id="na" placeholder="Имя" name="fe" value="<?=$form_fields["F_name"]?>">
                    </div>
                    <div class="mb-3">
                        <label for="pwd" class="form-label">Фамилия:</label>
                        <input name="S_name" type="text" class="form-control" id="pwd" placeholder="Фамилия" name="erw" value="<?=$form_fields["S_name"]?>">
                    </div>
                    <div class="mb-3">
                        <label for="qua" class="form-label">Номер:</label>
                        <input name="Num" type="text" class="form-control" id="qua" placeholder="Номер" name="cg" value="<?=$form_fields["Num"]?>">
                    </div>
                    <div class="mb-3">
                        <label for="wei" class="form-label">Почта:</label>
                        <input name="mail" type="text" class="form-control" id="wei" placeholder="Почта" name="eweg" value="<?=$form_fields["mail"]?>">
                    </div>
                    <div class="mb-3">
                        <label for="pr" class="form-label">Пасспортные данные:</label>
                        <input name="Pass" type="text" class="form-control" id="pr" placeholder="Пасспортные данные" name="htce" value="<?=$form_fields["Pass"]?>">
                    </div>
                    <div class="mb-3">
                        <label for="prup" class="form-label">ИНН:</label>
                        <input name="inn" type="text" class="form-control" id="prup" placeholder="ИНН" name="xfe" value="<?=$form_fields["inn"]?>">
                    </div>
                    <div class="mb-3">
                        <label for="lo" class="form-label">Логин:</label>
                        <input name="log" type="text" class="form-control" id="lo" placeholder="Логин" name="yu" value="<?=$form_fields["log"]?>">
                    </div>
                    <div class="mb-3">
                        <label for="pa" class="form-label">Пароль:</label>
                        <input name="pass2" type="text" class="form-control" id="pa" placeholder="Пароль" name="iu" value="<?=$form_fields["pass2"]?>">
                    </div>
                    <?if(isset($form_fields["f_ID"])):?>
                        <input name="f_ID" type="hidden" value="<?=$form_fields["f_ID"]?>"/>
                    <?endif;?>

                    <button name="btn_go" type="submit" class="btn btn-light">Сохранить</button>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Отмена</button>
            </div>

            </div>
        </div>
        </div>

        <!-- The Modal -->
<div class="modal" id="myModalDelete">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        Действительно удалить?
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Нет</button>
        <a href="?confirm_delete_id=<?=$_GET["delete_id"]?>" class="btn btn-light">Да</a>
      </div>

    </div>
  </div>
</div>

        <?php  $result = mysqli_query($connection,"SELECT * FROM users"); ?>

        <table class="table table-bordered table-hover" style="width: 100%">
            <tr>
                <th>ID</th>      
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Номер</th>
                <th>Почта</th>
                <th>Пасспортные данные</th>
                <th>ИНН</th>
                <th>Логин</th>
                <th>Пароль</th>
                <th></th>
            </tr>
            <?while ($user = mysqli_fetch_array($result,MYSQLI_BOTH)):?>
            <tr>
                <td><?=$user["ID"]?></td>
                <td><?=$user["Name"]?></td>
                <td><?=$user["Full_name"]?></td>
                <td><?=$user["Number"]?></td>
                <td><?=$user["Mail"]?></td>
                <td><?=$user["Passport_data"]?></td>
                <td><?=$user["Inn"]?></td>
                <td><?=$user["Login"]?></td>
                <td><?=$user["Password"]?></td>
                <td>
                    <a href="?edit_id=<?=$user["ID"]?>" class="btn btn-light">Редактировать</a>&nbsp;
                    <a href="?delete_id=<?=$user["ID"]?>" class="btn btn-lightr">Удалить</a>
                </td>
            </tr>
            <?endwhile?>
        </table>
        </section>
    </main>
    <footer class="fixed-bottom">
        <!-- подвал -->
        <p>Copyright ©. All Rights Reserved.</p>
    </footer>
    <script src="/js/scripts.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>
    <?if(isset($_GET["edit_id"])):?>
        <script>
        //открытие диалогового окна формы
        let myModal = new bootstrap.Modal(document.getElementById('myModal'), {});
        myModal.show();    
        </script>
    <?endif;?>
    <?if(isset($_GET["delete_id"])):?>
        <script>
        //открытие диалогового окна формы
        let myModal = new bootstrap.Modal(document.getElementById('myModalDelete'), {});
        myModal.show();    
        </script>
    <?endif;?>
</body>
</html>