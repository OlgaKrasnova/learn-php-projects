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
                flock( $f, LOCK_EX );
                while (!feof($f)) {
                    $test_user=explode(';', fgets($f));
                    // print_r($test_user);
                    if (trim($test_user[0])==$_POST['login']) {
                        if ((trim($test_user[1])==$_POST['password'])&&(isset($test_user[1]))) {
                            $_SESSION['user']=$test_user;
                        }
                        header('Location: /');
                        exit();
                    }
                }
                $wrong = true;
                flock( $f, LOCK_UN );
                fclose($f);
            } else {
                // echo 'Ошибка открытия файла';
            }
        }
        
?>
<?php
if( !isset($_SESSION['user']) ) { echo '<h1>Необходима авторизация</h1><br><a href="/">Войти</a>';
    exit(); }
if (isset($_GET['filename'])) {
    if (file_exists($_GET['filename'])) {
        if ('C:\Users\kraso\Desktop\OSPanel\domains\lab-b3\users.csv'==$_GET['filename']) {
            echo '<h1>Нельзя просматривать "users.csv"!</h1>';
        } else {

  $infotable = file('C:\Users\kraso\Desktop\OSPanel\domains\lab-b3\users.csv');
 $ftable=fopen('C:\Users\kraso\Desktop\OSPanel\domains\lab-b3\users.csv', 'rt');
    if ($ftable) {
        flock($ftable, LOCK_EX);
        foreach ($infotable as $k=>$user) {
            $data = str_getcsv($user, ';');
            foreach ($data as $key => $value) {
                if (($value==$_GET['filename']) && ($data[0]==$_SESSION['user'][0])) {
                    $f = fopen( $_GET['filename'], 'rt' ); 
                        echo '<h2 style="margin: 10px;">Этот файл приналежит вам</h2>';
                } else if (($value==$_GET['filename']) && ($data[0]!=$_SESSION['user'][0])) {
                    $notyours = true;
                }
            }
        }
        if (!isset($f) && !$notyours) {
                echo '<h3 style="margin-top: 10px;">Нет данных о владельце файла</h3>';
                $f = fopen( $_GET['filename'], 'rt' ); 
            }
            if ($notyours) {
                echo '<h2 style="margin: 10px;">Этот файл загружен другим пользователем, у вас нет доступа к его просмотру</h2>';
                echo '<a href="/" class="ml-3" style="float:right; margin-right:40px; font-size: 25px;">Вернуться</a>';
            }
        flock($ftable, LOCK_UN);
        fclose($ftable);
    }       
        }
    } else {
        echo '<h2>Файл не существует</h2>';
    }
        

    
} else {
    echo '<h2>Файл не указан</h1><br><a href="/">Вернуться</a><br>';
}

if( $f ) // если файл успешно открыт
{
    flock( $f, LOCK_EX );
    $filen = str_replace(getcwd(), '.' , $_GET['filename']);
    // echo '<p class="ml-2">'.$_GET['filename'].'</p>';
    // echo '<p class="ml-2">'.getcwd().'</p>'; 

    echo '<p class="ml-3">Путь до файла: '.$filen.'</p>'; 
    echo '<a href="/" class="ml-3" style="float:right; margin-right:40px; font-size: 25px;">Вернуться</a>';

$content = ''; // содержимое файла пока пусто
while( !feof($f) ) // цикл, пока не достигнут конец файла
$content .= htmlspecialchars(fgets( $f )); // читаем строку файла
echo '<br><span style="margin-left: 16px;">Содержимое:</span><br><div style="white-space: pre-wrap; margin-top: 20px; margin-left: 40px; margin-right: 40px; padding: 20px; margin-bottom: 10px; border: 1px solid rgb(41, 41, 41);">'.$content.'</div>'; // выводим содержимое файла
flock( $f, LOCK_UN );
fclose( $f ); // закрываем файл
}
else {
    echo '<p class="ml-3">Ошибка открытия файла '. $_GET['filename'].'</p>';
}

echo '<link rel="stylesheet" href="./bootstrap.min.css">';
echo '<link rel="stylesheet" href="./style.css">';

echo '<style>
body h1 {
    margin-left: 20px;
    margin-top: 20px;
}</style>';
?>