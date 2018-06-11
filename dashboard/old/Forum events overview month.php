<?php
include_once('../one_connection.php');

$sql = "SELECT DATE_FORMAT(  `EventTime` ,  '%Y%m' ) daysort, DATE_FORMAT(  `EventTime` ,  '%b %y' ) days,COUNT(  `Id` ) count
FROM event
GROUP BY days
ORDER BY daysort asc";
$query = mysql_query($sql);
while($row=mysql_fetch_array($query)){
	$arr[] = array(
		'day'=> $row['days'],
		'count' => ($row['count']/1000)
	);
}
//var_dump($arr);


mysql_close($link);
echo json_encode($arr);
//[{"day":"20170304","count":"5"},{"name":"�½�","value":"0.94"}]
?>