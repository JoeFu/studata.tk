<?php
include_once('../one_connection.php');

$from = $_POST['from'];
$to = $_POST['to'];

$sql = "SELECT name, COUNT(  `Id` ) count
FROM event
WHERE EventTime between '{$from}' and '{$to}'
GROUP BY name";
$query = mysql_query($sql);
while($row=mysql_fetch_array($query)){
	$arr[] = array(
		'name'=> $row['name'],
		'count' => ($row['count']/1000)
	);
}
//var_dump($arr);


mysql_close($link);
echo json_encode($arr);
//[{"name":"course_move","count":"5"},{"name":"�½�","value":"0.94"}]
?>