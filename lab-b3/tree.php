<?php
    session_start();
?>
<?php
function makeLink( $name, $path ) {
    $link='viewer.php?filename='.UrlEncode($path).DIRECTORY_SEPARATOR.$name;
    echo '<a href="'.$link.'" target="_blank">Файл "'.$name.'"</a><br>';
}

function outdirInfo($name, $path) {
    echo '<div class="dir-block" style="margin-left: 25px">';
    echo '<span style="margin-left: -15px">Каталог "'.$name.'"</span><br>';
    $dir = opendir($path);
    $i=1;
        while (false !== ($file = readdir($dir))) { 
            if (filetype($path.'/'. $file)=='dir') {
                if (($file != ".") && ($file != "..")) {
                    if ($path!='./') {
                        $p = $path.'\\'.$file;
                    } else {
                        $p = './'.$file;
                    }   
                    // echo $i.'. ';
                    $i++;
                    outdirInfo($file, $p);
                }
            } else if (filetype($path.'/'. $file)=='file') {
                // echo $i.'. ';
                    $i++;
                makeLink($file, $path);
            } else {
                echo '!!!'.$file.'#'.is_file($file).is_dir($file).'|'.$path.'<br>';
                 echo "<br>файл: $file : тип: " . filetype($path.'/'. $file) . "\n";
            }
        }
    closedir($dir);
    echo '</div>';
} 

function deleteCatalog($dir) {
    if (($dir!='./')&&($dir!='./tree.php')&&($dir!='./index.php')&&($dir!='./viewer.php')&&($dir!='./users.csv')&&($dir!='./style.css')&&($dir!='./system.txt')&&($dir!='./bootstrap.min.css')&&($dir!='./img')&&($dir!='./img/favicon.ico')&&($dir!='./polytech_logo_main.png')) {
            if ((!is_dir($dir) || is_link($dir))&&(file_exists($dir))) return unlink($dir); 
        if (is_dir($dir)) {
            foreach (scandir($dir) as $file) { 
            if ($file == '.' || $file == '..') continue; 
                if (!deleteCatalog($dir . '/' . $file)) { 
                    chmod($dir . '/' . $file, 0777); 
                    if (!deleteCatalog($dir . '/' . $file)) return false; 
                }; 
            } 
        }
           if (file_exists($dir)) {
            return rmdir($dir); 
           } else {
               return false;
           }
        }  else {
            echo '<h3>Это системный файл или каталог! Его нельзя удалить!</h3>';
        } 
}

function makeName($filename) {
    if (!file_exists($_POST['dir-name'])) {
        umask(0);
        mkdir($_POST['dir-name'], 0777, true);
    }
    $ext = end(explode('.', $filename));
    $n=1;
    while (file_exists($_POST['dir-name'].'\\'.$n.'.'.$ext)) {
        $n++;
    }
    return ($_POST['dir-name'].'\\'.$n.'.'.$ext);
}

function updateFileList($filename) {
    $filenamearr = explode('/', $filename);
    if ($filenamearr[0]!='.' && $filenamearr[1]!='/') {
        $filename = './'.$filename;
        $filenamearr = explode('/', $filename);
    }
    $info = file('C:\Users\kraso\Desktop\OSPanel\domains\lab-b3\users.csv');
    $f=fopen('C:\Users\kraso\Desktop\OSPanel\domains\lab-b3\users.csv', 'wt');
    if ($f) {
        flock($f, LOCK_EX);
        foreach ($info as $k=>$user) {
            $data = str_getcsv($user, ';');
            if ($data[0]==$_SESSION['user'][0]) {
            echo '<br>';
            $filename = $filenamearr[0];
            for ($i=1; $i < count($filenamearr); $i++) { 
                $temparrstr = str_split($filenamearr[$i]);
                if ($temparrstr[0]!='\\') {
                    $filename .='\\'.$filenamearr[$i];
                } else {
                    $filename .=$filenamearr[$i];
                }
                
            }

            if ($filenamearr[1]=='') {
                $filename = substr($filename, -(strlen($filename)-3));
            } else if ($filenamearr[0]=='.') {
                $filename = substr($filename, -(strlen($filename)-2));
            }
            $user = trim($user);
            $user.=';'.getcwd().'\\'.$filename;
            }
            fputs($f, trim($user)."\n");
        }
        flock($f, LOCK_UN);
        fclose($f);
    }   
}



if (!isset($_SESSION['user'])) {
    echo 'Session'; 
    echo '<h1>Аутентифицируйтесь!</h1><br><a href="/">Войти</a>';
} else {
if (isset($_FILES['myfilename'])) {
    if ($_FILES['myfilename']['tmp_name'][0]!='') {
        foreach( $_FILES['myfilename']['tmp_name'] as $i=>$f ) {
        $filename = makeName(''.$_FILES['myfilename']['name'][$i]);
        move_uploaded_file($_FILES['myfilename']['tmp_name'][$i], $filename);
        echo '<br>';
        echo '<h1 class="ml-3 mb-3">Загрузка '.($_FILES['myfilename']['name'][$i]).' – файл загружен на сервер ('.$filename.')</h1>';
        }
    } else {
        if (deleteCatalog($_POST['dir-name'])) {
            echo '<h1 class="ml-3 mb-3">Удалено '.$_POST['dir-name'].'</h1>';
        }
    }
    updateFileList($filename); 
   
} else {
    echo '<h2 class="ml-3 mb-3">Добавьте файл!</h2>';
}
echo '<div id="dir_tree">';
outdirInfo('./', getcwd());
echo '</div>';
echo '<br>';
echo '<form method="post" style="padding-left: 400px;" class="container" enctype="multipart/form-data" action="/?redir=true">
        <h5>Загрузка или удаление файлов</h5>
        <label for="dir-name" style="margin-left: 10px;" class="col-4 offset-1">Каталог на сервере
        <input type="text" class="form-control form-control-lg col-12" name="dir-name" autocomplete="off" id="dir-name" required value="./">
        </label>
        <div style="margin-left: 5px;">
        <label for="myfilename" class="ml-1 col-8">Локальный файл<br>
        <input type="file" class="form-control-file form-control-md col-12" name="myfilename[]" multiple>
        </label>
        </div>
        <input type="submit" value="Загрузить файл">
    </form>';

}
echo '<link rel="stylesheet" href="./bootstrap.min.css">';
echo '<link rel="stylesheet" href="./style.css">';

echo '<style>
.dir-block {
        margin-left: 50px;
        margin-right: 50px; 
        background: #fff;
        padding: 8px;
        color: #000;
    }
    a {
        color: #00d0ff;
    }</style>';
    echo '
        <footer>
        <div class="date">'.
            date("d.m.Y H:i:s T", time()).'
        </div>
        </footer>
    ';
?>