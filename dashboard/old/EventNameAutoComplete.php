<?php
require_once('../one_connection.php');

$q = strtolower($_GET["term"]);
$EventNameThreshold = $_GET["EventNameThreshold"];

$in='(';
$sql = "SELECT name, COUNT(  `Id` ) count
FROM event
GROUP BY name
HAVING count>{$EventNameThreshold}";
$query = mysql_query($sql);
while($row=mysql_fetch_array($query)){
	$arr[] = array(
		'name'=> $row['name'],
		'count' => ($row['count']/1000)
	);
	//echo $row['name'];

	//echo $row['count'].'</br>';
	$in.='\''.$row['name'].'\',';
	//echo $in;
}
$in=rtrim($in, ",");
$in.=')';
//echo $in.'</br></br>';


$sql = "select distinct Name from  event where Name LIKE '$q%' and Name in {$in}";
$rsd = mysql_query($sql);
while($rs = mysql_fetch_array($rsd)){

	    $result[] = array( 
 
        'label' => $rs['Name'] 
    ); 



}
 echo json_encode($result);
?>