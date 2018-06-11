<!-- This is Test file to test the backend services. -->
<?php
/** APIs is for new DashBoard, Simple Query and Report System **/
session_start();
/** AService is supporting APIs **/
// Load Activity Numbers function
class testService
{
    function testLoadActivityNumber()
    {
        include_once('one_connection.php');
        $sql = "SELECT count(*) FROM studentdata.event;";
        $query = mysql_query($sql);
        $result = mysql_fetch_array($query);
        $res = $result[0];
        if ($res <1000)
        {
            return $res;
        }
        elseif($res>1000 && $res < 1000000)
        {
            return (round($res/1000)) ." K";
        }
        else{
            return (round($res/1000000)) ." M";
        }       
        mysql_close($link);
    }
    // Load Students Numbers function
    function testLoadStudentsNumber()
    {
        include_once('one_connection.php');
        $sql = "select count(*) from event  where  FKUserId";
        $query = mysql_query($sql);
        $result = mysql_fetch_array($query);
        return $result[0];
        mysql_close($link);
    }
    //Load Load Courses Numbers function
    function testLoadCoursesNumber()
    {
        include_once('one_connection.php');
        $sql = "select count(DISTINCT CourseName) from event";
        $query = mysql_query($sql);
        $result = mysql_fetch_array($query);
        return $result[0];
    
        mysql_close($link);
    }
    function testLoadCoursesDetail()
    {
    //Load course name for the first drop down box
        include_once('one_connection.php');
        $sql = "SELECT distinct `CourseName` from event
        where CourseName is not NULL";
        $query = mysql_query($sql);
        while($row=mysql_fetch_array($query)){
        $arr[] = array(
            'CourseName'=> $row['CourseName'],
        );}
        mysql_close($link);
        return json_encode($arr);
    }
    function testpostName()
    {
        $username="";
        if($_SESSION['username']!= NULL)
        {
            $html = '<i class="fa fa-user fa-fw"></i> ';
            $username = $_SESSION['username'];
            $str = $html .$username;
            return $str;
        }
        else
        {
            $html = '<i class="fa fa-user fa-fw"></i> ';
            $username ='<a href="../../login">Please Login</a>';
            $str = $html .$username;
            return $str;
        }
    }
    function testName()
    {
        $username="";
        if($_SESSION['username']!= NULL)
        {
            $username = $_SESSION['username'];
            return $username;
        }
        else
        {
            $username ='<a href="../../login/">Please Login</a>';
            return $username;
        }
    }
    function testSearchTable($SelectCourseId="",$SelectYearId="",$SelectSemesterId="",$SelectAssignmentNameId="")
    {
        include('one_connection.php');
        $sql = "SELECT FKUserId,CourseName,SchoolYear, Semester, AssignmentName, Name, Grade, Prefix 
        FROM event 
        where CourseName='{$SelectCourseId}' and SchoolYear= '{$SelectYearId}' and Semester='{$SelectSemesterId}'and AssignmentName='{$SelectAssignmentNameId}' and DataSourceType ='1'";
        $query = mysql_query($sql);
		while($row=mysql_fetch_array($query)){
			$arr[] = array(
                'FKUserId'=> $row['FKUserId'],
                'CourseName'=> $row['CourseName'],
                'SchoolYear'=> $row['SchoolYear'],
                'Semester'=> $row['Semester'],
                'AssignmentName'=> $row['AssignmentName'],
                'Event Name'=> $row['Name'],
                'Grade'=> $row['Grade'],
                'Component'=> $row['Prefix'],               
			);
		}
		mysql_close();
		return json_encode($arr);
    }

    function testSelectYear()
    {
        include('one_connection.php');
        $sql = "SELECT distinct `SchoolYear` from event where SchoolYear is not NULL";
        $query = mysql_query($sql);
        while($row=mysql_fetch_array($query)){
        $arr[] = array(
            'SchoolYear'=> $row['SchoolYear'],
        );}
        mysql_close();
        return json_encode($arr);
    }
    function testIndexCharts()
    {
        include('one_connection.php');
        $sql = "SELECT  SchoolYear, count(Name) from event  group by SchoolYear ";
        $query =mysql_query($sql);
        while($row=mysql_fetch_array($query))
        {
            $arr[]= array(
                'SchoolYear'=> $row['SchoolYear'],
                'count'=>$row['count(Name)'],    
            );
        }
        mysql_close();
        return json_encode($arr);

    }
}// End-TestClass



//test Starts Here
function testLoadActivityNumber()
{
    require_once('Service.php');
    //require_once('APIs.php');
    include_once('one_connection.php');
    $test_service = new testService;
    $service = new APIService;
    $test = $test_service->testLoadActivityNumber();
    echo "<br>";
    echo "-----------------------------";
    echo "<br>";
    if ($test == $service->LoadActivityNumber())
    {
        echo "PASS!";
    }
    else 
    {
        echo "Fail!";
    }

}
function testLoadStudentsNumber()
{
    require_once('Service.php');
    //require_once('APIs.php');
    include_once('one_connection.php');
    $test_service = new testService;
    $service = new APIService;
    $test = $test_service->testLoadStudentsNumber();
    echo "<br>";
    echo "-----------------------------";
    echo "<br>";
    if ($test == $service->LoadStudentsNumber())
    {
        echo "PASS!";
    }
    else 
    {
        echo "Fail!";
    }
}

function testLoadCoursesNumber()
{
    require_once('Service.php');
    //require_once('APIs.php');
    include_once('one_connection.php');
    $test_service = new testService;
    $service = new APIService;
    $test = $test_service->testLoadCoursesNumber();
    echo "<br>";
    echo "-----------------------------";
    echo "<br>";
    if ($test == $service->LoadCoursesNumber())
    {
        echo "PASS!";
    }
    else 
    {
        echo "Fail!";
    }
}
function testLoadCoursesDetail()
{
    require_once('Service.php');
    //require_once('APIs.php');
    $test_service = new testService;
    $service = new APIService;
    $test = $test_service->testLoadCoursesDetail();
    echo "<br>";
    echo "-----------------------------";
    echo "<br>";
    if ($test == $service->LoadCoursesDetail())
    {
        echo "PASS!";
    }
    else 
    {
        echo "Fail!";
    }

}
function testpostName()
{
    require_once('Service.php');
    //require_once('APIs.php');
    $test_service = new testService;
    $service = new APIService;
    $test = $test_service->testpostName();
    echo "<br>";
    echo "-----------------------------";
    echo "<br>";
    if ($test == $service->postName())
    {
        echo "PASS!";
    }
    else 
    {
        echo "Fail!";
    }

}

function testName()
{
    require_once('Service.php');
    //require_once('APIs.php');
    $test_service = new testService;
    $service = new APIService;
    $test = $test_service->testName();
    echo "<br>";
    echo "-----------------------------";
    echo "<br>";
    if ($test == $service->Name())
    {
        echo "PASS!";
    }
    else 
    {
        echo "Fail!";
    }

}
function testSelectYear()
{

    require_once('Service.php');
    //require_once('APIs.php');
    $test_service = new testService;
    $service = new APIService;
    $test = $test_service->testSelectYear();
    echo "<br>";
    echo "-----------------------------";
    echo "<br>";
    if ($test == $service->SelectYear())
    {
        echo "PASS!";
    }
    else 
    {
        echo "Fail!";
    }
}
function testSearchTable()
{
    require_once('Service.php');
    //require_once('APIs.php');
    $test_service = new testService;
    $service = new APIService;
    $res = $service->SearchTable($SelectCourseId="MSE",$SelectYearId="2012",$SelectSemesterId="Semester 1",$SelectAssignmentId="Assignment 1");
    $notexpect = null;
    echo "<br>";
    echo "-----------------------------";
    echo "<br>";
    if ($res !=$notexpect)
    {
        echo "PASS!";
    }
    else 
    {
        echo "Fail!";
    }

}

function testIndexCharts()
{
    require_once('Service.php');
    //require_once('APIs.php');
    include_once('one_connection.php');
    $test_service = new testService;
    $service = new APIService;
    $test = $test_service->testIndexCharts();
    echo "<br>";
    echo "-----------------------------";
    echo "<br>";
    if ($test == $service-> IndexCharts())
    {
        echo "PASS!";
    }
    else 
    {
        echo "Fail!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Student activity analysis" content="behaviour">
    <meta name="author" content="">
    <title>Service Test Report</title>
</head>
<body>
<h1>This is Website backend php function test report</h1>
<p>/*****   Test Enviroment ****/</p>
<p>System: Ubuntu 17.10 </p>
<p>DataBase: Mysql 5.7.20 </p>
<p>DataBase Schema : <a href ="https://github.com/JoeFu/mseproject/blob/master/Database/studentdata_%23207.sql"></a> studentdata_#207.sql</p>
<li>DataBase Connection Status</li>
<p>
    <?php   
    include('one_connection.php');
    $sql = "select version();";
    $query =mysql_query($sql);
    $row=mysql_fetch_array($query);
    if ($row[0]!=null)
    {
        echo "<p style=\"color: green\"> Database connection normal </p>";
    }
    else
    {
        echo "<p style=\"color: red\"> Please check your database setup and connection !</p>";
    }
    
    ?>
</p>

<li>
    <?php
    echo "LoadActivityNumber Test";
    testLoadActivityNumber();
    ?>
</li>
<li>
    <?php
    echo "LoadStudentsNumber Test";
    testLoadStudentsNumber();
    ?>
</li>
<li>
    <?php
    echo "LoadCoursesNumber Test";
    testLoadCoursesNumber();
    ?>
</li>
<li>
    <?php
    echo "LoadCoursesDetail Test";
    testLoadCoursesDetail();
    ?>
</li>
<li>
    <?php
    echo "postName Test";
    testpostName();
    ?>
</li>
<li>
    <?php
    echo "Name Test";
    testName();
    ?>
</li>
<li>
    <?php
    echo "SelectYear Test";
    testSelectYear();
    ?>
</li>
<li>
    <?php
    echo "SearchTable Test";
    testSearchTable();
    ?>
</li>
<li>
    <?php
    echo "IndexCharts Test";
    testIndexCharts();
    ?>
</li>









</body>