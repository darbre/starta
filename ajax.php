<?php
$data = htmlspecialchars($_POST["data"]);
$phone = htmlspecialchars($_POST["phone"]);
$fh = fopen('data.txt', 'a+');
$content = fgets($fh);
$ar = json_decode($content, TRUE);
$ar[$data] = $phone;
$content = json_encode($ar);
file_put_contents('data.txt', '');
fwrite($fh, $content);
fclose($fh);
echo "ok";
?>