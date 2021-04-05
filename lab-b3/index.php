<?php
session_start();
if (isset($_GET['logout'])) {
            unset($_SESSION['user']);
            header('Location: /');
            exit();
        }
        if (isset($_POST['login'])) {
            setcookie('login', $_POST['login']);
        }
        if (isset($_POST['password'])) {
             setcookie('password', $_POST['password']);
        }
        // setcookie('password', $_POST['password']);
        if (!(isset($_SESSION['user']))&&(!isset($_SESSION['login']))&&(isset($_POST['password']))) {    
            $f=fopen('users.csv', 'rt');
            if ($f) {
                // echo 'Фаил открыт';
                flock($f, LOCK_EX);
                while (!feof($f)) {
                    $test_user=explode(';', fgets($f));
                    // print_r($test_user);
                    if (trim($test_user[0])==$_POST['login']) {
                        if ((trim($test_user[1])==$_POST['password'])&&(isset($test_user[1]))) {
                            $_SESSION['user']=$test_user;
                            $_SESSION['try'] = false;
                        } else {
                            $_SESSION['try'] = true;
                        }  
                            header('Location: /');
                            exit();
                    }
                }
                $_SESSION['try'] = true;
                flock( $f, LOCK_UN );
                fclose($f);
            } else {
                // echo 'Ошибка открытия файла';
            }
        }
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Краснова Ольга Викторовна 181-321. Лабораторная работа №В-3. Работа с локальными файлами сервера. Облачное хранилище файлов</title>
    <link rel="stylesheet" href="./bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <style>
    .dir-block {
        margin-left: 50px;
        margin-right: 50px; 
        background: rgba(123,90,1,.8);
        padding: 8px;
        color: #fff;
    }
    a {
        color: #00d0ff;
    }
    </style>
</head>

<body>

    <?php
        if (!isset($_SESSION['user']) && $_SESSION['try']) {
            echo '<div class="alert alert-danger col-6" style="position: absolute; top: 20px; left: 20px;" role="alert"><strong>Неверный логин или пароль!</strong></div>';
        }

        if (!(isset($_SESSION['user']))) {
            echo '
                <div class="container pt-5 mt-5"><div class="row pt-5"><form name="auth" method="POST" class="col-4 offset-4" action="">
                <h1>Вход</h1>
                <input type="text" class="form-control form-control-lg mt-4" name="login" value="'.$_COOKIE['login'].'" required>
                <input type="password" class="form-control form-control-lg mt-2" name="password" value="'.$_COOKIE['password'].'" required>
                <input type="submit" class="auth" value="Войти"> 
            </form></div></div>';
        } else {
            echo '
            <header>
                <img src="polytech_logo_main.png" alt="polytech_logo_main">
                <p><h5 class="mt-0 mr-4" style="float: left; margin-left: 625px;"><span class="current_user">Текущий пользователь:</span> '.$_SESSION['user'][0].'</h5></p>
                <a class="button" style="float: left" href="?logout">Выход</a>
            </header>
            <h2 class="my-0 mr-md-auto font-weight-bold" style="text-align: center">Дерево файлов</h2>
            ';
            include('tree.php');
        }
    ?>
</body>

</html>