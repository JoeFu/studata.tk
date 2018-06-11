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
				$OrderBy='ORDER BY count desc, FKParentId desc';
				break;
			case 3:
				$OrderBy='ORDER BY count asc, FKParentId desc';
				break;
		}

		$sql = "SELECT FKUserId, COUNT(event.Id) count, FKParentId
		from event join user
		on FKUserId=user.Id
		where `CourseName`='{$SelectCourse}' and `SchoolYear`='{$SelectYear}' and `Semester`='{$SelectSemester}' and `AssignmentName`='{$SelectAssignment}' and `DataSourceType`=2 and `FKEventTypeId`=6
		GROUP BY FKParentId
		HAVING count {$OrderBy}";
		$query = mysql_query($sql);
		$amount=mysql_num_rows($query);// number of records
		while($row=mysql_fetch_array($query)){
			$row['FKParentId']=str_replace('SER','',$row['FKParentId']);// compress "USER0019" to "U0019"
			$arr[] = array(
				'FKParentId'=> $row['FKParentId'],
				'count' => $row['count'],
				'amount' => $amount
			);
		}
		mysql_close($link);
		return json_encode($arr);
		//example format of output: [{"FKParentId":"U0001","count":"5",amount":2},{"FKParentId":"U0002","count":"6",amount":2}]
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

	//get assignment name, start day and due day
	public function getAssignmentInformation($SelectCourse = "", $SelectYear="", $SelectSemester="")
	{
		include('../one_connection.php');

		//get assignment name, start day and due day
		$sql = "SELECT distinct AssignmentName, DATE_FORMAT(  `StartDate` ,  '%Y%m%d' ) startDate, DATE_FORMAT(  `DueDate` ,  '%Y%m%d' ) dueDate 
		from event
		where `CourseName`='{$SelectCourse}' and `SchoolYear`='{$SelectYear}' and `Semester`='{$SelectSemester}' and `DataSourceType`=2";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$arr[] = array(
				'AssignmentName'=> $row['AssignmentName'],
				'StartDate'=> $row['startDate'], //yyyymmdd
				'DueDate'=> $row['dueDate'] //yyyymmdd
			);
		}
		mysql_close($link);
		return json_encode($arr);
		//Example of the output format: [{"AssignmentName":"Assignment 1","StartDate":"20120101","DueDate":"20120109"},{"AssignmentName":"Assignment 2","StartDate":"20120201","DueDate":"20120209"}]
	}

	//get assignment start day and due day
	public function getAssignmentStartAndDueDay($SelectCourse = "", $SelectYear="", $SelectSemester="", $SelectAssignment="")
	{
		include('../one_connection.php');

		//get assignment name, start day and due day
		$sql = "SELECT distinct DATE_FORMAT(  `StartDate` ,  '%Y%m%d' ) startDate, DATE_FORMAT(  `DueDate` ,  '%Y%m%d' ) dueDate 
		from event
		where `CourseName`='{$SelectCourse}' and `SchoolYear`='{$SelectYear}' and `Semester`='{$SelectSemester}' and `AssignmentName`='{$SelectAssignment}' and `DataSourceType`=2";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$arr[] = array(
				'StartDate'=> $row['startDate'], //yyyymmdd
				'DueDate'=> $row['dueDate'] //yyyymmdd
			);
		}
		mysql_close($link);
		return json_encode($arr);
		//Example of the output format: [{"StartDate":"20120101","DueDate":"20120109"}]
	}

	//Load data for the chart Student Activities Overview
	public function studentActivitiesOverview($SelectCourse="", $from="", $to="", $order="", $ThresholdSelect="", $Threshold="")
	{
		include('../one_connection.php');
		
		//presentation order: alphabetical, descending, ascending
		$OrderBy='';
		switch ($order) {
			case 1:
				$OrderBy='';
				break;
			case 2:
				$OrderBy='ORDER BY count desc, FKUserId desc';
				break;
			case 3:
				$OrderBy='ORDER BY count asc, FKUserId desc';
				break;
		}

		$sql = "SELECT FKUserId, COUNT(  `Id` ) count
		FROM event
		WHERE CourseName='{$SelectCourse}' and EventTime between '{$from}' and '{$to}' and DataSourceType=1
		GROUP BY FKUserId
		HAVING count{$ThresholdSelect}{$Threshold}
		{$OrderBy}";
		$query = mysql_query($sql);
		$amount=mysql_num_rows($query);// number of records
		while($row=mysql_fetch_array($query)){
			$row['FKUserId']=str_replace('SER','',$row['FKUserId']);// compress "USER0019" to "U0019"
			$arr[] = array(
				'name'=> $row['FKUserId'],
				'count' => $row['count'],
				'amount' => $amount
			);
		}
		mysql_close($link);
		return json_encode($arr);
	}

	//Export data (CSV format) for the chart "Student Activities Overview"
	public function studentActivitiesOverviewCSV($SelectCourse="", $SelectYear="", $SelectSemester="",$from="", $to="", $order="", $ThresholdSelect="", $Threshold="")
	{
		include('../one_connection.php');

		$OrderBy='';// "order" in the sql query
		$OrderInFileName='';// "order" to be displayed in file name
		switch ($order) {
			case 1:
				$OrderBy='';
				$OrderInFileName='alpha';
				break;
			case 2:
				$OrderBy='ORDER BY count desc';
				$OrderInFileName='desc';
				break;
			case 3:
				$OrderBy='ORDER BY count asc';
				$OrderInFileName='asc';
				break;
		}

		$ThresholdSelectInFileName='';// "Threshold type to be displayed in file name
		switch ($ThresholdSelect) {
			case ">":
				$ThresholdSelectInFileName='gt';
				break;
			case ">=":
				$ThresholdSelectInFileName='get';
				break;
			case "<":
				$ThresholdSelectInFileName='lt';
				break;
			case ">=":
				$ThresholdSelectInFileName='let';
				break;
			case "=":
				$ThresholdSelectInFileName='eq';
				break;
		}

		$str = "User,Amount of activities\n"; 
		$result = mysql_query("SELECT FKUserId, COUNT(  `Id` ) count
		FROM event
		WHERE EventTime between '{$from}' and '{$to}' and CourseName='{$SelectCourse}' and DataSourceType=1  
		GROUP BY FKUserId
		HAVING count{$ThresholdSelect}{$Threshold}
		{$OrderBy}");
		while($row=mysql_fetch_array($result)) { 
			$str .= $row['FKUserId'].",".$row['count']."\n"; 
		} 
		mysql_close($link);
		$filename = $SelectCourse.$SelectYear.$SelectSemester.'StudentActivitiesOverview'.$from.'-'.$to.$ThresholdSelectInFileName.$Threshold.$OrderInFileName.'.csv'; //set file name 

		// output CSV file
		header("Content-type:text/csv"); 
		header("Content-Disposition:attachment;filename=".$filename); 
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0'); 
		header('Expires:0'); 
		header('Pragma:public'); 
		echo $str; 
		exit;
	}

	//Load data for the chart All Activities Overview
	public function allActivitiesOverview($SelectCourse="", $from="", $to="", $order="", $ThresholdSelect="", $Threshold="")
	{
		include('../one_connection.php');
		
		//presentation order: alphabetical, descending, ascending
		$OrderBy='';
		switch ($order) {
			case 1:
				$OrderBy='ORDER BY datesort asc';
				break;
			case 2:
				$OrderBy='ORDER BY count desc, datesort asc';
				break;
			case 3:
				$OrderBy='ORDER BY count asc, datesort asc';
				break;
		}

		$sql = "SELECT DATE_FORMAT(  `EventTime` ,  '%d %b %y' ) date, DATE_FORMAT(  `EventTime` ,  '%Y%m%d' ) datesort, COUNT(  `Id` ) count
		FROM event
		WHERE CourseName='{$SelectCourse}' and EventTime between '{$from}' and '{$to}' and DataSourceType=1
		GROUP BY date
		HAVING count{$ThresholdSelect}{$Threshold}
		{$OrderBy}";
		$query = mysql_query($sql);
		$amount=mysql_num_rows($query);// number of records
		while($row=mysql_fetch_array($query)){
			$arr[] = array(
				'date'=> $row['date'],
				'count' => $row['count'],
				'amount' => $amount
			);
		}
		mysql_close($link);
		return json_encode($arr);
	}

	//Export data (CSV format) for the chart "All Activities Overview"
	public function allActivitiesOverviewCSV($SelectCourse="", $SelectYear="", $SelectSemester="",$from="", $to="", $order="", $ThresholdSelect="", $Threshold="")
	{
		include('../one_connection.php');

		$OrderBy='';// "order" in the sql query
		$OrderInFileName='';// "order" to be displayed in file name
		switch ($order) {
			case 1:
				$OrderBy='ORDER BY datesort asc';
				$OrderInFileName='alpha';
				break;
			case 2:
				$OrderBy='ORDER BY count desc, datesort asc';
				$OrderInFileName='desc';
				break;
			case 3:
				$OrderBy='ORDER BY count asc, datesort asc';
				$OrderInFileName='asc';
				break;
		}

		$ThresholdSelectInFileName='';// "Threshold type to be displayed in file name
		switch ($ThresholdSelect) {
			case ">":
				$ThresholdSelectInFileName='gt';
				break;
			case ">=":
				$ThresholdSelectInFileName='get';
				break;
			case "<":
				$ThresholdSelectInFileName='lt';
				break;
			case ">=":
				$ThresholdSelectInFileName='let';
				break;
			case "=":
				$ThresholdSelectInFileName='eq';
				break;
		}

		$str = "Date,Amount of activities\n"; 
		$result = mysql_query("SELECT DATE_FORMAT(  `EventTime` ,  '%d %b %y' ) date, DATE_FORMAT(  `EventTime` ,  '%Y%m%d' ) datesort, COUNT(  `Id` ) count
		FROM event
		WHERE CourseName='{$SelectCourse}' and EventTime between '{$from}' and '{$to}' and DataSourceType=1
		GROUP BY date
		HAVING count{$ThresholdSelect}{$Threshold}
		{$OrderBy}");
		while($row=mysql_fetch_array($result)) { 
			$str .= $row['date'].",".$row['count']."\n"; 
		} 
		mysql_close($link);
		$filename = $SelectCourse.$SelectYear.$SelectSemester.'AllActivitiesOverview'.$from.'-'.$to.$ThresholdSelectInFileName.$Threshold.$OrderInFileName.'.csv'; //set file name 

		// output CSV file
		header("Content-type:text/csv"); 
		header("Content-Disposition:attachment;filename=".$filename); 
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0'); 
		header('Expires:0'); 
		header('Pragma:public'); 
		echo $str; 
		exit;
	}

	//Load data for the chart Event Names Overview
	public function eventNamesOverview($SelectCourse="", $from="", $to="", $order="", $ThresholdSelect="", $Threshold="")
	{
		include('../one_connection.php');
		
		//presentation order: alphabetical, descending, ascending
		$OrderBy='';
		switch ($order) {
			case 1:
				$OrderBy='ORDER BY Name desc';
				break;
			case 2:
				$OrderBy='ORDER BY count desc, Name desc';
				break;
			case 3:
				$OrderBy='ORDER BY count asc, Name desc';
				break;
		}

		$sql = "SELECT Name, COUNT(  `Id` ) count
		FROM event
		WHERE CourseName='{$SelectCourse}' and EventTime between '{$from}' and '{$to}' and DataSourceType=1
		GROUP BY Name
		HAVING count{$ThresholdSelect}{$Threshold}
		{$OrderBy}";
		$query = mysql_query($sql);
		$amount=mysql_num_rows($query);// number of records
		while($row=mysql_fetch_array($query)){
			$arr[] = array(
				'name'=> $row['Name'],
				'count' => $row['count'],
				'amount' => $amount
			);
		}
		mysql_close($link);
		return json_encode($arr);
	}

	//Export data (CSV format) for the chart "Event Names Overview"
	public function eventNamesOverviewCSV($SelectCourse="", $SelectYear="", $SelectSemester="",$from="", $to="", $order="", $ThresholdSelect="", $Threshold="")
	{
		include('../one_connection.php');

		$OrderBy='';// "order" in the sql query
		$OrderInFileName='';// "order" to be displayed in file name
		switch ($order) {
			case 1:
				$OrderBy='ORDER BY Name desc';
				$OrderInFileName='alpha';
				break;
			case 2:
				$OrderBy='ORDER BY count desc, Name desc';
				$OrderInFileName='desc';
				break;
			case 3:
				$OrderBy='ORDER BY count asc, Name desc';
				$OrderInFileName='asc';
				break;
		}

		$ThresholdSelectInFileName='';// "Threshold type to be displayed in file name
		switch ($ThresholdSelect) {
			case ">":
				$ThresholdSelectInFileName='gt';
				break;
			case ">=":
				$ThresholdSelectInFileName='get';
				break;
			case "<":
				$ThresholdSelectInFileName='lt';
				break;
			case ">=":
				$ThresholdSelectInFileName='let';
				break;
			case "=":
				$ThresholdSelectInFileName='eq';
				break;
		}

		$str = "Event name,Amount of activities\n"; 
		$result = mysql_query("SELECT Name, COUNT(  `Id` ) count
		FROM event
		WHERE CourseName='{$SelectCourse}' and EventTime between '{$from}' and '{$to}' and DataSourceType=1
		GROUP BY Name
		HAVING count{$ThresholdSelect}{$Threshold}
		{$OrderBy}");
		while($row=mysql_fetch_array($result)) { 
			$str .= $row['Name'].",".$row['count']."\n"; 
		} 
		mysql_close($link);
		$filename = $SelectCourse.$SelectYear.$SelectSemester.'EventNamesOverview'.$from.'-'.$to.$ThresholdSelectInFileName.$Threshold.$OrderInFileName.'.csv'; //set file name 

		// output CSV file
		header("Content-type:text/csv"); 
		header("Content-Disposition:attachment;filename=".$filename); 
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0'); 
		header('Expires:0'); 
		header('Pragma:public'); 
		echo $str; 
		exit;
	}

	//Load data for the auto-complete function of the chart Specific Event Name Overview
	public function specificEventNameOverviewAutoComplete($term="", $SelectCourse="", $from="", $to="", $ThresholdSelect="", $Threshold="")
	{
		include('../one_connection.php');

		// $in is a part of the second query, an example format of $in: (forum_view,resource_view,resource_add)
		$in='(';
		$sql = "SELECT Name, COUNT(  `Id` ) count
		FROM event
		WHERE CourseName='{$SelectCourse}' and EventTime between '{$from}' and '{$to}' and DataSourceType=1
		GROUP BY Name
		HAVING count{$ThresholdSelect}{$Threshold}";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$in.='\''.$row['Name'].'\',';
		}
		$in=rtrim($in, ",");
		$in.=')';
		
		//term is the text that user inputs
		$sql = "select distinct Name 
		from event 
		where Name LIKE '$term%' and Name in {$in}";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$result[] = array( 
		 		'label' => $row['Name'] 
			); 
		}
		mysql_close($link);
		return json_encode($result);
	}

	//Load data for the chart Specific Event Name Overview
	public function specificEventNameOverview($EventName="", $SelectCourse="", $from="", $to="", $order="", $ThresholdSelect="", $Threshold="")
	{
		include('../one_connection.php');
		
		//presentation order: alphabetical, descending, ascending
		$OrderBy='';
		switch ($order) {
			case 1:
				$OrderBy='ORDER BY datesort asc';
				break;
			case 2:
				$OrderBy='ORDER BY count desc, datesort asc';
				break;
			case 3:
				$OrderBy='ORDER BY count asc, datesort asc';
				break;
		}

		$sql = "SELECT DATE_FORMAT(  `EventTime` ,  '%d %b %y' ) date, DATE_FORMAT(  `EventTime` ,  '%Y%m%d' ) datesort, COUNT(  `Id` ) count
		FROM event
		WHERE CourseName='{$SelectCourse}' and EventTime between '{$from}' and '{$to}' and DataSourceType=1 and Name='{$EventName}'
		GROUP BY date
		HAVING count{$ThresholdSelect}{$Threshold}
		{$OrderBy}";
		$query = mysql_query($sql);
		$amount=mysql_num_rows($query);// number of records
		while($row=mysql_fetch_array($query)){
			$arr[] = array(
				'date'=> $row['date'],
				'count' => $row['count'],
				'amount' => $amount
			);
		}
		mysql_close($link);
		return json_encode($arr);
	}

	//Export data (CSV format) for the chart "Specific Event Name Overview"
	public function specificEventNameOverviewCSV($EventName="", $SelectCourse="", $SelectYear="", $SelectSemester="",$from="", $to="", $order="", $ThresholdSelect="", $Threshold="")
	{
		include('../one_connection.php');

		$OrderBy='';// "order" in the sql query
		$OrderInFileName='';// "order" to be displayed in file name
		switch ($order) {
			case 1:
				$OrderBy='ORDER BY datesort asc';
				$OrderInFileName='alpha';
				break;
			case 2:
				$OrderBy='ORDER BY count desc, datesort asc';
				$OrderInFileName='desc';
				break;
			case 3:
				$OrderBy='ORDER BY count asc, datesort asc';
				$OrderInFileName='asc';
				break;
		}

		$ThresholdSelectInFileName='';// "Threshold type to be displayed in file name
		switch ($ThresholdSelect) {
			case ">":
				$ThresholdSelectInFileName='gt';
				break;
			case ">=":
				$ThresholdSelectInFileName='get';
				break;
			case "<":
				$ThresholdSelectInFileName='lt';
				break;
			case ">=":
				$ThresholdSelectInFileName='let';
				break;
			case "=":
				$ThresholdSelectInFileName='eq';
				break;
		}

		$str = "Date,Amount of activities\n"; 
		$result = mysql_query("SELECT DATE_FORMAT(  `EventTime` ,  '%d %b %y' ) date, DATE_FORMAT(  `EventTime` ,  '%Y%m%d' ) datesort, COUNT(  `Id` ) count
		FROM event
		WHERE CourseName='{$SelectCourse}' and EventTime between '{$from}' and '{$to}' and DataSourceType=1 and Name='{$EventName}'
		GROUP BY date
		HAVING count{$ThresholdSelect}{$Threshold}
		{$OrderBy}");
		while($row=mysql_fetch_array($result)) { 
			$str .= $row['date'].",".$row['count']."\n"; 
		} 
		mysql_close($link);
		$filename = $SelectCourse.$SelectYear.$SelectSemester.$EventName.$from.'-'.$to.$ThresholdSelectInFileName.$Threshold.$OrderInFileName.'.csv'; //set file name 

		// output CSV file
		header("Content-type:text/csv"); 
		header("Content-Disposition:attachment;filename=".$filename); 
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0'); 
		header('Expires:0'); 
		header('Pragma:public'); 
		echo $str; 
		exit;
	}

	//Load data for the chart Event Contexts Overview
	public function eventContextsOverview($SelectCourse="", $from="", $to="", $order="", $ThresholdSelect="", $Threshold="")
	{
		include('../one_connection.php');
		
		//presentation order: alphabetical, descending, ascending
		$OrderBy='';
		switch ($order) {
			case 1:
				$OrderBy='ORDER BY Context desc';
				break;
			case 2:
				$OrderBy='ORDER BY count desc, Context desc';
				break;
			case 3:
				$OrderBy='ORDER BY count asc, Context desc';
				break;
		}

		$sql = "SELECT concat(`Prefix`,':',`Context`) EventContext, Context, COUNT(  `Id` ) count
		FROM event
		WHERE CourseName='{$SelectCourse}' and EventTime between '{$from}' and '{$to}' and DataSourceType=1
		GROUP BY Context
		HAVING count{$ThresholdSelect}{$Threshold}
		{$OrderBy}";
		$query = mysql_query($sql);
		$amount=mysql_num_rows($query);// number of records
		while($row=mysql_fetch_array($query)){
			$arr[] = array(
				'name'=> $row['EventContext'],
				'count' => $row['count'],
				'amount' => $amount
			);
		}
		mysql_close($link);
		return json_encode($arr);
	}

	//Export data (CSV format) for the chart "Event Contexts Overview"
	public function eventContextsOverviewCSV($SelectCourse="", $SelectYear="", $SelectSemester="",$from="", $to="", $order="", $ThresholdSelect="", $Threshold="")
	{
		include('../one_connection.php');

		$OrderBy='';// "order" in the sql query
		$OrderInFileName='';// "order" to be displayed in file name
		switch ($order) {
			case 1:
				$OrderBy='ORDER BY Context desc';
				$OrderInFileName='alpha';
				break;
			case 2:
				$OrderBy='ORDER BY count desc, Context desc';
				$OrderInFileName='desc';
				break;
			case 3:
				$OrderBy='ORDER BY count asc, Context desc';
				$OrderInFileName='asc';
				break;
		}

		$ThresholdSelectInFileName='';// "Threshold type to be displayed in file name
		switch ($ThresholdSelect) {
			case ">":
				$ThresholdSelectInFileName='gt';
				break;
			case ">=":
				$ThresholdSelectInFileName='get';
				break;
			case "<":
				$ThresholdSelectInFileName='lt';
				break;
			case ">=":
				$ThresholdSelectInFileName='let';
				break;
			case "=":
				$ThresholdSelectInFileName='eq';
				break;
		}

		$str = "Event context,Amount of activities\n"; 
		$result = mysql_query("SELECT concat(`Prefix`,':',`Context`) EventContext, Context, COUNT(  `Id` ) count
		FROM event
		WHERE CourseName='{$SelectCourse}' and EventTime between '{$from}' and '{$to}' and DataSourceType=1
		GROUP BY Context
		HAVING count{$ThresholdSelect}{$Threshold}
		{$OrderBy}");
		while($row=mysql_fetch_array($result)) { 
			$str .= str_replace(',', ' ', $row['EventContext']).",".$row['count']."\n"; 
		} 
		mysql_close($link);
		$filename = $SelectCourse.$SelectYear.$SelectSemester.'EventContextsOverview'.$from.'-'.$to.$ThresholdSelectInFileName.$Threshold.$OrderInFileName.'.csv'; //set file name 

		// output CSV file
		header("Content-type:text/csv"); 
		header("Content-Disposition:attachment;filename=".$filename); 
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0'); 
		header('Expires:0'); 
		header('Pragma:public'); 
		echo $str; 
		exit;
	}

	//Load data for the auto-complete function of the chart Specific Event Context Overview
	public function specificEventContextOverviewAutoComplete($term="", $SelectCourse="", $from="", $to="", $ThresholdSelect="", $Threshold="")
	{
		include('../one_connection.php');

		// $in is a part of the second query, an example format of $in: (' Assignment 4 - Marks, Semester 2, 2013',' News forum, Semester 2, 2012')
		$in='(';
		$sql = "SELECT Context, COUNT(  `Id` ) count
		FROM event
		WHERE CourseName='{$SelectCourse}' and EventTime between '{$from}' and '{$to}' and DataSourceType=1
		GROUP BY Context
		HAVING count{$ThresholdSelect}{$Threshold}";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$in.='\''.$row['Context'].'\',';
		}
		$in=rtrim($in, ",");
		$in.=')';
		
		//term is the text that user inputs
		$sql = "select distinct concat(`Prefix`,':',`Context`) EventContext
		from event 
		where Prefix LIKE '$term%' and Context in {$in}";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query)){
			$result[] = array( 
		 		'label' => $row['EventContext'] 
			); 
		}
		mysql_close($link);
		return json_encode($result);
	}

	//Load data for the chart Specific Event Context Overview
	public function specificEventContextOverview($EventContext="", $SelectCourse="", $from="", $to="", $order="", $ThresholdSelect="", $Threshold="")
	{
		include('../one_connection.php');
		
		//presentation order: alphabetical, descending, ascending
		$OrderBy='';
		switch ($order) {
			case 1:
				$OrderBy='ORDER BY datesort asc';
				break;
			case 2:
				$OrderBy='ORDER BY count desc, datesort asc';
				break;
			case 3:
				$OrderBy='ORDER BY count asc, datesort asc';
				break;
		}

		// break down $EventContext into two parts (one before the colon, the other after the colon)
		$arrEventContext = array();
		$arrEventContext = explode(":",$EventContext);

		$sql = "SELECT DATE_FORMAT(  `EventTime` ,  '%d %b %y' ) date, DATE_FORMAT(  `EventTime` ,  '%Y%m%d' ) datesort, COUNT(  `Id` ) count
		FROM event
		WHERE CourseName='{$SelectCourse}' and EventTime between '{$from}' and '{$to}' and DataSourceType=1 and Prefix='{$arrEventContext[0]}'and Context='{$arrEventContext[1]}'
		GROUP BY date
		HAVING count{$ThresholdSelect}{$Threshold}
		{$OrderBy}";
		$query = mysql_query($sql);
		$amount=mysql_num_rows($query);// number of records
		while($row=mysql_fetch_array($query)){
			$arr[] = array(
				'date'=> $row['date'],
				'count' => $row['count'],
				'amount' => $amount
			);
		}
		mysql_close($link);
		return json_encode($arr);
	}

	//Export data (CSV format) for the chart "Specific Event Context Overview"
	public function specificEventContextOverviewCSV($EventContext="", $SelectCourse="", $SelectYear="", $SelectSemester="",$from="", $to="", $order="", $ThresholdSelect="", $Threshold="")
	{
		include('../one_connection.php');

		$OrderBy='';// "order" in the sql query
		$OrderInFileName='';// "order" to be displayed in file name
		switch ($order) {
			case 1:
				$OrderBy='ORDER BY datesort asc';
				$OrderInFileName='alpha';
				break;
			case 2:
				$OrderBy='ORDER BY count desc, datesort asc';
				$OrderInFileName='desc';
				break;
			case 3:
				$OrderBy='ORDER BY count asc, datesort asc';
				$OrderInFileName='asc';
				break;
		}

		$ThresholdSelectInFileName='';// "Threshold type to be displayed in file name
		switch ($ThresholdSelect) {
			case ">":
				$ThresholdSelectInFileName='gt';
				break;
			case ">=":
				$ThresholdSelectInFileName='get';
				break;
			case "<":
				$ThresholdSelectInFileName='lt';
				break;
			case ">=":
				$ThresholdSelectInFileName='let';
				break;
			case "=":
				$ThresholdSelectInFileName='eq';
				break;
		}

		// break down $EventContext into two parts (one before the colon, the other after the colon)
		$arrEventContext = array();
		$arrEventContext = explode(":",$EventContext);

		$str = "Date,Amount of activities\n"; 
		$result = mysql_query("SELECT DATE_FORMAT(  `EventTime` ,  '%d %b %y' ) date, DATE_FORMAT(  `EventTime` ,  '%Y%m%d' ) datesort, COUNT(  `Id` ) count
		FROM event
		WHERE CourseName='{$SelectCourse}' and EventTime between '{$from}' and '{$to}' and DataSourceType=1 and Prefix='{$arrEventContext[0]}'and Context='{$arrEventContext[1]}'
		GROUP BY date
		HAVING count{$ThresholdSelect}{$Threshold}
		{$OrderBy}");
		while($row=mysql_fetch_array($result)) { 
			$str .= $row['date'].",".$row['count']."\n"; 
		} 
		mysql_close($link);
		$filename = $SelectCourse.$SelectYear.$SelectSemester.$EventContext." ".$from.'-'.$to.$ThresholdSelectInFileName.$Threshold.$OrderInFileName.'.csv'; //set file name 

		// output CSV file
		header("Content-type:text/csv"); 
		header("Content-Disposition:attachment;filename=".'"'.$filename.'"'); 
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0'); 
		header('Expires:0'); 
		header('Pragma:public'); 
		echo $str; 
		exit;
	}

	//Load Event Name based on course and period
	public function loadEventNameBasedOnCourseAndPeriod($SelectCourse = "", $from="", $to="")
	{
		include('../one_connection.php');
		$sql = "SELECT distinct `Name` 
		from event
		where CourseName='{$SelectCourse}' and EventTime between '{$from}' and '{$to}' and DataSourceType=1";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$arr[] = array(
				'Name'=> $row['Name'],
			);
		}
		mysql_close($link);
		return json_encode($arr);
	}

	//Load Event Context based on course and period
	public function loadEventContextBasedOnCourseAndPeriod($SelectCourse = "", $from="", $to="")
	{
		include('../one_connection.php');
		$sql = "SELECT distinct `Prefix`,`Context` 
		from event
		where CourseName='{$SelectCourse}' and EventTime between '{$from}' and '{$to}' and DataSourceType=1";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$arr[] = array(
				'Name'=> $row['Prefix'].":".$row['Context'],
			);
		}
		mysql_close($link);
		return json_encode($arr);
	}

	//Load data for Critical Question One (When user chooses event name)
	public function criticalQuestionOneEventName($SelectCourse = "", $SelectYear="", $SelectSemester="", $SelectAssignment="", $from="", $to="", $event="")
	{
		include('../one_connection.php');
		include_once('./correlation.php');

		//get the max mark of all submissions of an assignment for each user
		$sql = "select floor(max(Grade)*100/MaxGrade) TopGrade,FKUserId, FKParentId
		from event join user
		on FKUserId=user.Id
		where `CourseName`='{$SelectCourse}' and `SchoolYear`='{$SelectYear}' and `Semester`='{$SelectSemester}' and `AssignmentName`='{$SelectAssignment}' and `DataSourceType`=2 and FKEventTypeId=5
		group by FKUserId
		order by TopGrade desc";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			// compress "USER0019" to "U0019"
			$row['FKParentId']=str_replace('SER','',$row['FKParentId']);
			$arrMark[] = array(
				'FKParentId' => $row['FKParentId'], //user name
				'TopGrade' => (int)$row['TopGrade'],
				'Amount' => 0, //amount of events
				'R' => 0 //correlation coefficient
			);
		}

		$sql = "select FKUserId, COUNT(  `Id` ) count
		from event
		where `CourseName`='{$SelectCourse}' and EventTime between '{$from}' and '{$to}' and `DataSourceType`=1 and `Name`='{$event}'
		group by FKUserId
		order by count desc";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			// compress "USER0019" to "U0019"
			$row['FKUserId']=str_replace('SER','',$row['FKUserId']);
			$arrAmount[] = array(
				'FKUserId' => $row['FKUserId'],
				'count' => $row['count']
			);
			// fill in the array $arrMark with the result of the second query (link the assignment mark and the amount of events for each user)
			for ($i=0; $i<count($arrMark,0); $i++){
				if($row['FKUserId']==$arrMark[$i]['FKParentId']) {
					$arrMark[$i]['Amount']=(int)$row['count'];
				}
			}
		}//while
		mysql_close($link);

		$array1 = array();// records the column "TopGrade" of the array $arrMark 
		$array2 = array();// records the column "Amount" of the array $arrMark 
		foreach ($arrMark as $value) {
			$array1[] = $value['TopGrade'];
			$array2[] = $value['Amount'];
		}
		
		//sort $arrMark order by "Amount" desc "TopGrade" desc
		array_multisort($array2, SORT_DESC, $array1, SORT_DESC, $arrMark);

		//To calculate the Pearson Correlation Coefficient of the two arrays, simply call the  
		//external function Correlation that takes two arrays:
		$correlation = Correlation($array1, $array2);
		
		//add Pearson Correlation Coefficient to the array $arrMark
		for ($i=0; $i<count($arrMark,0); $i++) {
			$arrMark[$i]['R']=$correlation;
		}
		return json_encode($arrMark);
	}

	//Load data for Critical Question One (When user chooses event context)
	public function criticalQuestionOneEventContext($SelectCourse = "", $SelectYear="", $SelectSemester="", $SelectAssignment="", $from="", $to="", $event="")
	{
		include('../one_connection.php');
		include_once('./correlation.php');
		
		//get the max mark of all submissions of an assignment for each user
		$sql = "select floor(max(Grade)*100/MaxGrade) TopGrade,FKUserId, FKParentId
		from event join user
		on FKUserId=user.Id
		where `CourseName`='{$SelectCourse}' and `SchoolYear`='{$SelectYear}' and `Semester`='{$SelectSemester}' and `AssignmentName`='{$SelectAssignment}' and `DataSourceType`=2 and FKEventTypeId=5
		group by FKUserId
		order by TopGrade desc";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			// compress "USER0019" to "U0019"
			$row['FKParentId']=str_replace('SER','',$row['FKParentId']);
			$arrMark[] = array(
				'FKParentId' => $row['FKParentId'], //user name
				'TopGrade' => (int)$row['TopGrade'],
				'Amount' => 0, //amount of events
				'R' => 0 //correlation coefficient
			);
		}

		// break down event context into two parts (one before the colon, the other after the colon)
		$arrEventContext = array();
		$arrEventContext = explode(":",$event);

		$sql = "select FKUserId, COUNT(  `Id` ) count
		from event
		where `CourseName`='{$SelectCourse}' and EventTime between '{$from}' and '{$to}' and `DataSourceType`=1 and Prefix='{$arrEventContext[0]}'and Context='{$arrEventContext[1]}'
		group by FKUserId
		order by count desc";
		$query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			// compress "USER0019" to "U0019"
			$row['FKUserId']=str_replace('SER','',$row['FKUserId']);
			$arrAmount[] = array(
				'FKUserId' => $row['FKUserId'],
				'count' => $row['count']
			);
			// fill in the array $arrMark with the result of the second query (link the assignment mark and the amount of events for each user)
			for ($i=0; $i<count($arrMark,0); $i++){
				if($row['FKUserId']==$arrMark[$i]['FKParentId']) {
					$arrMark[$i]['Amount']=(int)$row['count'];
				}
			}
		}//while
		mysql_close($link);

		$array1 = array();// records the column "TopGrade" of the array $arrMark 
		$array2 = array();// records the column "Amount" of the array $arrMark 
		foreach ($arrMark as $value) {
			$array1[] = $value['TopGrade'];
			$array2[] = $value['Amount'];
		}
		
		//sort $arrMark order by "Amount" desc "TopGrade" desc
		array_multisort($array2, SORT_DESC, $array1, SORT_DESC, $arrMark);

		//To calculate the Pearson Correlation Coefficient of the two arrays, simply call the  
		//external function Correlation that takes two arrays:
		$correlation = Correlation($array1, $array2);
		
		//add Pearson Correlation Coefficient to the array $arrMark
		for ($i=0; $i<count($arrMark,0); $i++) {
			$arrMark[$i]['R']=$correlation;
		}
		return json_encode($arrMark);
	}
}
?>