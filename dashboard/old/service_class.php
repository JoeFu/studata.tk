<?php
class Service
{	
	//Load course name for the first drop down box
	public function loadCourse()
	{
		include('../one_connection.php');
		$sql = "SELECT distinct `CourseName` from event where CourseName is not NULL";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$arr[] = array(
				'CourseName'=> $row['CourseName'],
			);
		}
		mysql_close($link);
		return json_encode($arr);
	}

	//Load year for the second drop down box
	public function loadYear($SelectCourseId = "")
	{
		include('../one_connection.php');
		$sql = "SELECT distinct `SchoolYear`
		from event
		where CourseName='{$SelectCourseId}'
		order by SchoolYear asc";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$arr[] = array(
				'SchoolYear'=> $row['SchoolYear'],
			);
		}
		mysql_close($link);
		return json_encode($arr);
	}

	//Load semester for the third drop down box
	public function loadSemester($SelectCourseId = "", $SelectYearId="")
	{
		include('../one_connection.php');
		$sql = "SELECT distinct `Semester` 
		from event
		where CourseName='{$SelectCourseId}' and SchoolYear= '{$SelectYearId}'
		order by Semester asc";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$arr[] = array(
				'Semester'=> $row['Semester'],
			);
		}
		mysql_close($link);
		return json_encode($arr);
	}

	//Load assignment for the fourth drop down box
	public function loadAssignment($SelectCourseId = "", $SelectYearId="", $SelectSemesterId="")
	{
		include('../one_connection.php');
		$sql = "SELECT distinct `AssignmentName` 
		from event
		where CourseName='{$SelectCourseId}' and SchoolYear= '{$SelectYearId}' and Semester='{$SelectSemesterId}'
		order by AssignmentName asc";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$arr[] = array(
				'AssignmentName'=> $row['AssignmentName'],
			);
		}
		mysql_close($link);
		return json_encode($arr);
	}

	//Load data for the chart Submission Time Distribution 5 Days (y-axis: Number of submissions)
	public function submissionTimeDistribution5Days($SelectCourse = "", $SelectYear="", $SelectSemester="", $SelectAssignment="")
	{
		include('../one_connection.php');

		//get assignment deadline
		$sql = "SELECT distinct DATE_FORMAT(  `DueDate` ,  '%Y%m%d' ) dueDate 
		from event
		where `CourseName`='{$SelectCourse}' and `SchoolYear`='{$SelectYear}' and `Semester`='{$SelectSemester}' and `AssignmentName`='{$SelectAssignment}' and `DataSourceType`=2";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$DueDate = $row['dueDate'];//yyyymmdd
		}

		//Convert $DueDate to time
		$timeDueDate= strtotime($DueDate);
		//the 5th day before deadline
		$DueDateMinus5=date('Ymd',strtotime("$DueDate -5 day"));
		//the 6th day after deadline
		$DueDatePlus6=date('Ymd',strtotime("$DueDate +6 day"));

		$sql = "SELECT DATE_FORMAT(  `EventTime` ,  '%Y%m%d' ) days, COUNT(  `Id` ) count
		from event
		where `CourseName`='{$SelectCourse}' and `SchoolYear`='{$SelectYear}' and `Semester`='{$SelectSemester}' and `AssignmentName`='{$SelectAssignment}' and `DataSourceType`=2 and `FKEventTypeId`=5
		GROUP BY days
		having days between '{$DueDateMinus5}' and '{$DueDatePlus6}'";

		//the main purpose of the following code is to add those days with 
		//0 submission to array, since the query result will not include them
		//arrCount array to store how many submissions per day
		$arrCount=array();
		for ($x=-5; $x<=5; $x++) {
			$arrCount[$x]=0;
		}
		
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$tmpDays=(int)round((strtotime($row['days'])-$timeDueDate)/3600/24);
			$arrCount[$tmpDays]=$arrCount[$tmpDays]+$row['count'];
		}
		mysql_close($link);

		//convert arrCount array to another array that is in JSON format
		for ($x=-5; $x<=5; $x++) {
			if ($x<=0) {
				$arr[] = array(
					'days' => $x,
					'count' => $arrCount[$x]
				);
			} else {
				$daysWithPlusSign="+".(string)$x;
				$arr[] = array(
					'days' => $daysWithPlusSign,
					'count' => $arrCount[$x]
				);
			}
		} 
		return json_encode($arr);
		//[{"day":"-5","count":"5"},{"day":"-4","count":"5"}]
	}

	//Load data for the chart Submission Time Distribution 5 Days (y-axis: Number of students submit)
	public function submissionTimeDistribution5DaysStudent($SelectCourse = "", $SelectYear="", $SelectSemester="", $SelectAssignment="")
	{
		include('../one_connection.php');

		//get assignment deadline
		$sql = "SELECT distinct DATE_FORMAT(  `DueDate` ,  '%Y%m%d' ) dueDate 
		from event
		where `CourseName`='{$SelectCourse}' and `SchoolYear`='{$SelectYear}' and `Semester`='{$SelectSemester}' and `AssignmentName`='{$SelectAssignment}' and `DataSourceType`=2";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$DueDate = $row['dueDate'];//yyyymmdd
		}

		//Convert $DueDate to time
		$timeDueDate= strtotime($DueDate);
		//the 5th day before deadline
		$DueDateMinus5=date('Ymd',strtotime("$DueDate -5 day"));
		//the 6th day after deadline
		$DueDatePlus6=date('Ymd',strtotime("$DueDate +6 day"));

		$sql = "SELECT DISTINCT DATE_FORMAT(  `EventTime` ,  '%Y%m%d' ) days, FKUserId
		from event
		where `CourseName`='{$SelectCourse}' and `SchoolYear`='{$SelectYear}' and `Semester`='{$SelectSemester}' and `AssignmentName`='{$SelectAssignment}' and `DataSourceType`=2 and `FKEventTypeId`=5";

		//the main purpose of the following code is to add those days with 
		//0 student submits to array, since the query result will not include them
		//arrCount array to store how many students submit per day
		$arrCount=array();
		for ($x=-200; $x<=200; $x++) {
			$arrCount[$x]=0;
		}
		
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$tmpDays=(int)round((strtotime($row['days'])-$timeDueDate)/3600/24);
			$arrCount[$tmpDays]++;
		}
		mysql_close($link);

		//convert arrCount array to another array that is in JSON format
		for ($x=-5; $x<=5; $x++) {
			if ($x<=0) {
				$arr[] = array(
					'days' => $x,
					'count' => $arrCount[$x]
				);
			} else {
				$daysWithPlusSign="+".(string)$x;
				$arr[] = array(
					'days' => $daysWithPlusSign,
					'count' => $arrCount[$x]
				);
			}
		} 
		return json_encode($arr);
		//[{"day":"-5","count":"5"},{"day":"-4","count":"5"}]
	}

	//Load data for the chart Submission Time Distribution 96 Hours
	public function submissionTimeDistribution96Hours($SelectCourse = "", $SelectYear="", $SelectSemester="", $SelectAssignment="")
	{
		include('../one_connection.php');

		//get assignment deadline
		$sql = "SELECT distinct DATE_FORMAT(  `DueDate` ,  '%Y-%m-%d %H:%m:%s' ) dueHour 
		from event
		where `CourseName`='{$SelectCourse}' and `SchoolYear`='{$SelectYear}' and `Semester`='{$SelectSemester}' and `AssignmentName`='{$SelectAssignment}' and `DataSourceType`=2";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$DueHour = $row['dueHour'];//yyyy-mm-dd hh:mm:ss
		}
		
		$timeDueHour= strtotime($DueHour);
		//the 96th hour before deadline
		$DueHourMinus96=date('Y-m-d H:i:s',strtotime("$DueHour -96 hours"));
		//the 97th hour after deadline
		$DueHourPlus97=date('Y-m-d H:i:s',strtotime("$DueHour +97 hours"));

		$sql = "SELECT DATE_FORMAT(  `EventTime` ,  '%Y-%m-%d %H:%m:%s' ) days, COUNT(  `Id` ) count
		from event
		where `CourseName`='{$SelectCourse}' and `SchoolYear`='{$SelectYear}' and `Semester`='{$SelectSemester}' and `AssignmentName`='{$SelectAssignment}' and `DataSourceType`=2 and `FKEventTypeId`=5
		GROUP BY days
		having days between '{$DueHourMinus96}' and '{$DueHourPlus97}'";

		//arrCount array to store how many submissions per hour
		$arrCount=array();
		for ($x=-96; $x<=96; $x++) {
			$arrCount[$x]=0;
		}
		
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$tmpDays=(int)ceil((strtotime($row['days'])-$timeDueHour)/3600);
			$arrCount[$tmpDays]=$arrCount[$tmpDays]+$row['count'];
		}
		mysql_close($link);

		//convert arrCount array to another array that is in JSON format
		for ($x=-96; $x<=96; $x++) {
			if ($x<=0) {
				$arr[] = array(
					'days' => $x,
					'count' => $arrCount[$x]
				);
			} else {
				$daysWithPlusSign="+".(string)$x;
				$arr[] = array(
					'days' => $daysWithPlusSign,
					'count' => $arrCount[$x]
				);
			}
		} 
		return json_encode($arr);
		//[{"days":-96,"count":0},{"days":-95,"count":1},{"days":-94,"count":0}]
	}

	//Load data for the chart Submission Time Distribution 96 Hours (y-axis: Number of students submit)
	public function submissionTimeDistribution96HoursStudent($SelectCourse = "", $SelectYear="", $SelectSemester="", $SelectAssignment="")
	{
		include('../one_connection.php');

		//get assignment due hour
		$sql = "SELECT distinct DATE_FORMAT(  `DueDate` ,  '%Y-%m-%d %H:%m:%s' ) dueHour 
		from event
		where `CourseName`='MSE' and `SchoolYear`='2012' and `Semester`='Semester 2' and `AssignmentName`='Assignment 2' and `DataSourceType`=2";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$DueHour = $row['dueHour'];//YYYY-MM-DD HH:MM:SS 2012-09-22 17:09:00
		}

		$sql = "SELECT DISTINCT TIMESTAMPDIFF(Hour,'{$DueHour}',`EventTime`) days, FKUserId
		from event
		where `CourseName`='MSE' and `SchoolYear`='2012' and `Semester`='Semester 2' and `AssignmentName`='Assignment 2' and `DataSourceType`=2 and `FKEventTypeId`=5";

		//arrCount array to store how many submissions per hour
		$arrCount=array();
		for ($x=-96; $x<=96; $x++) {
			$arrCount[$x]=0;
		}
		
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			if( $row['days']>=-96 && $row['days']<=96){
				$arrCount[$row['days']]++;		
			}
		}
		mysql_close($link);

		//convert arrCount array to another array that is in JSON format
		for ($x=-96; $x<=96; $x++) {
			if ($x<=0) {
				$arr[] = array(
					'days' => $x,
					'count' => $arrCount[$x]
				);
			} else {
				$daysWithPlusSign="+".(string)$x;
				$arr[] = array(
					'days' => $daysWithPlusSign,
					'count' => $arrCount[$x]
				);
			}
		} 
		return json_encode($arr);
		//[{"days":-96,"count":0},{"days":-95,"count":1},{"days":-94,"count":0}]	
	}

	//Load data for the chart Submission Time Distribution (y-axis: Number of submissions)
	public function submissionTimeDistributionSubmission($SelectCourse = "", $SelectYear="", $SelectSemester="", $SelectAssignment="")
	{
		include('../one_connection.php');

		//get assignment deadline
		$sql = "SELECT distinct DATE_FORMAT(  `StartDate` ,  '%Y%m%d' ) startDate, DATE_FORMAT(  `DueDate` ,  '%Y%m%d' ) dueDate 
		from event
		where `CourseName`='{$SelectCourse}' and `SchoolYear`='{$SelectYear}' and `Semester`='{$SelectSemester}' and `AssignmentName`='{$SelectAssignment}' and `DataSourceType`=2";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$StartDate = $row['startDate'];//yyyymmdd
			$DueDate = $row['dueDate'];//yyyymmdd
		}

		//Convert $StartDate,$DueDate to time
		$timeStartDate= strtotime($StartDate);
		$timeDueDate= strtotime($DueDate);
		//the start date
		$StartDateMinus0=date('Ymd',strtotime("$StartDate"));
		//the 6th day after deadline
		$DueDatePlus6=date('Ymd',strtotime("$DueDate +6 day"));

		$sql = "SELECT DATE_FORMAT(  `EventTime` ,  '%Y%m%d' ) days, COUNT(  `Id` ) count
		from event
		where `CourseName`='{$SelectCourse}' and `SchoolYear`='{$SelectYear}' and `Semester`='{$SelectSemester}' and `AssignmentName`='{$SelectAssignment}' and `DataSourceType`=2 and `FKEventTypeId`=5
		GROUP BY days
		having days between '{$StartDateMinus0}' and '{$DueDatePlus6}'";

		//the difference between start date and due date
		$i=(int)round(($timeStartDate-$timeDueDate)/3600/24);

		//the main purpose of the following code is to add those days with 
		//0 submission to array, since the query result will not include them
		//arrCount array to store how many submissions per day
		$arrCount=array();
		for ($x=$i; $x<=5; $x++) {
			$arrCount[$x]=0;
		}
		
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$tmpDays=(int)round((strtotime($row['days'])-$timeDueDate)/3600/24);
			$arrCount[$tmpDays]=$arrCount[$tmpDays]+$row['count'];
		}
		mysql_close($link);

		//convert arrCount array to another array that is in JSON format
		for ($x=$i; $x<=5; $x++) {
			if ($x<=0) {
				$arr[] = array(
					'days' => $x,
					'count' => $arrCount[$x],
					'dueDay' => abs($i)
				);
			} else {
				$daysWithPlusSign="+".(string)$x;
				$arr[] = array(
					'days' => $daysWithPlusSign,
					'count' => $arrCount[$x],
					'dueDay' => abs($i)
				);
			}
		} 
		return json_encode($arr);
		//Example of the output format: [{"day":"-5","count":"5","dueDay":"31"},{"day":"-4","count":"5","dueDay":"31"}]
	}

	//Load data for the chart Submission Time Distribution (y-axis: Number of students submit)
	public function submissionTimeDistributionStudent($SelectCourse = "", $SelectYear="", $SelectSemester="", $SelectAssignment="")
	{
		include('../one_connection.php');

		//get assignment deadline
		$sql = "SELECT distinct DATE_FORMAT(  `StartDate` ,  '%Y%m%d' ) startDate, DATE_FORMAT(  `DueDate` ,  '%Y%m%d' ) dueDate 
		from event
		where `CourseName`='{$SelectCourse}' and `SchoolYear`='{$SelectYear}' and `Semester`='{$SelectSemester}' and `AssignmentName`='{$SelectAssignment}' and `DataSourceType`=2";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$StartDate = $row['startDate'];//yyyymmdd
			$DueDate = $row['dueDate'];//yyyymmdd
		}

		//Convert $StartDate,$DueDate to time
		$timeStartDate= strtotime($StartDate);
		$timeDueDate= strtotime($DueDate);
		//the start date
		$StartDateMinus0=date('Ymd',strtotime("$StartDate"));
		//the 6th day after deadline
		$DueDatePlus6=date('Ymd',strtotime("$DueDate +6 day"));

		$sql = "SELECT DISTINCT DATE_FORMAT(  `EventTime` ,  '%Y%m%d' ) days, FKUserId
		from event
		where `CourseName`='{$SelectCourse}' and `SchoolYear`='{$SelectYear}' and `Semester`='{$SelectSemester}' and `AssignmentName`='{$SelectAssignment}' and `DataSourceType`=2 and `FKEventTypeId`=5";

		//the difference between start date and due date
		$i=(int)round(($timeStartDate-$timeDueDate)/3600/24);

		//the main purpose of the following code is to add those days with 
		//0 student submits to array, since the query result will not include them
		//arrCount array to store how many students submit per day
		$arrCount=array();
		for ($x=$i; $x<=5; $x++) {
			$arrCount[$x]=0;
		}
		
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$tmpDays=(int)round((strtotime($row['days'])-$timeDueDate)/3600/24);
			if( $tmpDays>=$i && $tmpDays<=5){
				$arrCount[$tmpDays]++;		
			}
		}
		mysql_close($link);

		//convert arrCount array to another array that is in JSON format
		for ($x=$i; $x<=5; $x++) {
			if ($x<=0) {
				$arr[] = array(
					'days' => $x,
					'count' => $arrCount[$x],
					'dueDay' => abs($i)
				);
			} else {
				$daysWithPlusSign="+".(string)$x;
				$arr[] = array(
					'days' => $daysWithPlusSign,
					'count' => $arrCount[$x],
					'dueDay' => abs($i)
				);
			}
		} 
		return json_encode($arr);
		//Example of the output format: [{"day":"-5","count":"5","dueDay":"31"},{"day":"-4","count":"5","dueDay":"31"}]
	}

	//Load data for the chart First Submission Time Distribution
	public function firstSubmissionTimeDistribution($SelectCourse = "", $SelectYear="", $SelectSemester="", $SelectAssignment="")
	{
		include('../one_connection.php');

		//get assignment start date and end date
		$sql = "SELECT distinct DATE_FORMAT(  `StartDate` ,  '%Y%m%d' ) startDate, DATE_FORMAT(  `DueDate` ,  '%Y%m%d' ) dueDate 
		from event
		where `CourseName`='{$SelectCourse}' and `SchoolYear`='{$SelectYear}' and `Semester`='{$SelectSemester}' and `AssignmentName`='{$SelectAssignment}' and `DataSourceType`=2 and `FKEventTypeId`=5";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$StartDate = $row['startDate'];//yyyymmdd
			$DueDate = $row['dueDate'];//yyyymmdd
		}

		//Convert $StartDate,$DueDate to time
		$timeStartDate= strtotime($StartDate);
		$timeDueDate= strtotime($DueDate);
		//the start date
		$StartDateMinus0=date('Ymd',strtotime("$StartDate"));
		//the 6th day after deadline
		$DueDatePlus6=date('Ymd',strtotime("$DueDate +6 day"));

		//minimum repository version stands for the first submission
		//we get the first submission of each user 
		$sql = "select min(RepositoryVersion) rv,FKUserId
		from event
		where `CourseName`='{$SelectCourse}' and `SchoolYear`='{$SelectYear}' and `Semester`='{$SelectSemester}' and `AssignmentName`='{$SelectAssignment}' and `DataSourceType`=2 and `FKEventTypeId`=5
		group by FKUserId";
		$query = mysql_query($sql);

		//get the Id of each user's first submission record
		$i=1;
		while($row=mysql_fetch_array($query)){
			$arrRv[$i]=$row['rv'];
			$arrFKUserId[$i]=$row['FKUserId'];
			$i++;
		}

		//build the condition for "where in" query, example value of $IdInCondition is (27975,27979,27977), 
		$IdInCondition="(";
		for ($x=1; $x<=sizeof($arrRv); $x++) {
			$sql = "select Id
			from event
			where `CourseName`='{$SelectCourse}' and `SchoolYear`='{$SelectYear}' and `Semester`='{$SelectSemester}' and `AssignmentName`='{$SelectAssignment}' and `DataSourceType`=2 and `FKEventTypeId`=5 and RepositoryVersion='{$arrRv[$x]}' and FKUserId='{$arrFKUserId[$x]}'";
			$query = mysql_query($sql);
			while($row=mysql_fetch_array($query)){
				$IdInCondition=$IdInCondition.$row['Id'].",";
			}
		}
		//remove the last redundant comma
		$IdInCondition = substr($IdInCondition,0,strlen($IdInCondition)-1);
		$IdInCondition=$IdInCondition.")";

		//select DATE_FORMAT(  `EventTime` ,  '%Y%m%d' ) days,Id
		//from event
		//where Id in (27975,27979,27977,.....)
		$sql = "select DATE_FORMAT(  `EventTime` ,  '%Y%m%d' ) days,Id
		from event
		where Id in {$IdInCondition}";

		//the main purpose of the following code is to add those days with 0
		//submission to array, since the query result will not include them

		//the difference between start date and due date
		$i=(int)round(($timeStartDate-$timeDueDate)/3600/24);

		//arrCount array to store how many first submissions per day
		$arrCount=array();
		for ($x=$i; $x<=200; $x++) {
		  $arrCount[$x]=0;
		} 

		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$tmpDays=(int)round((strtotime($row['days'])-$timeDueDate)/3600/24);
			$arrCount[$tmpDays]++;
		}

		//convert arrCount array to another array that is in JSON format
		for ($x=$i; $x<=5; $x++) {
			if ($x<=0) {
				$arr[] = array(
					'days' => $x,
					'count' => $arrCount[$x],
					'dueDay' => abs($i),
				);
			} else {
				$daysWithPlusSign="+".(string)$x;
				$arr[] = array(
					'days' => $daysWithPlusSign,
					'count' => $arrCount[$x],
					'dueDay' => abs($i),
				);
			}
		} 
		mysql_close($link);
		return json_encode($arr);
		//[{"day":"-5","count":"5","dueDay":"31"},{"day":"-4","count":"5","dueDay":"31"}]
	}

	//Load data for the chart Last Submission Time Distribution
	public function lastSubmissionTimeDistribution($SelectCourse = "", $SelectYear="", $SelectSemester="", $SelectAssignment="")
	{
		include('../one_connection.php');

		//get assignment start date and end date
		$sql = "SELECT distinct DATE_FORMAT(  `StartDate` ,  '%Y%m%d' ) startDate, DATE_FORMAT(  `DueDate` ,  '%Y%m%d' ) dueDate 
		from event
		where `CourseName`='{$SelectCourse}' and `SchoolYear`='{$SelectYear}' and `Semester`='{$SelectSemester}' and `AssignmentName`='{$SelectAssignment}' and `DataSourceType`=2 and `FKEventTypeId`=5";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$StartDate = $row['startDate'];//yyyymmdd
			$DueDate = $row['dueDate'];//yyyymmdd
		}

		//Convert $StartDate,$DueDate to time
		$timeStartDate= strtotime($StartDate);
		$timeDueDate= strtotime($DueDate);
		//the start date
		$StartDateMinus0=date('Ymd',strtotime("$StartDate"));
		//the 6th day after deadline
		$DueDatePlus6=date('Ymd',strtotime("$DueDate +6 day"));

		//maximum repository version stands for the last submission
		//we get the last submission of each user 
		$sql = "select max(RepositoryVersion) rv,FKUserId
		from event
		where `CourseName`='{$SelectCourse}' and `SchoolYear`='{$SelectYear}' and `Semester`='{$SelectSemester}' and `AssignmentName`='{$SelectAssignment}' and `DataSourceType`=2 and `FKEventTypeId`=5
		group by FKUserId";
		$query = mysql_query($sql);

		//get the Id of each user's last submission record
		$i=1;
		while($row=mysql_fetch_array($query)){
			$arrRv[$i]=$row['rv'];
			$arrFKUserId[$i]=$row['FKUserId'];
			$i++;
		}
		//build the condition for "where in" query, example value of $IdInCondition is (27975,27979,27977), 
		$IdInCondition="(";
		for ($x=1; $x<=sizeof($arrRv); $x++) {
			$sql = "select Id
			from event
			where `CourseName`='{$SelectCourse}' and `SchoolYear`='{$SelectYear}' and `Semester`='{$SelectSemester}' and `AssignmentName`='{$SelectAssignment}' and `DataSourceType`=2 and `FKEventTypeId`=5 and RepositoryVersion='{$arrRv[$x]}' and FKUserId='{$arrFKUserId[$x]}'";
			$query = mysql_query($sql);
			while($row=mysql_fetch_array($query)){
				$IdInCondition=$IdInCondition.$row['Id'].",";
			}
		}
		//remove the last redundant comma
		$IdInCondition = substr($IdInCondition,0,strlen($IdInCondition)-1);
		$IdInCondition=$IdInCondition.")";

		//select DATE_FORMAT(  `EventTime` ,  '%Y%m%d' ) days,Id
		//from event
		//where Id in (27975,27979,27977,.....)
		$sql = "select DATE_FORMAT(  `EventTime` ,  '%Y%m%d' ) days,Id
		from event
		where Id in {$IdInCondition}";

		//the main purpose of the following code is to add those days with 0
		//submission to array, since the query result will not include them

		//the difference between start date and due date
		$i=(int)round(($timeStartDate-$timeDueDate)/3600/24);
		//arrCount array to store how many last submissions per day
		$arrCount=array();
		for ($x=$i; $x<=200; $x++) {
		  $arrCount[$x]=0;
		} 

		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$tmpDays=(int)round((strtotime($row['days'])-$timeDueDate)/3600/24);
			$arrCount[$tmpDays]++;
		}

		//convert arrCount array to another array that is in JSON format
		for ($x=$i; $x<=5; $x++) {
			if ($x<=0) {
				$arr[] = array(
					'days' => $x,
					'count' => $arrCount[$x],
					'dueDay' => abs($i),
				);
			} else {
				$daysWithPlusSign="+".(string)$x;
				$arr[] = array(
					'days' => $daysWithPlusSign,
					'count' => $arrCount[$x],
					'dueDay' => abs($i),
				);
			}
		} 
		mysql_close($link);
		return json_encode($arr);
		//example format of output: [{"day":"-5","count":"5","dueDay":"31"},{"day":"-4","count":"5","dueDay":"31"}]
	}

	//Load data for the chart Number Of Submissions Of Each Student
	public function numberOfSubmissionsOfEachStudent($SelectCourse = "", $SelectYear="", $SelectSemester="", $SelectAssignment="", $order="")
	{
		include('../one_connection.php');

		//$OrderBy records the order: alphabetical, descending, ascending
		$OrderBy='';
		switch ($order){
			case 1:
				$OrderBy='';
				break;
			case 2:
				$OrderBy='ORDER BY count desc';
				break;
			case 3:
				$OrderBy='ORDER BY count asc';
				break;
		}

		$sql = "SELECT FKUserId, COUNT(  `Id` ) count
		from event
		where `CourseName`='{$SelectCourse}' and `SchoolYear`='{$SelectYear}' and `Semester`='{$SelectSemester}' and `AssignmentName`='{$SelectAssignment}' and `DataSourceType`=2 and `FKEventTypeId`=6
		GROUP BY FKUserId
		HAVING count {$OrderBy}";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$arr[] = array(
				'FKUserId'=> $row['FKUserId'],
				'count' => $row['count']
			);
		}
		mysql_close($link);
		return json_encode($arr);
		//example format of output: [{"FKUserId":"21685","count":"5"},{"FKUserId":"21687","count":"6"}]
	}

	//Load data for the chart Mark Distribution
	public function markDistribution($SelectCourse = "", $SelectYear="", $SelectSemester="", $SelectAssignment="", $MarkDistributionSelect="")
	{
		include('../one_connection.php');
		
		//get the max mark of all submissions of an assignment for each user
		$sql = "select floor(max(Grade)*100/MaxGrade) TopGrade,FKUserId
		from event
		where `CourseName`='{$SelectCourse}' and `SchoolYear`='{$SelectYear}' and `Semester`='{$SelectSemester}' and `AssignmentName`='{$SelectAssignment}' and `DataSourceType`=2 and FKEventTypeId=5
		group by FKUserId";
		$query = mysql_query($sql);

		//initialize array
		$arrGPA=array();
		$arrGPA[1]="F";
		$arrGPA[2]="P";
		$arrGPA[3]="C";
		$arrGPA[4]="D";
		$arrGPA[5]="HD";

		$arrGPACount=array();
		for ($x=1; $x<=5; $x++) {
		  $arrGPACount[$x]=0;
		} 

		$arrStep=array();
		$arrStep[1]="0-10%";
		$arrStep[2]="11-20%";
		$arrStep[3]="21-30%";
		$arrStep[4]="31-40%";
		$arrStep[5]="41-50%";
		$arrStep[6]="51-60%";
		$arrStep[7]="61-70%";
		$arrStep[8]="71-80%";
		$arrStep[9]="81-90%";
		$arrStep[10]="91-100%";

		$arrStepCount=array();
		for ($x=1; $x<=10; $x++) {
		  $arrStepCount[$x]=0;
		} 

		while($row=mysql_fetch_array($query)){
			if ($MarkDistributionSelect==1){// by GPA

				//convert string to int
				$tmp=(int)$row['TopGrade'];

				if($tmp>=0&&$tmp<=49){
					$arrGPACount[1]++;
				}
				else if($tmp>=50&&$tmp<=64){
					$arrGPACount[2]++;
				}
				else if($tmp>=65&&$tmp<=74){
					$arrGPACount[3]++;
				}
				else if($tmp>=75&&$tmp<=84){
					$arrGPACount[4]++;
				}
				else if($tmp>=85&&$tmp<=100){
					$arrGPACount[5]++;
				}
			}
			else if($MarkDistributionSelect==2){// by 10% step
				
				//convert string to int
				$tmp=(int)$row['TopGrade'];

				if($tmp>=0&&$tmp<=10){
					$arrStepCount[1]++;
				}
				else if($tmp>=11&&$tmp<=20){
					$arrStepCount[2]++;
				}
				else if($tmp>=21&&$tmp<=30){
					$arrStepCount[3]++;
				}
				else if($tmp>=31&&$tmp<=40){
					$arrStepCount[4]++;
				}
				else if($tmp>=41&&$tmp<=50){
					$arrStepCount[5]++;
				}
				else if($tmp>=51&&$tmp<=60){
					$arrStepCount[6]++;
				}
				else if($tmp>=61&&$tmp<=70){
					$arrStepCount[7]++;
				}
				else if($tmp>=71&&$tmp<=80){
					$arrStepCount[8]++;
				}
				else if($tmp>=81&&$tmp<=90){
					$arrStepCount[9]++;
				}
				else if($tmp>=91&&$tmp<=100){
					$arrStepCount[10]++;
				}
			}
		}
		mysql_close($link);

		//convert to another array that is in JSON format
		if($MarkDistributionSelect==1){// by GPA
			for ($x=1; $x<=5; $x++) {
				$arr[] = array(
					'grade'=> $arrGPA[$x],
					'count' => $arrGPACount[$x]
				);
			} 
		}
		else if($MarkDistributionSelect==2){// by 10% step
			for ($x=1; $x<=10; $x++) {
				$arr[] = array(
					'grade'=> $arrStep[$x],
					'count' => $arrStepCount[$x]
				);
			} 
		}
		return json_encode($arr);
	}

	//Load data for the chart Student Activities Overview
	public function studentActivitiesOverview($CourseName="", $from="", $to="", $order="", $ThresholdSelect="", $Threshold="")
	{
		include('../one_connection.php');
		
		$OrderBy='';
		switch ($order) {
			case 1:
				$OrderBy='';
				break;
			case 2:
				$OrderBy='ORDER BY count desc';
				break;
			case 3:
				$OrderBy='ORDER BY count asc';
				break;
		}

		$sql = "SELECT FKUserId, COUNT(  `Id` ) count
		FROM event
		WHERE CourseName='{$CourseName}' and EventTime between '{$from}' and '{$to}' and DataSourceType=1
		GROUP BY FKUserId
		HAVING count{$ThresholdSelect}{$Threshold}
		{$OrderBy}";
		$query = mysql_query($sql);
		$amount=mysql_num_rows($query);
		while($row=mysql_fetch_array($query)){
			$row['FKUserId']=str_replace('SER','',$row['FKUserId']);
			$arr[] = array(
				'name'=> $row['FKUserId'],
				'count' => $row['count'],
				'amount' => $amount
			);
		}
		mysql_close($link);
		return json_encode($arr);
	}
}
?>