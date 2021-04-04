<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Краснова Ольга Викторовна 181-321. Лабораторная работа №4</title>
</head>
<body>
    <header>
      <img src="img/polytech_logo_main.png" alt="polytech_logo_main">
    </header>
    <main>
    
    <?php
        $k = 5;                                                            // число колонок таблиц
        if(($k <= 0) || (is_numeric($k) == false)){
            die('Неправильное число колонок');
        }
        function getTR($data)                                           // объявление функции
        {
            global $k;
            $arr = explode('*', $data);                              // разбиваем строку в массив
            $ret = '<tr>';                                          // начинаем тег строки таблицы
            for($i=0; $i < $k; $i++) {                             // цикл по всем ячейкам таблицы
                if(empty($arr[$i]))
                    $ret .= '<td>&nbsp</td>';                       // пустые ячейки
                else
                    $ret .= '<td>'.$arr[$i].'</td>';              // добавляем ячейкам тег
            }
            return $ret.'</tr>';                                 // возвращаем строку таблицы
        }

        function outTable($structure)                                       // объявление функции
        {
            $strings = explode('#', $structure);                          // разбиваем структуру на строки
            $datas='';                                                   // итоговый HTML-код строк
            for($i = 0; $i < count($strings); $i++)                     // цикл для всех строк
                $datas .= getTR($strings[$i]);                         // добавляем код строки в итоговый
            if( $datas )                                              // если код строк определен
                echo '<table>'.$datas.'</table>';                    // выводим таблицу
            else                                                    // иначе
                echo 'В таблице нет строк ';                       // выводим предупреждение
        }

        $structure = array( '', ' #*', 'C1*C2*C3#C4*C5*C6', '#', 'C13*C14*C15#C16*C17*C18' );                               // массив со структурами таблиц
        for($i = 0; $i < count($structure); $i++) {                                                             // для всех элементов массива
            echo '<h2>Таблица №'.($i+1).'</h2>';                                                               // вывод номера таблицы
            if(strpos($structure[$i], '*') === false){
                echo 'В таблице нет строк с ячейками';
                continue;
            }
            outTable($structure[$i]);                                                                       // выводим соответствующую структуре таблицу
        }                                 
    ?>

    </main>
    <div id="block-for-footer">
        <footer>
            Это подвал
        </footer>
      </div>
</body>
</html>