<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <title>Краснова Ольга Викторовна 181-321. Лабораторная работа №5</title>
</head>
<body>
    <header>
      <img src="img/polytech_logo_main.png" alt="polytech_logo_main">
    </header>
    <main>
    
    <div id="main_menu">
    <?php
        echo '<a href="?html_type=TABLE';                 // начало ссылки ТАБЛИЧНАЯ ФОРМА
        if( isset($_GET['content']) )                    // если параметр content был передан в скрипт
            echo '&content='.$_GET['content'];          // добавляем в ссылку второй параметр
        echo '"';                                      // завершаем формирование адреса ссылки и закрываем кавычку
        // если в скрипт был передан параметр html_type и параметр равен TABLE
        if( array_key_exists('html_type', $_GET) && $_GET['html_type']== 'TABLE' )
            echo ' class="selectedMenu"';           // ссылка выделяется через CSS-класс
        echo '>Табличная форма</a>';               // конец ссылки ТАБЛИЧНАЯ ФОРМА

        echo '<a href="?html_type=DIV';                 // начало ссылки БЛОЧНАЯ ФОРМА
        if( isset($_GET['content']) )                  // если параметр content был передан в скрипт
            echo '&content='.$_GET['content'];        // добавляем в ссылку второй параметр
        echo '"';                                    // завершаем формирование адреса ссылки и закрываем кавычку
        // если в скрипт был передан параметр html_type и параметр равен TABLE
        if( array_key_exists('html_type', $_GET) && $_GET['html_type']== 'DIV' )
            echo ' class="selectedMenu"';         // ссылка выделяется через CSS-класс
        echo '>Блочная форма</a>';               // конец ссылки БЛОЧНАЯ ФОРМА
    ?>
    </div>


    <div id="product_menu">
        <?php
            echo '<a href="/"';                                                                     // начало ссылки ВСЯ ТАБЛИЦА УМНОЖНЕНИЯ
            if( !isset($_GET['content']) )                                                         // если в скрипт НЕ был передан параметр content
                echo ' class="selectedMenu"';                                                     // ссылка выделяется через CSS-класс
            echo ">Вся таблица умножения</a>\n";                                                 // конец ссылки
            

            for( $i=2; $i<=9; $i++ )                                                           // цикл со счетчиком от 2 до 9 включительно
            {
                if(isset($_GET['html_type']))
                    echo '<a href="?html_type='.$_GET['html_type'].'&content='.$i.'"';
                else
                    echo '<a href="?content='.$i.'"';

                // если в скрипт был передан параметр content
                // и параметр равен значению счетчика
                if( isset($_GET['content']) && $_GET['content']==$i )
                    echo ' class="selectedMenu"';                         // ссылка выделяется через CSS-класс
                echo '>Таблица умножения на '.$i.'</a>';                 // конец ссылки
            }
        ?>
    </div>


    <div id="main">
            <?php

            function outNumAsLink( $x ) {
            if( $x <= 9 ) {
                if(isset($_GET['html_type']))
                    echo '<a href="?html_type='.$_GET['html_type'].'&content='.$x. '">'.$x.'</a>';
                else  
                    echo '<a href="?content='.$x. '">'.$x.'</a>';              
            }
            else
                echo $x;
            }
            
            // функция ВЫВОДИТ СТОЛБЕЦ ТАБЛИЦЫ УМНОЖЕНИЯ
            function outRow ( $n ) {
                for($i=2; $i<=9; $i++) {
                    echo outNumAsLink($n);
                    echo ' x ';
                    echo outNumAsLink($i);
                    echo ' = ';
                    echo outNumAsLink($i*$n);
                    echo "<br> \n";
                }
            }

            function outDivForm (){
                // если параметр content не был передан в программу
                if( !isset($_GET['content']) ) {
                    // цикл со счетчиком от 2 до 9
                    for($i=2; $i < 10; $i++) { 
                        echo '<div class="ttRow">';       // оформляем таблицу в блочной форме
                        outRow( $i );                    // вызывем функцию, формирующую содержание
                        // столбца умножения на $i (на 4, если $i==4)
                        echo '</div>';
                    }
                }

                else {
                    echo '<div class="ttSingleRow">';    // оформляем таблицу в блочной форме
                    outRow( $_GET['content'] );         // выводим выбранный в меню столбец
                    echo '</div>';
                }
            }

            function outTableForm (){
                // если параметр content не был передан в программу
                if( !isset($_GET['content']) ) {
                    // цикл со счетчиком от 2 до 9
                    echo '<table>';
                    echo '<tr>';
                    for($i=2; $i < 6; $i++) { 
                        echo '<td>'; 
                        outRow( $i ); 
                        echo '</td>';
                    }
                    echo '</tr>';
                    for($i=6; $i < 10; $i++) { 
                        echo '<td>'; 
                        outRow( $i ); 
                        echo '</td>';
                    }
                    echo '</table>';
                }

                else {
                    echo '<div class="ttSingleRow">';    // оформляем таблицу в блочной форме
                    outRow( $_GET['content'] );         // выводим выбранный в меню столбец
                    echo '</div>';
                }
            }

            if (!isset($_GET['html_type']) || $_GET['html_type'] == 'TABLE' )
                outTableForm(); // выводим таблицу умножения в табличной форме
            else
                outDivForm(); // выводим таблицу умножения в блочной форме  
            ?>
 
    </div>    
    </main>
    <div id="block-for-footer">
        <footer>
            <?php
            if( !isset($_GET['html_type']) || $_GET['html_type'] == 'TABLE' )
                $s='Табличная верстка. ';                                           
            else
                $s='Блочная верстка. ';

            if( !isset($_GET['content']) )
                $s.='Таблица умножения полностью. ';
            else
                $s.='Столбец таблицы умножения на '.$_GET['content']. '. ';
            
                echo $s.date('d M Y h:i:s');
            ?>
        </footer>
      </div>
</body>
</html>