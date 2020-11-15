<?/*
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("");
?>
<?
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
define('CHK_EVENT', true);
@set_time_limit(0);
@ignore_user_abort(true);
global $USER;
$USER->Authorize(1);

$currentуelement = 0;
$rss = "https://lenta.ru/rss";
$xmlstr = @file_get_contents($rss);
if ($xmlstr === false) die('Error connect to RSS: ' . $rss);
$xml = new SimpleXMLElement($xmlstr);
if ($xml === false) die('Error parse RSS: ' . $rss);
foreach ($xml->channel->item as $item) {
    echo 'НАЗВАНИЕ:  ' . $item->title . '<br>';
    echo 'ССЫЛКА НА НОВОСТЬ:  ' . $item->link . '<br>';
    echo 'АНОНС:  ' . $item->description . '<br>';


    echo '<hr>';

    $currentуelement++;
    if ($currentуelement >= 5) {
        break;
    }
}
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); */?>



<?php
$_SERVER["DOCUMENT_ROOT"] = "/home/bitrix/www";
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
define('CHK_EVENT', true);
ini_set('memory_limit', '-1');
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

@set_time_limit(0);
@ignore_user_abort(true);
global $USER;
$USER->Authorize(1);
$START_TIME = mktime();

$currentуelement = 0;
$rss = "https://lenta.ru/rss";
$xmlstr = @file_get_contents($rss);
if ($xmlstr === false) die('Error connect to RSS: ' . $rss);
$xml = new SimpleXMLElement($xmlstr);
if ($xml === false) die('Error parse RSS: ' . $rss);
foreach ($xml->channel->item as $item) {
    echo 'НАЗВАНИЕ:  ' . $item->title . '\n\n';
    echo 'ССЫЛКА НА НОВОСТЬ:  ' . $item->link . '\n\n';
    echo 'АНОНС:  ' . $item->description . '\n\n';
    $currentуelement++;
    if ($currentуelement >= 5) {
        break;
    }
}

$TIME = (mktime() - $START_TIME);
echo "\n\nВремя обработки, сек: $TIME \n\n";
echo "\n\nКол-во обработанных элементов: $n \n\n";



