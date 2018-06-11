<?php
include_once('connect.php');
$from = $_GET['from'];
$to = $_GET['to'];
$user = $_GET['user'];
$SelectCourseId=$_GET['SelectCourseId'];
$SelectYearId=$_GET['SelectYearId'];
$SelectSemesterId=$_GET['SelectSemesterId'];
$sstr='SER';
$user =substr_replace($user,$sstr,1,0);
echo "Course: ".$SelectCourseId.", ".$SelectYearId.", ".$SelectSemesterId.'</br>';
echo "User: ".$user.'</br>';
echo "Start time: ".$from.'</br>';
echo "End time: ".$to.'</br>'.'</br>';
echo '<a href="#Event name">Event name and amount </a>'.'</br>'.'</br>';
echo '<a href="#Event context">Event context and amount </a>'.'</br>'.'</br>';

 echo '<table border=1 id="Event name">';
 echo "<tr><th>Event name</th><th>Amount of event</th></tr>";



$sql = "SELECT Name, COUNT(  `Id` ) count
FROM event
WHERE FKUserId='{$user}' and EventTime between '{$from}' and '{$to}' and CourseName='{$SelectCourseId}' and DataSourceType=1  
GROUP BY Name
ORDER BY count desc";
$query = mysql_query($sql);
while($row=mysql_fetch_array($query)){

		echo '<tr><td>'.$row['Name'].'</td><td>'.$row['count'].'</td></tr>';


}
echo "</table></br>";

 echo '<table border=1 id="Event context">';
 echo "<tr><th>Event context</th><th>Amount of event</th></tr>";

 $sql = "SELECT Prefix, Context, COUNT(  `Id` ) count
FROM event
WHERE FKUserId='{$user}' and EventTime between '{$from}' and '{$to}'  
GROUP BY Context
ORDER BY count desc";
$query = mysql_query($sql);
while($row=mysql_fetch_array($query)){

		echo '<tr><td>'.$row['Prefix'].': '.$row['Context'].'</td><td>'.$row['count'].'</td></tr>';


}
echo "</table>";







mysql_close($link);

?>