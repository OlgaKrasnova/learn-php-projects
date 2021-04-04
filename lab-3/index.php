<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Краснова Ольга Викторовна 181-321. Лабораторная работа №3</title>
</head>
<body>
    <header>
      <img src="img/polytech_logo_main.png" alt="polytech_logo_main">
    </header>
    <main>
        <?php                                     
            if( !isset($_GET['store']) )                                   // если НЕ передано предыдущее значение
                $_GET['store'] = '';                                      // создаем пустое хранилище
            else                                                         // иначе
            if( isset($_GET['key']) )                                   // если кнопка была нажата
                $_GET['store'].= $_GET['key'];                         // сохранить цифру в хранилище                                                       
            echo '<div class="result">'.$_GET['store'].'</div>';      // выводим содержимое хранилища

            if( !isset($_GET['tab']) )                                  
                $_GET['tab'] = '0';                                      
            else                                                         
            if( isset($_GET['tab']) )                                  
                $_GET['tab']++;  
        ?>
        <a href="/?key=1&tab=<?php echo $_GET['tab']; ?>&store=<?php echo $_GET['store']; ?>" class="numbers">1</a>
        <a href="/?key=2&tab=<?php echo $_GET['tab']; ?>&store=<?php echo $_GET['store']; ?>" class="numbers">2</a>
        <a href="/?key=3&tab=<?php echo $_GET['tab']; ?>&store=<?php echo $_GET['store']; ?>" class="numbers">3</a>
        <a href="/?key=4&tab=<?php echo $_GET['tab']; ?>&store=<?php echo $_GET['store']; ?>" class="numbers">4</a>
        <a href="/?key=5&tab=<?php echo $_GET['tab']; ?>&store=<?php echo $_GET['store']; ?>" class="numbers">5</a>
        <a href="/?key=6&tab=<?php echo $_GET['tab']; ?>&store=<?php echo $_GET['store']; ?>" class="numbers">6</a>
        <a href="/?key=7&tab=<?php echo $_GET['tab']; ?>&store=<?php echo $_GET['store']; ?>" class="numbers">7</a>
        <a href="/?key=8&tab=<?php echo $_GET['tab']; ?>&store=<?php echo $_GET['store']; ?>" class="numbers">8</a>
        <a href="/?key=9&tab=<?php echo $_GET['tab']; ?>&store=<?php echo $_GET['store']; ?>" class="numbers">9</a>
        <a href="/?key=0&tab=<?php echo $_GET['tab']; ?>&store=<?php echo $_GET['store']; ?>" class="numbers">0</a>
        <a href="/?key=reset&tab=<?php echo $_GET['tab']; ?>" class="reset">СБРОС</a>        
    </main>
    <div id="block-for-footer">
        <footer>
        <?php                                                                             
            echo "Вы нажали ".$_GET['tab']." клавиш";             
        ?>
            <!--session_start(); 
            if (!isset($_SESSION['counter'])) $_SESSION['counter']=0;
            echo "Вы нажали ".$_SESSION['counter']++." клавиш ";
            session_unset();
            session_destroy();-->
        </footer>
      </div>
</body>
</html>