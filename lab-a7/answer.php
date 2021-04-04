<?php
    $title = 'Никита Дубинский 181-321, лабораторная работа.';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo "$title" ?></title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
</head>
<body>
    <header>
        <img src="img/logo.png" alt="Логотип">
        <div>
            <p>Лабораторные работы по программированию веб-приложений</p>
            <p>Дубинский Никита, 181-321</p>
        </div>
    </header>
    <main>
        <?php

if (!isset($_POST['element0']) || ($_POST['element0'] != '')) {
    $b = true;
    $c = true;
    $i = 0;
    $k = true;
    $l = true;
    while ($b && $c) {
        if (($_POST['element'.$i] == "")) $b = false;
        $array = explode(" ", $_POST['element'.$i]);
        $array1 = explode(".", $_POST['element'.$i]);
        $array2 = explode(",", $_POST['element'.$i]);
        
        if (count($array) > 1) {
            $k = false; 
            break;
        }
        if (count($array1) > 2) {
            $l = false; 
            break;
        }
        if (count($array2) > 1) {
            $l = false; 
            break;
        }
        if ((count($array1) > 1) && ord($array1[1]) < 5) {
            $k = false; 
            break;
        }
        $i++;
        if ($i == count($_POST)) break;
    }
    $v = $_POST['option'];
    $_POST['option'] = 'hello';
    $i = 0;
    $c = true;
    $j = 0;
    $bb = true;
    foreach ($_POST as $key => $value) {
        if ($value != 'hello') {
            $j++;
            if (((floatval($value) != 0) || ($value === '0') || ($value === '00') || ($value === '000') || ($value === '0000') || ($value === '00000')) && ($value != '') && $k && $l) {
                $arr[$i] = floatval($value);
                echo $arr[i];
                $i++;
            } else {
                $c = false;
                echo 'Введите корректные данные';
                break;
            }
        } 
    }

    if ($c && ($j > 1)) {
        echo 'Вы ввели: <br>';
	    display($arr);
    } 
    if (($j < 2) && $c) {
        echo '<br>Сортировать одно число не интересно';
        $bb = false;
    }

    if (!$b && $c && $bb) {
        switch ($v) {
            case 'v1': {$a = selectionSort($arr); echo 'Сортировка выбором <br>';break;}
            case 'v2': $a = selectionBubble($arr);echo 'Сортировка пузырьковым методом <br>';break;
            case 'v3': $a = selectionShell($arr);echo 'Сортировка методом Шелла <br>';break;
            case 'v4': $a = gnomeSort($arr);echo 'Сортировка методом гнома <br>';break;
            case 'v5': $start = microtime(true); $a = selectionShell($arr);$end = microtime(true);
    $time = $end-$start;
    echo '<br>'; echo 'Быстрая сортировка <br>';break;
            case 'v6': $a = sortArray($arr);echo '<br>Сортировка стандартными средствами PHP<br>';break;
        }
    }
    display($a);
} else echo 'Введите корректные данные';




function sortArray($array) {
    sort($array);
    return $array;
}




function selectionBubble($arr) {
$r = 0;
echo '<br><br><p style="color: red; font-weigh: 900">Выволнение алгоритма:</p>';
$start = microtime(true);
    for ($i = 0; $i < count($arr); $i++){
        for ($j = $i + 1; $j < count($arr); $j++) {
            if ($arr[$i] > $arr[$j]) {
                $r++;
                $temp = $arr[$j];
                $arr[$j] = $arr[$i];
                $arr[$i] = $temp;
                echo $r.'. Меняем '.$arr[$i].' и '.$arr[$j].';<br>';
            echo 'Наш массив: ';
            echo display($arr).'<br>';
            }
        }         
    }
    echo '<p style="color: red; font-weigh: 900">Выполнение алгоритма закончено</p>';
    $end = microtime(true);
    $time = $end-$start;
    echo '<br>';
    echo 'Было затрачено '.$time.' микросекунд<br>';
    echo 'Сортировка заняла '.$r.' итераций<br>';
    return $arr;
}




function selectionShell($arr) {
    $r = 0;
	// echo '<br><br><p style="color: red; font-weigh: 900">Выволнение алгоритма:</p>';
$start = microtime(true);
    $k=0;
    $gap[0] = (int)(count($arr) / 2);

    while($gap[$k] > 1) {
        $k++;
        $gap[$k]= (int)($gap[$k-1] / 2);
    }

    for($i = 0; $i <= $k; $i++){
        $step=$gap[$i];

        for($j = $step; $j < count($arr); $j++) {
            $temp = $arr[$j];
            $p = $j - $step;
            while($p >= 0 && $temp < $arr[$p]) {
                $arr[$p + $step] = $arr[$p];
                $p= $p - $step;
            }
            $arr[$p + $step] = $temp;
        }
    }
    // echo '<p style="color: red; font-weigh: 900">Выполнение алгоритма закончено</p>';
    $end = microtime(true);
    $time = $end-$start;
    echo '<br>';
    echo 'Было затрачено '.$time.' микросекунд<br>';
    if ($r > 0) echo 'Сортировка заняла '.$r.' итераций<br>';
    return $arr;
}




function gnomeSort($arr) {
    $r = 0;
	echo '<br><br><p style="color: red; font-weigh: 900">Выволнение алгоритма:</p>';
$start = microtime(true);
    $i = 1;
    while ($i < count($arr)) 
        if ($i == 0 || $arr[$i-1] <= $arr[$i]) $i++;
            else {
                $r++;
                $tmp = $arr[$i]; 
                $arr[$i] = $arr[$i-1]; 
                $arr[$i-1] = $tmp;
                echo $r.'. Меняем '.$arr[$i].' и '.$arr[$i-1].';<br>';
            	echo 'Наш массив: ';
            	echo display($arr).'<br>';
                $i--;
            }
            echo '<p style="color: red; font-weigh: 900">Выполнение алгоритма закончено</p>';
    $end = microtime(true);
    $time = $end-$start;
    echo '<br>';
    echo 'Было затрачено '.$time.' микросекунд<br>';
    echo 'Сортировка заняла '.$r.' итераций<br>';
    return $arr;
}




function quicksort($arr, $left, $right) {
 	$l=$left; 
	$r=$right; 
	$point = $arr[floor(($left+$right)/2)];
	do { 
		while( $arr[$l]<$point ) $l++; 
		while( $arr[$r]>$point ) $r++; 
		if( $l <= $r ) { 
			$temp=$arr[$l]; 
			$arr[$l]=$arr[$r]; 
			$arr[$r]=$temp; 
			$l++; 	
			$r--; 
		} 
	} 
	while( $l<=$r ); 
	if( $r > $left ) 
		quicksort($arr, $left, $r);
	if( $l > $right ) 
		quicksort($arr, $l, $right);
}





function selectionSort($arr) {
    $r = 0;
	echo '<br><br><p style="color: red; font-weigh: 900">Выволнение алгоритма:</p>';
	$start = microtime(true);
    for ($i = 0; $i < count($arr); $i++) {
        $min = $arr[$i];
        $min_i = $i;
        for ($j = $i+1; $j < count($arr); $j++) {
            if ($arr[$j] < $min) {
                $min = $arr[$j];
                $min_i = $j;
            }
        }
        if ($i != $min_i) {
            $r++;
            $tmp = $arr[$i];
            $arr[$i] = $arr[$min_i];
            $arr[$min_i] = $tmp;
            echo $r.'. Меняем '.$arr[$i].' и '.$arr[$min_i].';<br>';
            echo 'Наш массив: ';
            echo display($arr).'<br>';
        }
    }
    echo '<p style="color: red; font-weigh: 900">Выполнение алгоритма закончено</p>';
    $end = microtime(true);
    $time = $end-$start;
    echo '<br>';
    echo 'Было затрачено '.$time.' микросекунд<br>';
    echo 'Сортировка заняла '.$r.' итераций<br>';
    return $arr;
}




function display($array) {
    foreach ($array as $key => $value) {
        echo $value." ";
    }
}

?>
    </main>
    <footer>
        <p>Лабораторные работы</p>
        <p>2019 год</p>
    </footer>
</body>
</html>





