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
	<?php $DESIGN=$_GET['design'];
			$NAME = $_GET['name']?>
	<header>
		<img src="img/logo.png" alt="Логотип">
		<div>
			<p>Лабораторные работы по программированию веб-приложений</p>
			<p>Дубинский Никита, 181-321</p>
			<ul>
			<a href="?design=table&name=<?php echo $NAME;?>"><li <?php if (($DESIGN == 'table') && (array_key_exists(design, $_GET))) {echo 'class="active-point"';}?>>Табличная вёрстка</li></a>
		<a href="?design=div&name=<?php echo $NAME;?>"><li <?php if (($DESIGN == 'div') && (array_key_exists(design, $_GET))) {echo 'class="active-point"';}?>>Блочная вёрстка</li></a>
	</ul>
		</div>
	</header>
<main>
	<?php if (isset($_GET['name'])) {$NAME=$_GET['name'];} else {$NAME='all';} ?>
		<div class="sidebar">
			<ul>
				<a href="?design=<?php echo "$DESIGN";?>&name=all"<?php if (($NAME=='all') || !(array_key_exists(name, $_GET))  ||  ($NAME=='')) { echo 'class="active-point"';} ?>  href="?"><li >Всё</li></a>
				<a href="?design=<?php echo "$DESIGN";?>&name=2" <?php if ($NAME=='2') { echo 'class="active-point"';} ?> > <li>2</li></a>
				<a href="?design=<?php echo "$DESIGN";?>&name=3" <?php if ($NAME=='3') { echo 'class="active-point"';} ?> > <li>3</li></a>
				<a href="?design=<?php echo "$DESIGN";?>&name=4" <?php if ($NAME=='4') { echo 'class="active-point"';} ?> > <li>4</li></a>
				<a href="?design=<?php echo "$DESIGN";?>&name=5" <?php if ($NAME=='5') { echo 'class="active-point"';} ?> > <li>5</li></a>
				<a href="?design=<?php echo "$DESIGN";?>&name=6" <?php if ($NAME=='6') { echo 'class="active-point"';} ?> > <li>6</li></a>
				<a href="?design=<?php echo "$DESIGN";?>&name=7" <?php if ($NAME=='7') { echo 'class="active-point"';} ?> > <li>7</li></a>
				<a href="?design=<?php echo "$DESIGN";?>&name=8" <?php if ($NAME=='8') { echo 'class="active-point"';} ?> > <li>8</li></a>
				<a href="?design=<?php echo "$DESIGN";?>&name=9" <?php if ($NAME=='9') { echo 'class="active-point"';} ?> > <li>9</li></a>
			</ul>
		</div>
		<?php 
			function tableForm($X) {
				echo "<table>";
				for ($J=1; $J<10; $J++) {
					echo "<tr><td>"."<a class='span' href='?design=".$GLOBALS['DESIGN']."&name=".$X."'>".$X.'</a>'."x"."<a class='span' href='?design=".$GLOBALS['DESIGN']."&name=$J'>".$J.'</a>'."=</td><td>".$X*$J."</td>";
				}
				echo "</table>";
			}
			function divForm($X) {
				echo "<div class='block'>";
				for ($J=1; $J<10; $J++) {
					echo ""."<a class='span' href='?design=".$GLOBALS['DESIGN']."&name=".$X."'>".$X.'</a>'."x"."<a class='span' href='?design=".$GLOBALS['DESIGN']."&name=".$J."'>".$J.'</a>'."=".$X*$J.'<br>';
				}
				echo '</div>';
			}

			switch ($NAME) {
				case '2':
					if ($DESIGN=='div') {
						divForm(2);
					} else {tableForm(2);}
					break;
				case '3':
					if ($DESIGN=='div') {
						divForm(3);
					} else {tableForm(3);}
					break;	
				case '4':
					if ($DESIGN=='div') {
						divForm(4);
					} else {tableForm(4);}
					break;	
				case '5':
					if ($DESIGN=='div') {
						divForm(5);
					} else {tableForm(5);}
					break;	
				case '6':
					if ($DESIGN=='div') {
						divForm(6);
					} else {tableForm(6);}
					break;			
				case '7':
					if ($DESIGN=='div') {
						divForm(7);
					} else {tableForm(7);}
					break;	
				case '8':
					if ($DESIGN=='div') {
						divForm(8);
					} else {tableForm(8);}
					break;
				case '9':
					if ($DESIGN=='div') {
						divForm(9);
					} else {tableForm(9);}
					break;
				default:
					if ($DESIGN=='div') {
						for ($f=2; $f<10; $f++) {divForm($f);}
					} else {for ($f=2; $f<10; $f++) {tableForm($f);}}								
			}
			
		?>
</main>
	<footer>
		<p>Лабораторные работы</p>
		<p>2019 год</p>
		Тип верстки: <?php if ($DESIGN=='div') {echo 'блочная';} else {echo 'табличная';}?>. Название таблицы: <?php if (($NAME == 'all') || $NAME == '') {echo "полная";} else {echo "одна колонка";} ?>. Дата и время: <?php $date = date('d-m-Y H:i:s'); echo $date; ?>
	</footer>
</body>
</html>

