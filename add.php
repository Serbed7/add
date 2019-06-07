<?php
#exit;

$pered[0] = "(Game Free) ";
$pered[1] = "(Casual Game) ";
$pered[2] = "(Game for PC) ";
$pered[3] = "(New Release) ";
$pered[4] = "(Download Game) ";

require_once( dirname(__FILE__) . '/wp-admin/includes/post.php');
require_once( dirname(__FILE__) . '/wp-load.php' );
require_once( dirname(__FILE__) . '/wp-admin/includes/admin.php');

set_time_limit(2400);
ini_set('session.gc_maxlifetime', 2400);

$xmlData = file_get_contents('http://rss.bigfishgames.com/rss.php?username=discountgames&type=6&locale=en&gametype=pc');
$fd = fopen("xml.txt", 'w') or die("1111111111111111111111111111");
fwrite($fd, $xmlData);
fclose($fd);

$sc=0;
$fd = fopen("xml.txt", 'r') or die("2222222222222222222222222222221");

while ($buffer = fgets($fd)) {

if (strpos($buffer, 'gameid')) { $gameid=trim(strip_tags($buffer)); }
if (strpos($buffer, 'gamename')) { $gamename=trim(strip_tags($buffer)); }
if (strpos($buffer, 'genreid')) { $genreid=trim(strip_tags($buffer)); }
if (strpos($buffer, 'shortdesc')) { $shortdesc=trim(strip_tags($buffer)); }
if (strpos($buffer, 'meddesc')) { $meddesc=trim(strip_tags($buffer)); }
if (strpos($buffer, 'longdesc')) { $longdesc=trim(strip_tags($buffer)); }
if (strpos($buffer, 'foldername')) { $foldername=trim(strip_tags($buffer)); }

if ($foldername) {


if (get_user_meta( '1', $gamename )) { } else {


add_user_meta( '1', $gamename, '111' );


$textp=$meddesc.$shortdesc.$longdesc;


$bez= str_replace('en_', '', $foldername, );
$vyvod='<img hspace="30" src="https://bigfishgames-a.akamaihd.net/'.$foldername.'/'.$bez.'_feature.jpg" style="float: left;" vspace="30" /><br/>'.$textp.'<br><div style="text-align: center;"><a href="https://www.bigfishgames.com/download-games/'.$gameid.'/'.$bez.'/download.html?channel=affiliates&identifier=afce7461faca" rel="nofollow"><img border="0" src="https://www.allbigfishgames.com/download.jpg" width="320" height="176"></a><br />Screenshots:<br /><br /><a href="https://bigfishgames-a.akamaihd.net/'.$foldername.'/screen1.jpg"><img src="https://bigfishgames-a.akamaihd.net/'.$foldername.'/th_screen1.jpg"></a><a href="https://bigfishgames-a.akamaihd.net/'.$foldername.'/screen2.jpg"><img src="https://bigfishgames-a.akamaihd.net/'.$foldername.'/th_screen2.jpg"></a><a href="https://bigfishgames-a.akamaihd.net/'.$foldername.'/screen3.jpg"><img src="https://bigfishgames-a.akamaihd.net/'.$foldername.'/th_screen3.jpg"></a></div>';

$gamenamed=$gamename;
$gamenamed = str_replace(  'Collector&#039;s Edition',  '(Collector&#039;s Edition)',  $gamenamed );
if (strlen ($gamenamed)<45) { $gamenamed =$pered[array_rand($pered, 1)].$gamenamed; }

$post_data = array(
  'post_title'    => $gamenamed,
  'post_content'  => $vyvod,
  'post_status'   => 'publish',
  'post_author'   => 1,
  'post_category' => array(1)
);

$post_id = wp_insert_post($post_data, true);
print_r($post_id).'
'; 

$sc=$sc+1; $foldername='';

#echo $vyvod; exit;
} }

if ($sc>50) {exit;}
}
fclose($fd);
?>