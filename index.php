<?php
function generate_calendar($year, $month, $today, $ar) {
	$months_names = array('01' => 'Январь', '02' => 'Февраль', '03' => 'Март', '04' => 'Апрель', '05' => 'Май', '06' => 'Июнь', '07' => 'Июль', '08' => 'Август', '09' => 'Сентябрь', '10' => 'Октябрь', '11' => 'Ноябрь', '12' => 'Декабрь');
	$first_of_month = gmmktime(0, 0, 0, $month, 1, $year);
	$day_names = array(0 => 'пн', 1 => 'вт', 2 => 'ср', 3 => 'чт', 4 => 'пт', 5 => 'сб', 6 => 'вс');
	list($month, $year, $weekday) = explode(',', gmstrftime('%m, %Y, %w', $first_of_month));
	$weekday = ($weekday + 6) % 7;
	$title = htmlentities(ucfirst($months_names[$month]));
	$calendar = "<div class=\"month\">\n" .
		'<p class="m-title">' . $title . "</p>\n<table>\n<thead><tr>";
	foreach ($day_names as $d) {
		$calendar .= '<th>' . htmlentities($d) . '</th>';
	}
	$calendar .= "</tr>\n</thead>\n<tbody>\n<tr>";
	if ($weekday > 0) {
		for ($i = 0; $i < $weekday; $i++) {
			$calendar .= '<td></td>';
		}
	}
	for ($day = 1, $days_in_month = gmdate('t', $first_of_month); $day <= $days_in_month; $day++, $weekday++) {
		if ($weekday == 7) {
			$weekday = 0;
			$calendar .= "</tr>\n<tr>";
		}
		$da = $day . '.' . $month;
		if ($today == $da) {
			$class = 'today';
		} else {
			$class = '';
		}
		if (is_array($ar) && isset($ar[$da])) {
			$class .= ' reserved';
		}
		$calendar .= "<td" . ($class ? ' class="' . htmlspecialchars($class) . '"' : '') . ' data="' . $da . '"' . ">$day</td>";
	}
	if ($weekday != 7) {
		$calendar .= '<td colspan="' . (7 - $weekday) . '"></td>';
	}
	return $calendar . "</tr>\n</tbody>\n</table>\n</div>\n";
}
$time = time();
$today = date('j.m', $time);
$bron = file_get_contents('./data.txt');
$ar = json_decode($bron, TRUE);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Тестовое задание</title>
<link rel="stylesheet" href="./style.css">
</head>
<body>
<div class="contain">
	<h1>Бронирование даты</h1>
	<h2>Тестовое задание на должность fullstack-разработчика</h2>
	<div class="calendar">
		<?php
for ($i = 1; $i <= 12; $i++) {
	echo generate_calendar(date('Y', $time), $i, $today, $ar);
}
?>
	</div>
	<form action="">
		<label for="phone">Укажите телефон:</label><br>
		<input type="tel" name="phone" id="phone">
		<input type="hidden" name="data" id="data">
		<div id="button"><span>Забронировать</span>
</div>
	</form>
	<div id="alert"></div>
</div>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js?ver=5.4.2"></script>
<script src="./jquery.inputmask.js"></script>
<script src="./scripts.js"></script>
</body>
</html>