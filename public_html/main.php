<?php
require_once("$_SERVER[DOCUMENT_ROOT]/../db/databases.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="icons/skif.png" />
    <title>Главная</title>
    <style>
        body {
            background-image: url('/img/fon.jpg');
            background-size: cover;
            }
        .p2 {
            color: #FFC0CB;
            font-size: 12px;
            }
        #mydiv {
            position: absolute;
        }
        #mydivheader {
            cursor: move;
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
            <container>
            <h4>Заметки</h4>
            <div id="mydiv">
                <div class="toast show">
                <div id="mydivheader">
                    <div class="toast-header">
                        <strong class="me-auto">Заказ 14.07</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                    </div>
                </div>
                    <div class="toast-body">
                        Назначить завтра сотрудника на компанию "Малина"
                    </div>
                </div>
            </div>
            
        </container>
        </section>
    </main>
    <footer class="fixed-bottom">
        <!-- подвал -->
        <p>Copyright ©. All Rights Reserved.</p>
    </footer>
    <script src="/js/DragEl.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>