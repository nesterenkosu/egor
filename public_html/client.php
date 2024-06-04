<?php
require_once("$_SERVER[DOCUMENT_ROOT]/../db/databases.php");

error_reporting(~E_WARNING);

if(isset($_POST["btn_go"])) {
    //Защита от SQL-инъекций
    $F_name=mysqli_real_escape_string($connection,$_POST["F_name"]);
    $S_name=mysqli_real_escape_string($connection,$_POST["S_name"]);
    $Com=mysqli_real_escape_string($connection,$_POST["Com"]);
    $mail=mysqli_real_escape_string($connection,$_POST["mail"]);
    $Num=mysqli_real_escape_string($connection,$_POST["Num"]);
    $inn=mysqli_real_escape_string($connection,$_POST["inn"]);
    $adress=mysqli_real_escape_string($connection,$_POST["adress"]);


    if(isset($_POST["f_ID"])) {
        $id=(int)$_POST["f_ID"];
        mysqli_query($connection,"
            UPDATE `Clients`
            SET
                Name='$F_name',
                Full_name='$S_name',
                Company='$Com',
                Mail='$mail',
                Number='$Num',
                Inn='$inn',
                Company_adress='$adress'
            WHERE
                ID=$id
        "); 
    }        
    else
        mysqli_query($connection,"
            INSERT INTO `Clients`(Name,Full_name,Company,Mail,Number,Inn,Company_adress) 
            VALUES('$F_name','$S_name','$Com','$mail','$Num','$inn','$adress')
        ");

    //Сброс значений формы после успешной её обработки
    header("Location: $_SERVER[PHP_SELF]");

}

$form_fields=$_POST;

if(isset($_GET["edit_id"])) {
    $id=(int)$_GET["edit_id"];

    $res=mysqli_query($connection,"SELECT * FROM `Сlients` WHERE ID=$id");

    $client=mysqli_fetch_array($res,MYSQLI_BOTH);

    $form_fields["f_ID"]=$client["ID"];
    $form_fields["F_name"] = $client["Name"];
    $form_fields["S_name"] = $client["Full_name"];
    $form_fields["Com"] = $client["Company"];
    $form_fields["mail"] = $client["Mail"];
    $form_fields["Num"] = $client["Number"];
    $form_fields["inn"] = $client["Inn"];
    $form_fields["adress"] = $client["Company_adress"];
}

if(isset($_GET["confirm_delete_id"])) {
    $id=(int)$_GET["confirm_delete_id"];

    $res=mysqli_query($connection,"DELETE FROM `Сlients` WHERE ID=$id");

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
    <title>Клиенты</title>
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
                    <h4>Клиенты</h4>
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
                        <label for="qua" class="form-label">Компания:</label>
                        <input name="Com" type="text" class="form-control" id="qua" placeholder="Компания" name="cg" value="<?=$form_fields["Com"]?>">
                    </div>
                    <div class="mb-3">
                        <label for="wei" class="form-label">Почта:</label>
                        <input name="mail" type="text" class="form-control" id="wei" placeholder="Почта" name="eweg" value="<?=$form_fields["mail"]?>">
                    </div>
                    <div class="mb-3">
                        <label for="pr" class="form-label">Номер:</label>
                        <input name="Num" type="text" class="form-control" id="pr" placeholder="Номер" name="htce" value="<?=$form_fields["Num"]?>">
                    </div>
                    <div class="mb-3">
                        <label for="prup" class="form-label">ИНН:</label>
                        <input name="inn" type="text" class="form-control" id="prup" placeholder="ИНН" name="xfe" value="<?=$form_fields["inn"]?>">
                    </div>
                    <div class="mb-3">
                        <label for="pr" class="form-label">Адрес компании:</label>
                        <input name="adress" type="text" class="form-control" id="pr" placeholder="Адрес компании" name="htce" value="<?=$form_fields["adress"]?>">
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

        <?php  $result = mysqli_query($connection,"SELECT * FROM `Clients`"); ?>

        <table class="table table-bordered table-hover" style="width: 100%">
            <tr>
                <th>ID</th>      
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Компания</th>
                <th>Почта</th>
                <th>Номер</th>
                <th>ИНН</th>
                <th>Адрес компании</th>
                <th></th>
            </tr>
            <?while ($client = mysqli_fetch_array($result,MYSQLI_BOTH)):?>
            <tr>
                <td><?=$client["ID"]?></td>
                <td><?=$client["Name"]?></td>
                <td><?=$client["Full_name"]?></td>
                <td><?=$client["Company"]?></td>
                <td><?=$client["Mail"]?></td>
                <td><?=$client["Number"]?></td>
                <td><?=$client["Inn"]?></td>
                <td><?=$client["Company_adress"]?></td>
                <td>
                    <a href="?edit_id=<?=$client["ID"]?>" class="btn btn-light">Редактировать</a>&nbsp;
                    <a href="?delete_id=<?=$client["ID"]?>" class="btn btn-lightr">Удалить</a>
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