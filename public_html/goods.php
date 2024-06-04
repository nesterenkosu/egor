<?php
require_once("$_SERVER[DOCUMENT_ROOT]/../db/databases.php");

session_start();

if(isset($_GET["category_id"])) {
    $category_id=(int)$_GET["category_id"];

    $_SESSION["category_id"] = $category_id;

    header("Location: $_SERVER[PHP_SELF]");
}

error_reporting(~E_WARNING);

if(isset($_POST["btn_go"])) {
    //Защита от SQL-инъекций
    $good_name=mysqli_real_escape_string($connection,$_POST["good_name"]);
    $good_quantity=(int)$_POST["good_quantity"];
    $good_quantity2=(int)$_POST["good_quantity2"];
    $weight=(int)$_POST["weight"];
    $price=(int)$_POST["price"];
    $price2=(int)$_POST["price2"];
    $good_category = (int)$_POST["good_category"];

    if(isset($_POST["f_ID"])) {
        $id=(int)$_POST["f_ID"];
        mysqli_query($connection,"
            UPDATE Goods
            SET
                Name='$good_name',
                Num_of_boxes='$good_quantity',
                Num_of_packages='$good_quantity2',
                Box_weight='$weight',
                Price_of_box='$price',
                Price_of_package='$price2',
                CategoryID=$good_category
            WHERE
                ID=$id
        "); 
    }        
    else
        mysqli_query($connection,"
            INSERT INTO Goods(Name,Num_of_boxes,Num_of_packages,Box_weight,Price_of_box,Price_of_package,CategoryID) 
            VALUES('$good_name','$good_quantity','$good_quantity2','$weight','$price','$price2','$good_category')
        ");

    //Сброс значений формы после успешной её обработки
    header("Location: $_SERVER[PHP_SELF]");

}

$form_fields=$_POST;
$form_fields["good_category"]=$_SESSION["category_id"];

if(isset($_GET["edit_id"])) {
    $id=(int)$_GET["edit_id"];

    $res=mysqli_query($connection,"SELECT * FROM Goods WHERE ID=$id");

    $good=mysqli_fetch_array($res,MYSQLI_BOTH);

    $form_fields["f_ID"]=$good["ID"];
    $form_fields["good_name"] = $good["Name"];
    $form_fields["good_quantity"] = $good["Num_of_boxes"];
    $form_fields["good_quantity2"] = $good["Num_of_packages"];
    $form_fields["weight"] = $good["Box_weight"];
    $form_fields["price"] = $good["Price_of_box"];
    $form_fields["price2"] = $good["Price_of_package"];

    $form_fields["good_category"] = $good["CategoryID"];
}

if(isset($_GET["confirm_delete_id"])) {
    $id=(int)$_GET["confirm_delete_id"];

    $res=mysqli_query($connection,"DELETE FROM Goods WHERE ID=$id");

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
    <title>Товары</title>
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

        <?$res=mysqli_query($connection,"SELECT * FROM Categories");?>
        <div class="btn-group">
            <?while($category=mysqli_fetch_array($res,MYSQLI_BOTH)):?>
                <?$active=($_SESSION["category_id"]==$category["ID"])?"style=\"font-weight: bold;\"":""?>
                <a href="?category_id=<?=$category["ID"]?>" <?=$active?> class="btn btn-light" ><?=$category["Name"]?></a>
            <?endwhile?>
            <a href="?category_id=-1" class="btn btn-light" >Показать всё</a>
            <!--button type="button" class="btn btn-light">Драже</button>
            <button type="button" class="btn btn-light">Карамель</button>
            <button type="button" class="btn btn-light">Зефир</button>
            <button type="button" class="btn btn-light">Мармелад</button-->
        </div><br/><br/>

        <!-- Button to Open the Modal -->
        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#myModal">
        Добавить товар
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
                        <label for="email" class="form-label">Название:</label>
                        <input name="good_name" type="text" class="form-control" id="email" placeholder="Название" name="email" value="<?=$form_fields["good_name"]?>">
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="сategory" class="form-label">Категория товара:</label>
                        <?$res=mysqli_query($connection,"SELECT * FROM Categories");?>
                        <select name="good_category" class="form-select form-select-lg">
                            <?while($category=mysqli_fetch_array($res,MYSQLI_BOTH)):?>
                                <? $selected = ($form_fields["good_category"] == $category["ID"])?"selected":"";?>
                                <option value="<?=$category["ID"]?>" <?=$selected?>><?=$category["Name"]?></option>
                            <?endwhile;?>
                            <!--option>2</option>
                            <option>3</option>
                            <option>4</option-->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="pwd" class="form-label">Количество коробок:</label>
                        <input name="good_quantity" type="text" class="form-control" id="pwd" placeholder="Количество коробок" name="pswd" value="<?=$form_fields["good_quantity"]?>">
                    </div>
                    <div class="mb-3">
                        <label for="qua" class="form-label">Количество упаковок:</label>
                        <input name="good_quantity2" type="text" class="form-control" id="qua" placeholder="Количество упаковок" name="quan" value="<?=$form_fields["good_quantity2"]?>">
                    </div>
                    <div class="mb-3">
                        <label for="wei" class="form-label">Вес коробки:</label>
                        <input name="weight" type="text" class="form-control" id="wei" placeholder="Вес коробки" name="weig" value="<?=$form_fields["weight"]?>">
                    </div>
                    <div class="mb-3">
                        <label for="pr" class="form-label">Цена коробки:</label>
                        <input name="price" type="text" class="form-control" id="pr" placeholder="Цена коробки" name="pri" value="<?=$form_fields["price"]?>">
                    </div>
                    <div class="mb-3">
                        <label for="prup" class="form-label">Цена упаковки:</label>
                        <input name="price2" type="text" class="form-control" id="prup" placeholder="Количество упаковок" name="pru" value="<?=$form_fields["price2"]?>">
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

        <!-- The Modal -->
        <div class="modal" id="myModalDelete">
        <div class="modal-dialog">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Удаление строки</h4>
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

        <?php  
            $filter = "";
            if(isset($_SESSION["category_id"]) && $_SESSION["category_id"] > 0) {
                $category_id = (int)$_SESSION["category_id"];
                $filter = "WHERE CategoryID = $category_id";
            }

            $result = mysqli_query($connection,"SELECT * FROM Goods $filter"); 
        ?>
        <table class="table table-bordered table-hover" style="width:100%">
            <tr>
                <th>ID</th>      
                <th>Название</th>
                <th>Количество коробок</th>
                <th>Количество упаковок</th>
                <th>Вес коробки</th>
                <th>Цена коробки</th>
                <th>Цена упаковки</th>
                <th></th>
            </tr>
            <?while ($tov = mysqli_fetch_array($result,MYSQLI_BOTH)):?>
            <tr>
                <td><?=$tov["ID"]?></td>
                <td><?=$tov["Name"]?></td>
                <td><?=$tov["Num_of_boxes"]?></td>
                <td><?=$tov["Num_of_packages"]?></td>
                <td><?=$tov["Box_weight"]?></td>
                <td><?=$tov["Price_of_box"]?></td>
                <td><?=$tov["Price_of_package"]?></td>
                <td>
                    <a href="?edit_id=<?=$tov["ID"]?>" class="btn btn-light">Редактировать</a>&nbsp;
                    <a href="?delete_id=<?=$tov["ID"]?>" class="btn btn-lightr">Удалить</a>
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