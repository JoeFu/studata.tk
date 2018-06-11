<?php
/** APIs is for new DashBoard, Simple Query and Report System **/
session_start();
require_once 'Service.php';
$service = new APIService;
$option = $_GET['option'];

//function selection
if($option == "LoadActivityNumber")
{
    echo $service->LoadActivityNumber();

}
elseif ($option == "LoadStudentsNumber")
{
    echo $service->LoadStudentsNumber();
}
elseif ($option == "LoadCoursesNumber")
{
    echo $service->LoadCoursesNumber();
}
elseif($option == "LoadCoursesDetail")
{
    echo $service->LoadCoursesDetail();
}
elseif($option == "postName")
{
    echo $service->postName();
}
elseif($option == "Name")
{
    echo $service->Name();
}
elseif($option == "LoadCourse")
{
    require_once '../../dashboard/service_class.php';
    include_once('one_connection.php');
    $new_service = new Service;
    echo $new_service->loadCourse();

    // echo $service->LoadCourse();
}
elseif($option == "LoadYear")
{
    $SelectCourseId = $_GET['SelectCourseId'];
    require_once '../../dashboard/service_class.php';
    include_once('one_connection.php');
    $new_service = new Service;
    echo $new_service->loadYear($SelectCourseId);
}
elseif($option == "LoadSemester")
{
    $SelectCourseId = $_GET['SelectCourseId'];
    $SelectYearId = $_GET['SelectYearId'];
    require_once '../../dashboard/service_class.php';
    include_once('one_connection.php');
    $new_service = new Service;
    echo $new_service->loadSemester($SelectCourseId, $SelectYearId);
}
elseif($option == "LoadAssignment")
{
    $SelectCourseId = $_GET['SelectCourseId'];
    $SelectYearId = $_GET['SelectYearId'];
    $SelectSemesterId= $_GET['SelectSemesterId'];
    require_once '../../dashboard/service_class.php';
    include_once('one_connection.php');
    $new_service = new Service;
    echo $new_service->loadAssignment($SelectCourseId, $SelectYearId, $SelectSemesterId);
}
elseif($option == "SelectYear")
{
    echo $service->SelectYear();
}
elseif($option == "SearchTable")
{
    $SelectCourseId = $_GET['SelectCourseId'];
    $SelectYearId = $_GET['SelectYearId'];
    $SelectSemesterId= $_GET['SelectSemesterId'];
    $SelectAssignmentId= $_GET['SelectAssignmentId'];
    echo $service->SearchTable($SelectCourseId, $SelectYearId, $SelectSemesterId, $SelectAssignmentId);
}
elseif($option == "IndexCharts")
{
    echo $service->IndexCharts();
}
else
{
    echo "Invaild Request! ";
}

?>