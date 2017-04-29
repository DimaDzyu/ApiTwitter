<?
require "./modules/Twitter.php";

use feed\twitter\TwitterFeed;

$ob = new TwitterFeed();
$arTwitter = $ob->GetTwitter('netpeak_ru', '25');

$arResult = $arTwitter;
?>