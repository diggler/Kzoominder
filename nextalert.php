<?
include_once("functions.php");
$res = next_alert(1);
echo "Next alert is " . date("l, F j, Y", $res);
?>