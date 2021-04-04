<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Краснова Ольга Викторовна. Группа 181-321. Вариант 16</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <header>
      <a href="#"><img src="img/polytech_logo_main.png" alt="polytech_logo_main"></a>
    </header>
      <main>
      <?php
        $x = 20;                                            // начальное значение аргумента
        $step = 4;                                         // шаг изменения аргумента
        $encounting = 95;                                 // количество вычисляемых значений
        $type = 'D';                                     // тип верстки
        $min_f = PHP_FLOAT_MAX; 
        $max_f = PHP_FLOAT_MIN;
        $sum = 0;
        $k = 0;
        $n = 0;                      // номер строки в таблице
        $f = 0;                     // значение функции
        /*$min_value = 10;
        $max_value = 20;*/

        switch ( $type ) {
          case 'B':
            echo "<ul> \n";
          break;

          case 'C':
            echo "<ol> \n";
          break;

          case 'D':
            echo "<table> \n";
        }

        for( $i = 0; $i < $encounting; $i++, $x += $step )
        {
          if((is_numeric($step) && is_numeric($x) && is_numeric($encounting)) == false)
            break;
          
            if($encounting == 0){
              echo 'Нет данных';
              break;
            }

          $k += 1;
          $n +=1;

          if( $x <= 10 )                                                  // если аргумент меньше или равен 10
            $f = round($x * $x * 0.33 + 4, 3);                           // вычисляем функцию
          else                                                          // иначе
          if( $x < 20 )                                                // если аргумент меньше 20
            $f = round(18 * $x - 3, 3);                               // вычисляем функцию
          else                                                       // иначе
          {                                    
            if( $x == 20 )                                         // если аргумент равен 20
              $f = 'error';                                       // не вычисляем функцию
            else                                                 // иначе
              $f = round(( 1 / ($x * 0.1 - 2) ) + 3, 3);        // вычисляем функцию
          }

          switch ( $type ) {
            case 'A':
              echo 'f('.$x.') = '.$f;
              if( $i < $encounting-1 )
                echo '<br>';
            break;

            case 'B':
              echo "<li>f(".$x.") = ".$f."</li> \n";
            break;

            case 'C':
              echo "<li>f(".$x.") = ".$f."</li> \n";
            break;

            case 'D':
              echo '
              <tr>
                <td>'.$n.'.</td>
                <td>f('.$x.')</td>
                <td>'.$f.'</td>
              </tr>';
            break;

            case 'E':
              echo "<div>f(".$x.") = ".$f."</div>";
            break;
          }
          
            if( $f > $max_f && $f != 'error' )
              $max_f = $f;

            if( $f < $min_f && $f != 'error' )
              $min_f = $f;
            
            if( $f != 'error')
              $sum += $f;
            
            if( $f == 'error')
              $k = $k-1;

            if( $f != 'error')
              $aver_value = round($sum / $k, 3);

            /*if( $f >= $max_value || $f < $min_value )            // если вышли за рамки диапазона
              break;*/
      }   

      switch ( $type ) {
        case 'B':
          echo "</ul> \n";
        break;
        
        case 'C':
          echo "</ol> \n";
        break;

        case 'D':
          echo "</table> \n";
      }  

      if(is_numeric($step) && is_numeric($x) && is_numeric($encounting)){
        if ($encounting != 1 && $f != 'error' && $encounting != 0) {
          echo "<p>Максимальное значение: $max_f</p> \n";
          echo "<p>Минимальное значение: $min_f</p> \n";
          echo "<p>Среднее арифметическое всех значений функции: $aver_value</p> \n";
          echo "<p>Сумма: $sum</p> \n";
        }
      }
      else 
        echo 'Неверный формат данных';
      
      if($f == 'error')
        echo 'Максимальное значение не существует <br> Минимальное значение не существует <br> Среднее арифметическое значение не существует <br> Сумма не существует';
      ?>
      </main>

      <div id="block-for-footer">
        <footer>
          <?php echo '<p>Тип верстки - '.$type.'</p>'?>
        </footer>
      </div>
  </body>
</html>
