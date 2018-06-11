<<<<<<< HEAD
<?php
include_once('../one_connection.php');

$sql = "SELECT DATE_FORMAT(  `EventTime` ,  '%Y%m%d' ) daysort, DATE_FORMAT(  `EventTime` ,  '%d %b %y' ) days, COUNT(  `Id` ) count
FROM event
GROUP BY days
ORDER BY daysort asc";
$query = mysql_query($sql);
$amount=mysql_num_rows($query);
while($row=mysql_fetch_array($query)){
	$arr[] = array(
		'day'=> $row['days'],
		'count' => $row['count'],
		'amount' => $amount
	);
}
//var_dump($arr);


mysql_close($link);
echo json_encode($arr);
//[{"day":"20170304","count":"5"},{"name":"�½�","value":"0.94"}]
=======
<?php
include_once('../one_connection.php');

$sql = "SELECT DATE_FORMAT(  `EventTime` ,  '%Y%m%d' ) daysort, DATE_FORMAT(  `EventTime` ,  '%d %b %y' ) days, COUNT(  `Id` ) count
FROM event
GROUP BY days
ORDER BY daysort asc";
$query = mysql_query($sql);
$amount=mysql_num_rows($query);
while($row=mysql_fetch_array($query)){
	$arr[] = array(
		'day'=> $row['days'],
		'count' => $row['count'],
		'amount' => $amount
	);
}
//var_dump($arr);


mysql_close($link);
echo json_encode($arr);
//[{"day":"20170304","count":"5"},{"name":"�½�","value":"0.94"}]
>>>>>>> 2eb7366c01376b015e8a81896c102552bc1da07d
?>