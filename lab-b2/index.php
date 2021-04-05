<?php
    session_start(); 
    if( !isset($_SESSION['history']) ) {
        $_SESSION['history']=array();
        $SESSION['iteration']=0;
    }
    $SESSION['iteration']++;
?> 

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
    <title>Краснова Ольга Викторовна 181-321. Лабораторная работа №B-2. Преобразование типов. Сессии. Калькулятор.</title>
	<link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="fonts/stylesheet.css">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
</head>
<body>
    <header>
        <img src="img/polytech_logo_main.png" alt="polytech_logo_main">
    </header>
	<main>
        <form method="POST" action="index.php">
            <h1 class="row">Введите выражение</h1>
            <input name="exp" placeholder="Введите выражение">
            <input type="hidden" name="iteration" value="<?php echo $SESSION['iteration']; ?>">
            <button>Вычислить</button>
        </form>




<?php

error_reporting(0);

echo '<p class="p">';
$str = $_POST['exp'];
$new_str = $str;

$a1 = explode("(-", $str);
if (count($a1) > 1) {
    $str = $a1[0];
    for ($i = 1; $i < count($a1); $i++) {
        $str = $str."(0-".$a1[$i];
    }
}


// echo $str."<br>";
// echo rpn($str)."<br>";

if (trim($str) == "") {
    $ans = "Ничего не введено";
} else {
    if (!isCorrect($str) || !noSpase($str) || !noSmth($str) || noNum($str)) {
        $ans = $new_str." = Неправильное выражение";
    } else {
        if (preg_match('/[A-Za-zА-Яа-я].*/', $str)) {
            $ans = $new_str." = Неправильное выражение";
        } else {
            if (rpn($str) == " = Неправильное выражение") {
                $ans = $new_str." = Неправильное выражение";
            } else {
                $expr = rpn($str);
                if (calc($expr) == -INF || calc($expr) == INF) {
                    $ans = $new_str." = деление на ноль";
                } else {
                    if (calc($expr) != null || calc($expr) == 0) {
                        $ans = $new_str." = ".calc($expr);
                    } else {
                        $ans = "Ничего не введено";
                    }
                }
            }
        }
    }
}


echo $ans;
echo '</p>';

echo '<br>';
echo '<br>';
echo "<h3>История вычислений:</h3>";
for($i = count($_SESSION['history']); $i >= 0; $i--) 
    echo $_SESSION['history'][$i].'<br>';
if($_POST['exp'] ) $_SESSION['history'][] = $ans;


function isCorrect($string){
    $brackets = array(
        array('{', '}'),
        array('(', ')')
    );
    foreach( $brackets as $bracket ){
        if( substr_count($string, $bracket[0]) != substr_count($string, $bracket[1]) )
            return false;
    }
    return true;
}

function noSmth($string){
    if (preg_match("/[\!\@\#\%\&\:\;\\\`\~\№\^\&\=\"\=\;]/",$string)) {
        return false;
    }
    return true;
}

function noNum($string){
    if (preg_match("/[0-9]|[0-9]/",$string)) {
        return false;
    }
    return true;
}

function noSpase($string) {
    if (!preg_match("/[\+\-\*\/\^]/",$string)) {
        $string = trim($string);
        $a1 = explode(" ", $string);
        if (count($a1) > 1) {
            return false;
        }
    } 
    return true;
}

function rpn($str)
{
    $stack=array(); //объявляем массив стека
    $out=array(); //объявляем массив выходной строки
    
    $prior = array ( //задаем приоритет операторов, а также их ассоциативность
            "^"=> array("prior" => "4", "assoc" => "right"),
            "*"=> array("prior" => "3", "assoc" => "left"),
            "/"=> array("prior" => "3", "assoc" => "left"),
            "+"=> array("prior" => "2", "assoc" => "left"),
            "-"=> array("prior" => "2", "assoc" => "left"),
    );
    
    $token=$str; //удалим все пробелы
    $token=str_replace(",", ".", $token);//поменяем запятые на точки
    $token = str_split($token);
    /*проверим, не является ли первый символ знаком операции - тогда допишем 0 перед ним */
    
    if (preg_match("/[\+\-\*\/\^]/",$token['0'])){array_unshift($token, "0");}
    
    $lastnum = TRUE; //в выражении теперь точно первым будет идти число - поставим маркер
    foreach ($token as $key=>$value)
    {
        if (preg_match("/[\+\-\*\/\^]/",$value))//если встретили оператор
            {
                $endop = FALSE; //маркер конца цикла разбора операторов
                
                while ($endop != TRUE)
                {
                    $lastop = array_pop($stack);
                    if ($lastop=="")
                    {
                        $stack[]=$value; //если в стеке нет операторов - просто записываем текущий оператор в стек
                        $endop = TRUE; //укажем, что цикл разбора while закончился
                    }
                    
                    else //если в стеке есть операторы - то последний сейчас в переменной $lastop
                    {
                        /* получим приоритет и ассоциативность текущего оператора и сравним его с $lastop */
                        $curr_prior = $prior[$value]['prior']; //приоритет текущиего оператора
                        $curr_assoc = $prior[$value]['assoc']; //ассоциативность текущиего оператора
                        
                        $prev_prior = $prior[$lastop]['prior']; //приоритет предыдущего оператора
                        
                        switch ($curr_assoc) //проверяем текущую ассоциативность
                        {
                            case "left": //оператор - лево-ассоциативный
                                
                                switch ($curr_prior) //проверяем текущий приоритет лево-ассоциаивного оператора
                                {
                                    case ($curr_prior > $prev_prior): //если приоритет текущего опертора больше предыдущего, то записываем в стек предыдущий, потом текйщий
                                        $stack[]=$lastop;
                                        $stack[]=$value;
                                        $endop = TRUE; //укажем, что цикл разбора операторов while закончился
                                        break;
                                    
                                    case ($curr_prior <= $prev_prior): //если тек. приоритет меньше или равен пред. - выталкиваем пред. в строку out[]
                                        $out[] = $lastop;
                                        break;
                                }
                                
                            break;
                            
                            case "right": //оператор - право-ассоциативный
                                
                                switch ($curr_prior) //проверяем текущий приоритет право-ассоциативного оператора
                                {
                                    case ($curr_prior >= $prev_prior): //если приоритет текущего опертора больше или равен предыдущего, то записываем в стек предыдущий, потом текйщий
                                        $stack[]=$lastop;
                                        $stack[]=$value;
                                        $endop = TRUE; //укажем, что цикл разбора операторов while закончился
                                        break;
                                    
                                    case ($curr_prior < $prev_prior): //если тек. приоритет меньше пред. - выталкиваем пред. в строку out[]
                                        $out[] = $lastop;
                                        break;
                                }       
                                
                            break;
                        
                        }
                    
                    }
                } //while ($endop != TRUE)
                $lastnum = false; //укажем, что последний разобранный символ - не цифра
            }
        
        elseif (preg_match("/[0-9\.]/",$value)) //встретили цифру или точку
            {
        /*Мы встретили цифру или точку (дробное число). Надо понять, какой символ был разобран перед ней. 
        За это отвечает переменная $lastnum - если она TRUE, то последней была цифра.
        В этом случае надо дописать текущую цифру к последнему элменту массива выходной строки*/
                if ($lastnum == TRUE) //последний разобранный символ - цифра
                    {
                        $num = array_pop($out); //извлечем содержимое последнего элемента массива строки
                        $out[]=$num.$value;
                    }
                
                else 
                    {
                        $out[] = $value; //если последним был знак операции - то открываем новый элемент массива строки
                        $lastnum = TRUE; //и указываем, что последним была цифра
                    }
            }
         
        elseif ($value=="(") //встреили скобку ОТкрывающую
            {
        /*Мы встретили ОТкрывающую скобку - надо просто поместить ее в стек*/
                        $stack[] = $value; 
                        $lastnum = FALSE; // указываем, что последним была НЕ цифра
            }
            
        elseif ($value==")") //встреили скобку ЗАкрывающую
            {
        /*Мы встретили ЗАкрывающую скобку - теперь выталкиваем с вершины стека в строку все операторы, пока не встретим ОТкрывающую скобку*/
                        $skobka = FALSE; //маркер нахождения открывающей скобки
                        while ($skobka != TRUE) //пока не найдем в стеке ОТкрывающую скобку
                        {
                            $op = array_pop($stack); //берем оператора с вершины стека
                            
                                if ($op == "(") 
                                {
                                    $skobka = TRUE; //если встретили открывающую - меняем маркер
                                } 
                                
                                else
                                {
                                    $out[] = $op; //если это не скобка - отправляем символ в строку
                                }
                            
                                
                        }
                        
                        $lastnum = FALSE; //указываем, что последним была НЕ цифра
            }   
    
    }
    /*foreach закончился - мы разобрали все выражение
    теперь вытолкнем все оставшиеся элементы стека в выходную строку, начиная с вершины стека*/

    $stack1 = $stack; //временный массив, копия стека, на случай, если будет нужен сам стек для дебага
    $rpn = $out; //начинаем формировать итоговую строку
    
    while ($stack_el = array_pop($stack1))
    {
        $rpn[]=$stack_el;
    }

    for ($i = 0; $i < count($rpn); $i++) {
        $arr1 = explode(".", $rpn[$i]);
        if ($arr1[0] == "" && $arr1[1] != "" && count($arr1)>1 || $arr1[0] != "" && $arr1[1] == "" && count($arr1)>1) {
            return "Неправильное выражение";
        }
    } 
    $rpn_str = implode(" ", $rpn); //запишем итоговый массив в строку
    return $rpn_str; //функция возвращает строку, в которой исходное выражение представлено в ОПЗ
}
    ?>

<?php

function calc($str)
{
	$stack = array();
    $token = strtok($str, ' ');
    $err = false;

	while ($token !== false)
	{
		if (in_array($token, array('*', '/', '+', '-', '^')))
		{
            if (count($stack) < 2)
                return "Неправильное выражение";
			$b = array_pop($stack);
            $a = array_pop($stack);
			switch ($token)
			{
				case '*': $res = $a*$b; break;
                case '/': if ($b == 0) {$a = 1; $res = $a/$b; break;} else {$res = $a/$b; break;}
				case '+': $res = $a+$b; break;
				case '-': $res = $a-$b; break;
				case '^': $res = pow($a,$b); break;
			}
            array_push($stack, $res);
		} elseif (is_numeric($token))
		{
			array_push($stack, $token);
		} else
		{
            return "Неправильное выражение";
        }
		$token = strtok(' ');
    }
    if (count($stack) > 1)
        return "Неправильное выражение";
	return array_pop($stack);
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