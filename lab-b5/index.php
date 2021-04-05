<?php
if (isset($_GET['redir'])) {
    header('Location: /');
}
$HREF_ARR[0]='';
$site_charset;
   function HandleHeaderLine($ch, $header_line ) {
        global $site_charset;
        $pos=stripos($header_line,'charset');
        if($pos===false)
            return strlen($header_line);
        $site_charset =substr($header_line,$pos+8,-2);
        return strlen($header_line);
    }      
function getHTMLcode ($url) {
    global $site_charset;
    try {
        if (!($ch = curl_init($url))) {
            throw new Exception();
        }
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, "HandleHeaderLine");
        curl_setopt($ch, CURLOPT_HEADER, 0); // заголовки не передаем
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвратить содержимое файла
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // разрешить перенаправление
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // задать тайм-аут 10 секунд
        $ret = curl_exec($ch); // выполнение запроса
        if(strtolower($site_charset)!=="utf-8") {
            $ret = iconv('cp1251',"UTF-8", $ret);          
        }
        curl_close($ch); // завершение сеанса
        return $ret; // возвращаем результат работы
    }
    catch(Exception $e) {
        return @file_get_contents($url); 
    }
}
function getALLtag( $text, $tag ) {
   
if ($tag=='description') {
    $pattern='#<meta name="'.$tag.'" content="([^<>]*?)"[ ]*[\/]*?>#i';
} else 
    if ($tag=='keywords') {
        $pattern='#<meta name="'.$tag.'" content="([^<>]*?)"[ ]*[\/]*?>#i';
    }
    else
     $pattern='#<'.$tag.'([\s]+[^>]*|)>(.*?)<\/'.$tag.'>#i';
preg_match_all( $pattern, $text, $ret, PREG_SET_ORDER );
//print_arr($ret);
foreach( $ret as $k=>$v ) {
    if ($tag == 'a') {
        $href="";
        preg_match('#(.*)href="(.*?)"#i', $v[1], $arr);
        if ($arr) {
            $href = $arr[2];
            $ret[$k] = array('href'=>$href, 'text'=>$v[2]);
        } 
    } else 
        if (($tag=='keywords')||($tag=='description')) {
            $ret[$k] = array('text'=>$v[1]); 
        } else
            $ret[$k] = array('text'=>$v[2]);
            
        
    
} 

return $ret; 
}
function getLINKType ($href, $url) {
    if( strpos($href, '://')===false ) return 3;
    $domen = parse_url($href, PHP_URL_HOST);
    if($domen == parse_url($url, PHP_URL_HOST) )
        return 2; 
    return 1; 
}

function getINFO($url, $depth) {
    global $MAX_DEEP;
    global $HREF_ARR;
    if ($depth>$MAX_DEEP) {
        return;
    }
    $code = getHTMLcode($url);
    echo '<div class="one"><h1 class="blue">'.$url.' <div class="small container_depth">(Глубина = '.$depth.')</div> </h1>';
    $titles = getALLtag($code, 'title');
    echo '<p class="h">Title: <span class="small">'.$titles[0]['text'].'</span></p>';

    $descriptions = getALLtag($code, 'description');
    echo '<p class="h">Description: <span class="small">'.htmlspecialchars_decode($descriptions[0]['text']).'</span></p>';

    $keywords = getALLtag($code, 'keywords');
    echo '<p class="h">Keywords: <span class="small">'.$keywords[0]['text'].'</span></p>';

    $h1 = getALLtag($code, 'h1');
    echo '<p class="h">H1:</p>';
    foreach ($h1 as $h1unit) {
        echo "<p class='text small'>".htmlspecialchars_decode(strip_tags($h1unit['text']))."</p>";
    }

    $h2 = getALLtag($code, 'h2');
    echo '<p class="h">H2:</p>';
    foreach ($h2 as $h2unit) {
        echo "<p class='text small'>".htmlspecialchars_decode(strip_tags($h2unit['text']))."</p>";
    }
    
    $a = getALLtag($code, 'a');
    echo '<p class="h">Ссылки:</p>';
    //$i=0;
    foreach ($a as $link) {
        //$i++;
        //echo $i.' '.$link['href'].'<br>';
        if (getLINKType($link['href'], $url)==3) {
            $arr = str_split($link['href']);
            if ($arr[0]!='#' && $arr[0]!='/' && $arr[0]!='?' && $arr[0]!='') {
                $was = false;
                foreach ($HREF_ARR as $value) {
                    if ($link['href']==$value) {
                        $was = true; 
                    }
                }
                if ($link['href']==$_POST['url']){
                    $was = true; 
                }
                if (($link['href']=='/')||($link['href']=='#')){
                    $was = true; 
                }
                if (!$was) {
                    $HREF_ARR[count($HREF_ARR)]=$link['href'];
                    echo  '<p class="text small">'.$url.''.$link['href'].' <span class="local">→ локальная ссылка</span></p>';
                    if ((!strpos('123'.$link['href'], 'tel:')) && (!strpos('123'.$link['href'], 'javascript:'))&&(!strpos('123456'.$link['href'], 'mailto:'))) {
                    getINFO($url.''.$link['href'], $depth+1);
                    echo '</div>';
                }
                
                }
            } else {
                $was = false;
                foreach ($HREF_ARR as $value) {
                    if ($link['href']==$value) {
                        $was = true; 
                    }
                } 
                if ($link['href']==$_POST['url']){
                    $was = true; 
                }
                if (($link['href']=='/')||($link['href']=='#')){
                    $was = true; 
                }
                if (!$was) {
                     $HREF_ARR[count($HREF_ARR)]=$link['href'];
                     echo  '<p class="text small">'.$url.''.$link['href'].' <span class="local">→ локальная ссылка</span></p>';
                     getINFO($url.''.$link['href'], $depth+1);
                     echo '</div>';
                  }
            }
            } else  
            if (getLINKType($link['href'], $url)==2) {
                $was3=false;
                foreach ($HREF_ARR as $value) {
                    if ($link['href']==$value) {
                        $was3 = true; 
                    }
                }
                if ($link['href']==$_POST['url']){
                    $was3 = true; 
                }
                if (($link['href']=='/')||($link['href']=='#')){
                    $was3 = true; 
                }
            if (!$was3) {
                $HREF_ARR[count($HREF_ARR)]=$link['href'];
                echo  '<p class="text small">'.$link['href'].' <span class="global">→ абсолютная ссылка на этот сайт</span></p>';
                getINFO($link['href'], $depth+1);
                echo '</div>';
                }
           } 
         else if (getLINKType($link['href'], $url)==1) {
            $was2=false;
            foreach ($HREF_ARR as $value) {
                if ($link['href']==$value) {
                    $was2 = true; 
                }
            }
            if ($link['href']==$_POST['url']){
                $was2 = true; 
            }
            if ($link['href']==$_POST['url'].''){
                $was2 = true; 
            }
            if (($link['href']=='/')||($link['href']=='#')){
                $was2 = true; 
            }
            if (!$was2) {
                $HREF_ARR[count($HREF_ARR)]=$link['href'];
                echo  '<p class="text small">'.$link['href'].' <span class="global">→ абсолютная ссылка на другой сайт</span></p>';
            }
             
        }
        
    }
    //echo '</div>';
}   
$MAX_DEEP = 5;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Краснова Ольга Викторовна 181-321. Лабораторная работа №В-5. Доступ к удаленным сайтам и серверам. Анализатор страниц сайта</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
</head>
<body>
    <header>
        <img src="img/polytech_logo_main.png" alt="polytech_logo_main">
    </header>
    <?php
    $regexp = '%^(?:(?:https?|ftp)://)*(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu';
    if ((isset($_POST['url']))&&(!preg_match($regexp, ($_POST['url'])))) {
        echo '<h2 class="warning">Введен некорректный URL!</h2>';
    }
    if (!isset($_POST['url']) || ((isset($_POST['url']))&&(!preg_match($regexp, ($_POST['url']))))) {
        echo '<div id="first">
        <h2 class="enter">Введите URL</h2>
            <form method="POST" action="index.php">
                <input type="text" name="url">
                    <input type="submit" autocomplete="off" value="Анализировать"></input>
                </form>
    </div>';
    } else if ((isset($_POST['url']))&&(preg_match($regexp, ($_POST['url'])))){
        echo '<a class="logout" href="/?redir=true"><div class="container_logout">Вернуться</div></a><div>';
        getINFO( $_POST['url'], 1 );
        echo '</div>';
    }
    ?>
    </main>
	<footer>
        <div class="date">
            <?php
                date_default_timezone_set("Europe/Moscow");
                echo date("d.m.Y H:i:s T", time());
            ?>  
        </div>
	</footer>
</body>
</html>