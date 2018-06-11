<?php
include_once('../one_connection.php');
$view = $_GET['view'];
$TimeType='';
switch ($view)
{
case 1:
  $TimeType='%Y';
  break;
case 2:
  $TimeType='%Y%m';
  break;
case 3:
  $TimeType='%Y%m%d';
  break;
}


$action = $_GET['action'];
    if ($action=='export') { //����CSV 

 
		//date_default_timezone_set('Australia/Adelaide'); //PRC
		$CurrentTime=date('Y-m-d H:i:s');
        $str = "Chart name,All activities overview\n";
		$str .= "Course name,Distributed Systems Semester 2 2012\n";
		$str .= "Time generated,$CurrentTime\n\n";
		
		$i=1;
		$str .= "Top 3, \n";
        $str .= "Time,Amount of activities\n"; 
		        $result = mysql_query(
"SELECT DATE_FORMAT(  `EventTime` ,  '{$TimeType}' ) days, COUNT(  `Id` ) count
FROM event
GROUP BY days
ORDER BY count desc");
            while($row=mysql_fetch_array($result)){ 
				if($i<=3)
				{
					$str .= $row['days'].",".$row['count']."\n"; //�����Ķ��ŷֿ�
					$i++;
				}
				else
					break;
				
            }


			$i=1;
		$str .= " , \n";
		$str .= "Bottom 3, \n";
        $str .= "Time,Amount of activities\n"; 
		        $result = mysql_query(
"SELECT DATE_FORMAT(  `EventTime` ,  '{$TimeType}' ) days, COUNT(  `Id` ) count
FROM event
GROUP BY days
ORDER BY count asc");
            while($row=mysql_fetch_array($result)){ 
				if($i<=3)
				{
					$str .= $row['days'].",".$row['count']."\n"; //�����Ķ��ŷֿ�
					$i++;
				}
				else
					break;
				
            }


		$str .= " , \n";
		$str .= "All the data, \n";
        $str .= "Time,Amount of activities\n"; 
        //$str = iconv('utf-8','gb2312',$str);
		        $result = mysql_query(
"SELECT DATE_FORMAT(  `EventTime` ,  '{$TimeType}' ) days, COUNT(  `Id` ) count
FROM event
GROUP BY days");
            while($row=mysql_fetch_array($result)){ 
               $str .= $row['days'].",".$row['count']."\n"; //�����Ķ��ŷֿ� 
            } 
        $filename = 'All activities overview'.'.csv'; //�����ļ��� 
        export_csv($filename,$str); //���� 
    } 

    function export_csv($filename,$data) { 
        header("Content-type:text/csv"); 
        header("Content-Disposition:attachment;filename=".$filename); 
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0'); 
        header('Expires:0'); 
        header('Pragma:public'); 
        echo $data; 
        exit;
        
    } 



/*$sql = "SELECT DATE_FORMAT(  `EventTime` ,  '%Y%m%d' ) days, COUNT(  `Id` ) count
FROM event
GROUP BY days";
$query = mysql_query($sql);
while($row=mysql_fetch_array($query)){
	$arr[] = array(
		'day'=> $row['days'],
		'count' => $row['count']
	);
}
//var_dump($arr);*/


mysql_close($link);

?>