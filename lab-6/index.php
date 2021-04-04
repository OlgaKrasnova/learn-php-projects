<?php
    $result = '';
    if( isset( $_POST['A'] ) ) // если из формы были переданы данные
    {
        if( $_POST['TASK'] == 'mean' ) // если вычисляется среднее арифметическое
        {
            $result = round( ($_POST['A']+$_POST['B']+$_POST['C'])/3, 2 );
        }
        else
        if( $_POST['TASK'] == 'perimetr' ) // если вычисляется периметр
        {
            if( ($_POST['A'] + $_POST['B'] > $_POST['C']) && ($_POST['A'] + $_POST['C'] > $_POST['B']) && ($_POST['B'] + $_POST['C'] > $_POST['A'])) {
                $result = $_POST['A']+$_POST['B']+$_POST['C'];
            }
            else 
                $result = 'Такой треугольник не существует';
        }
        else
        if( $_POST['TASK'] == 'volume' ) // если вычисляется объём
        {
            $result = $_POST['A']*$_POST['B']*$_POST['C'];
        }
        else
        if( $_POST['TASK'] == 'square' ) // если вычисляется площадь
        {
            if( ($_POST['A'] + $_POST['B'] > $_POST['C']) && ($_POST['A'] + $_POST['C'] > $_POST['B']) && ($_POST['B'] + $_POST['C'] > $_POST['A'])) {
                $p = ($_POST['A']+$_POST['B']+$_POST['C'])/2;
                $result = round(sqrt($p*($p-$_POST['A'])*($p-$_POST['B'])*($p-$_POST['C'])), 2);
            }
            else 
                $result = 'Такой треугольник не существует';
        }
        else
        if( $_POST['TASK'] == 'sum' ) // если вычисляется сумма
        {
            $result = $_POST['A']+$_POST['B']+$_POST['C'];
        }
        else
        if( $_POST['TASK'] == 'prod' ) // если вычисляется произведение
        {
            $result = $_POST['A']*$_POST['B']*$_POST['C'];
        }
    }

    $out_text = '';
    if( isset($_POST['FIO']) )
        $out_text='ФИО: '.$_POST['FIO'].'<br>'; // подготавливаем содержимое отчета
    
    if( isset($_POST['GROUP']) )
        $out_text.='Группа: '.$_POST['GROUP'].'<br>';

    if( isset($_POST['ABOUT']) ) 
        $out_text.= 'О себе: '.$_POST['ABOUT'].'<br>';

    $out_text.='Решаемая задача: ';

    if ( isset($_POST['TASK']) ) {
        if( $_POST['TASK'] == 'mean' ) 
            $out_text.='СРЕДНЕЕ АРИФМЕТИЧЕСКОЕ'.'<br>'; 
        else
        if( $_POST['TASK'] == 'perimetr' ) 
            $out_text.='ПЕРИМЕТР ТРЕУГОЛЬНИКА'.'<br>';
        else
        if( $_POST['TASK'] == 'volume' ) 
            $out_text.='ОБЪЕМ ТРЕУГОЛЬНИКА'.'<br>';
        else
        if( $_POST['TASK'] == 'square' ) 
            $out_text.='ПЛОЩАДЬ ТРЕУГОЛЬНИКА'.'<br>';
        else
        if( $_POST['TASK'] == 'sum' ) 
            $out_text.='СУММА ЧИСЕЛ'.'<br>';
        else
        if( $_POST['TASK'] == 'prod' ) 
            $out_text.='ПРОИЗВЕДЕНИЕ ЧИСЕЛ'.'<br>';
    }

    if( isset($_POST['A']) ) {
        $out_text.='Число A: '.$_POST['A'].'<br>';
    }

    if( isset($_POST['B']) ) {
        $out_text.='Число B: '.$_POST['B'].'<br>';
    }

    if( isset($_POST['C']) ) {
        $out_text.='Число C: '.$_POST['C'].'<br>';
    }

    if( isset($_POST['OTVET']) && $_POST['OTVET'] != NULL ) {
        $out_text.='Ваш ответ: '.$_POST['OTVET'].'<br>';
    }
    else 
        $out_text.='Задача самостоятельно решена не была <br>';

    $out_text.='Вычисленный программой результат: '.$result.'<br>';

    if( isset($_POST['OTVET']) ) {
        if ($result == $_POST['OTVET'] ) 
            $out_text.='<br>Результат: <b>ТЕСТ ПРОЙДЕН<br>'; 
        else
            $out_text.='<br>Результат: ТЕСТ НЕ ПРОЙДЕН!<br>';        
    }

    $repeat_test = '';
    if( isset($_POST['TYPE']) ) {
        if($_POST['TYPE'] == 'view_browser')
            $repeat_test = '<a href="?F='.$_POST['FIO'].'&G='.$_POST['GROUP'].
            '" class="repeat_test">Повторить тест</a>'.'<br>';   
    }
        
    if( array_key_exists('send_mail', $_POST) ) // если нужно отправить результаты
    {
        // отправляем результаты по почте простым письмом
        mail( $_POST['MAIL'], 'Result of a math test',
        str_replace('<br>', "\r\n", $out_text),
        "From: krasolga2019@mail.ru\n"."Content-Type: text/plain; charset=utf-8\n" );
        // выводим соответствующее сообщение в браузер
        $out_text.='Результаты теста были автоматически отправлены на e-mail: '.$_POST['MAIL'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <title>Краснова Ольга Викторовна 181-321. Лабораторная работа №6</title>
</head>
<body>
        <?php
        if( !($result == '') ){      // если форма была обработана
            if( isset($_POST['TYPE']) ) {
                if($_POST['TYPE'] == 'view_print') {
                    echo $out_text;
                }
                else {
                echo '
                    <header>
                        <img src="img/polytech_logo_main.png" alt="polytech_logo_main">
                    </header>
                    <h2>Тест математических знаний</h2>
                    <div class="wrapper">'.
                        $out_text.$repeat_test.
                    '</div>
                    <div id="block-for-footer">
                        <footer>'.
                                date('d M Y h:i:s').
                        '</footer>
                    </div>';                    
                }
            }
        }
        else                      // если форма не обработана (данные не переданы в РНР)
        {
        echo '
            <header>
                <img src="img/polytech_logo_main.png" alt="polytech_logo_main">
            </header>
            <h2>Тест математических знаний</h2>
            <div class="wrapper">';
        echo '<form name="form" method="POST">
            <div class="field">
                <label for="fio">ФИО:</label>';
                    if( isset($_GET['F']) ){;
                        echo '<input type="text" id="fio" name="FIO" pattern="^[А-Яа-яЁё\s]+$" placeholder="Введите ФИО" value="'.$_GET['F'].'" required/>';
                    }
                    else
                        echo '<input type="text" id="fio" name="FIO" pattern="^[А-Яа-яЁё\s]+$" placeholder="Введите ФИО" required/>';
        echo'</div>
            <div class="field">
                <label for="number">Номер группы:</label>';
                    if( isset($_GET['G']) ){
                        echo '<input type="text" id="number" name="GROUP" pattern="[1-9]{3}-[1-9]{3}" placeholder="181-321" value="'.$_GET['G'].'" required/>';
                    }
                    else 
                        echo '<input type="text" id="number" name="GROUP" pattern="[1-9]{3}-[1-9]{3}" placeholder="181-321" required/>';
        echo'</div>
            <div class="field">
                <label for="A">Значение A:</label>';
                    echo '<input type="number" id="A" name="A" min=0 max=100 value="'.rand(0, 100).'".required/>';
        echo'</div>
            <div class="field">
                <label for="B">Значение B:</label>';
                    echo '<input type="number" id="B" name="B" min=0 max=100 value="'.rand(0, 100).'".required/>';
        echo'</div>
            <div class="field">
                <label for="C">Значение C:</label>';
                    echo '<input type="number" id="C" name="C" min=0 max=100 value="'.rand(0, 100).'".required/>';
        echo '</div>
            <div class="field">
                <label for="answer">Ваш ответ:</label>
                <input type="number" id="answer" name="OTVET" placeholder="Введите ваш ответ"/>
            </div>
            <div class="field field-self">
                <label for="ab">Немного о себе:</label>
                <textarea cols=23 rows=2  id="ab" placeholder="Напишите информацию о себе" name="ABOUT"></textarea>
            </div>
            <div class="field field-q">
                <label for="q">Вычисляем:</label>
                <div class="radio">
                <select name="TASK" id="q">
                    <option value="square">площадь треугольника</option>
                    <option value="perimetr">периметр треугольника</option>
                    <option value="volume">объем параллелепипеда</option>
                    <option value="mean">среднее арифметическое</option>
                    <option value="sum">сумма чисел</option>
                    <option value="prod">произведение чисел</option>
                </select>
                </div>
            </div>
            <div class="field" id="hidden-em">
                <label for="em">Ваш е-майл:</label>
                <input type="email" id="em" name="MAIL"/>
            </div>
            <div class="field field-left">';
            /*echo '
                <input type="checkbox" name="send_mail" onClick="hid()" /> отправить результаты тест по е-майл
            
            ';*/?>
            <input type="checkbox" name="send_mail" onClick="obj=document.getElementById('hidden-em');
            if( this.checked )
                obj.style.display='block';
            else
                obj.style.display='none';"> отправить результаты тест по е-майл
            <?php
            echo '
            </div>
            <div class="field field-left">
                <input type="radio" name="TYPE" value="view_browser" checked="true"/> версия для просмотра в браузере
            </div>
            <div class="field field-left">
                <input type="radio" name="TYPE"value="view_print" /> версия для печати
            </div>
            <div class="field field-left">
            <input name="submit" type="submit" value="Отправить" />
            </div>        
        </form>';
        echo'</div>
            <div id="block-for-footer">
                <footer>'.
                        date('d M Y h:i:s').
                '</footer>
            </div>';
        }
        ?>
</body>
</html>