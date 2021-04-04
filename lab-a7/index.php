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
		<form method="POST" action="answer.php">
	<table id="elements">
	     <tr><td class="element_row">1. <input type="text" name="element0"></td></tr>
	</table>
	<input type="hidden" id="arrLength">
	<input type="button" value="Добавить еще один элемент" onClick="addElement('elements', 1);">
	<br><br>
	<select name='option'>
		<option value="v1">Сортировка выбором</option>
		<option value="v2">Пузырьковый алгоритм</option>
		<option value="v3">Алгоритм Шелла</option>
		<option value="v4">Алгоритм садового гнома</option>
		<option value="v5">Быстрая сортировка</option>
		<option value="v6">Встроенная функция РНР для сортировки списков по значению</option>
	</select>
	<br><br>
	<input type="submit" value="Сортировать массив">
</form>
	</main>
	<footer>
		<p>Лабораторные работы</p>
		<p>2019 год</p>
	</footer>
</body>

<script>
	function addElement(table_name, amount) { // функция добавляет еще один элемент 
		var t = document.getElementById(table_name); // объект таблицы
        for(var i=0; i<amount; i++) {
			var index=t.rows.length; // индекс новой строки 
			var row=t.insertRow(index); // добавляем новую строку
			var cel = row.insertCell(0); // добавляем в строку ячейку 
			cel.className='element_row'; // определяем css-класс ячейки
			var celcontent=(index+1)+'.<input type="text" name="element'+index+'">';
			setHTML(cel, celcontent);
          	document.getElementById('arrLength').value=t.rows.length;
       }
   	}
    function setHTML(element, txt){
    	if(element.innerHTML) element.innerHTML = txt;
			else {
				var range = document.createRange();
				range.selectNodeContents(element);
				range.deleteContents();
				var fragment = range.createContextualFragment(txt);
				element.appendChild(fragment);
			} 
	}
</script>

</html>

