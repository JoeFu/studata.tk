<?php
/** AService is supporting APIs **/
// Load Activity Numbers function
class APIService
{
    function LoadActivityNumber()
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
        //echo json_encode($result[0]);
    }
    // Load Students Numbers function
    function LoadStudentsNumber()
    {
        include_once('one_connection.php');
        $sql = "select count(*) from event  where  FKUserId";
        $query = mysql_query($sql);
        $result = mysql_fetch_array($query);
        return $result[0];
        mysql_close($link);
    }
    //Load Load Courses Numbers function
    function LoadCoursesNumber()
    {
        include_once('one_connection.php');
        $sql = "select count(DISTINCT CourseName) from event";
        $query = mysql_query($sql);
        $result = mysql_fetch_array($query);
        return $result[0];
        mysql_close($link);
    }
    function LoadCoursesDetail()
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
    function postName()
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
    function Name()
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
    function SearchTable($SelectCourseId="",$SelectYearId="",$SelectSemesterId="",$SelectAssignmentNameId="")
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
		mysql_close($link);
		return json_encode($arr);
    }
    function GPAdistribute($SelectCourseId="",$SelectYearId="",$SelectSemesterId="",$SelectAssignmentNameId="")
    {
        include_once('one_connection.php');
        
    
    }
    function SelectYear()
    {
        include('one_connection.php');
        $sql = "SELECT distinct `SchoolYear` from event where SchoolYear is not NULL";
        $query = mysql_query($sql);
        while($row=mysql_fetch_array($query)){
        $arr[] = array(
            'SchoolYear'=> $row['SchoolYear'],
        );}
        mysql_close($link);
        return json_encode($arr);
    }
    function IndexCharts()
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
        mysql_close($link);
        return json_encode($arr);

    }
}



?>