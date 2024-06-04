<?php
require_once("$_SERVER[DOCUMENT_ROOT]/../db/databases.php");

session_start();

if(isset($_GET["Company_id"])) {
    $Company_id=(int)$_GET["Company_id"];

    $_SESSION["Company_id"] = $Company_id;

    header("Location: $_SERVER[PHP_SELF]");
}

if(isset($_GET["User_id"])) {
    $User_id=(int)$_GET["User_id"];

    $_SESSION["User_id"] = $User_id;

    header("Location: $_SERVER[PHP_SELF]");
}

if(isset($_GET["Status_id"])) {
    $Status_id=(int)$_GET["Status_id"];

    $_SESSION["Status_id"] = $Status_id;

    header("Location: $_SERVER[PHP_SELF]");
}

error_reporting(~E_WARNING);

if(isset($_POST["btn_go"])) {
    //Защита от SQL-инъекций
    $Com=(int)$_POST["Com"];
    $log=(int)$_POST["log"];
    $desc=mysqli_real_escape_string($connection,$_POST["desc"]);
    $stat=(int)$_POST["stat"];

    if(isset($_POST["f_ID"])) {
        $id=(int)$_POST["f_ID"];
        mysqli_query($connection,"
            UPDATE Task
            SET
                ClientID='$Com',
                UserID='$log',
                Description='$desc',
                Status='$stat'
            WHERE
                ID=$id
        "); 
    }        
    else {
        mysqli_query($connection,"
            INSERT INTO Task(ClientID,UserID,Description,Status) 
            VALUES('$Com','$log','$desc','$stat')
        ");
    }

    //Сброс значений формы после успешной её обработки
    header("Location: $_SERVER[PHP_SELF]");

}

$form_fields=$_POST;
$form_fields["Com"]=$_SESSION["Company_id"];
$form_fields=$_POST;
$form_fields["log"]=$_SESSION["User_id"];
$form_fields=$_POST;
$form_fields["stat"]=$_SESSION["Status_id"];


if(isset($_GET["edit_id"])) {
    $id=(int)$_GET["edit_id"];

    $res=mysqli_query($connection,"SELECT * FROM Task WHERE ID=$id");

    $tk=mysqli_fetch_array($res,MYSQLI_BOTH);

    $form_fields["f_ID"]=$tk["ID"];
    $form_fields["Com"] = $tk["Company"];
    $form_fields["log"] = $tk["User_login"];
    $form_fields["Desc"] = $tk["Description"];
    $form_fields["stat"] = $tk["Status"];
}

if(isset($_GET["confirm_delete_id"])) {
    $id=(int)$_GET["confirm_delete_id"];

    $res=mysqli_query($connection,"DELETE FROM Task WHERE ID=$id");

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
    <title>Задачи</title>
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
                    <h4>Задачи</h4>
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
        <?$res=mysqli_query($connection,"SELECT * FROM `Clients`");
        $use=mysqli_query($connection,"SELECT * FROM `users`");
        $sta=mysqli_query($connection,"SELECT * FROM `Status`");?>
        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#myModal">
        Добавить задачу
        </button><br/><br/>

        <!-- The Modal -->
        <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="location.href='<?=$_SERVER["PHP_SELF"]?>'"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form action="" method="POST">
                    <div class="mb-3 mt-3">
                        <label for="company" class="form-label">Выбор клиента:</label>
                        <?$res=mysqli_query($connection,"SELECT * FROM Clients");?>
                        <select name="Com" class="form-select form-select-lg">
                            <?while($company=mysqli_fetch_array($res,MYSQLI_BOTH)):?>
                                <? $selected = ($form_fields["Com"] == $company["ID"])?"selected":"";?>
                                <option value="<?=$company["ID"]?>" <?=$selected?>><?=$company["Company"]?></option>
                            <?endwhile;?>
                        </select>
                    </div>
                    
                    <div class="mb-3 mt-3">
                        <label for="login" class="form-label">Выбор сотрудника:</label>
                        <?$use=mysqli_query($connection,"SELECT * FROM users");?>
                        <select name="log" class="form-select form-select-lg">
                            <?while($login=mysqli_fetch_array($use,MYSQLI_BOTH)):?>
                                <? $selected = ($form_fields["log"] == $login["ID"])?"selected":"";?>
                                <option value="<?=$login["ID"]?>" <?=$selected?>><?=$login["Login"]?></option>
                            <?endwhile;?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="pwd" class="form-label">Описание:</label>
                        <textarea name="desc" class="form-control" id="pwd" placeholder="Добавьте описание к задаче" name="pswd"><?=$form_fields["desc"]?></textarea>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="status" class="form-label">Статус:</label>
                        <?$sta=mysqli_query($connection,"SELECT * FROM Status");?>                        
                        <select name="stat" class="form-select form-select-lg">
                            <?while($status=mysqli_fetch_array($sta,MYSQLI_BOTH)):?>
                                <? $selected = ($form_fields["stat"] == $status["ID"])?"selected":"";?>
                                <option value="<?=$status["ID"]?>" <?=$selected?>><?=$status["Name"]?></option>
                            <?endwhile;?>
                        </select>
                    </div>
                    <?if(isset($form_fields["f_ID"])):?>
                        <input name="f_ID" type="hidden" value="<?=$form_fields["f_ID"]?>"/>
                    <?endif;?>

                    <button name="btn_go" type="submit" class="btn btn-light">Сохранить</button>
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" onclick="location.href='<?=$_SERVER["PHP_SELF"]?>'">Отмена</button>
            </div>

            </div>
        </div>
        </div>

        <?php  
            $filter = "";
            if(isset($_SESSION["Company_id"]) && $_SESSION["Company_id"] > 0) {
                $Company_id = (int)$_SESSION["Company_id"];
                $filter = "WHERE Company = $Company_id";
            }

            $result = mysqli_query($connection,"SELECT * FROM `Task` $filter"); 
        ?>

        <?php  
            $filter = "";
            if(isset($_SESSION["User_id"]) && $_SESSION["User_id"] > 0) {
                $User_id = (int)$_SESSION["User_id"];
                $filter = "WHERE User_login = $User_id";
            }

            $result = mysqli_query($connection,"SELECT * FROM `Task` $filter"); 
        ?>

        <?php  
            $filter = "";
            if(isset($_SESSION["Status_id"]) && $_SESSION["Status_id"] > 0) {
                $Status_id = (int)$_SESSION["Status_id"];
                $filter = "WHERE Status = $Status_id";
            }

           
            $result = mysqli_query($connection,"
                SELECT 
                    Task.ID As ID,
                    Clients.Company As Company,
                    users.Login As Login,
                    Task.Description As Description,
                    Status.Name As Status
                FROM 
                    Task,users,Clients,Status
                WHERE
                    Task.UserID = users.ID AND
                    Task.ClientID = Clients.ID AND
                    Task.Status = Status.ID
            "); 

            
        ?>

        <table class="table table-bordered table-hover" style="width: 100%">
            <tr>
                <th>ID</th>      
                <th>Организация</th>
                <th>Сотрудник</th>
                <th>Описание</th>
                <th>Статус</th>
            </tr>
            <?while ($tk = mysqli_fetch_array($result,MYSQLI_BOTH)):?>
            <tr>
                <td><?=$tk["ID"]?></td>
                <td><?=$tk["Company"]?></td>
                <td><?=$tk["Login"]?></td>
                <td><?=$tk["Description"]?></td>
                <td><?=$tk["Status"]?></td>
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
</body>
</html>