<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Student activity analysis" content="behaviour">
    <meta name="author" content="">
    <title>APIs Test Report</title>
</head>
<body>
<h1>This is APIs backend php test report</h1>
<p>/*****   Test Enviroment ****/</p>
<p>System: Ubuntu 17.10 </p>
<p>DataBase: Mysql 5.7.20 </p>
<p>DataBase Schema : <a href ="https://github.com/JoeFu/mseproject/blob/master/Database/studentdata_%23207.sql"></a> studentdata_#207.sql</p>

<?php
session_start();
require_once 'Service.php';
$service = new APIService;
// $option = $_GET['option'];

    //Load Activity Number API test
    $res = file_get_contents("http://www.studata.tk/demo/backend/APIs.php?option=LoadActivityNumber");
    $expect = $service->LoadActivityNumber();
    if ($res == $expect)
    {
        echo "API: LoadActivityNumber";
        echo "<br>";
        echo "PASS!";
        echo "<br>";

    }
    else
    {
        echo "API: LoadActivityNumber";
        echo "<br>";
        echo "Fail!";
        echo "<br>";
    }
    //Load Stdents Number API test
    $res = file_get_contents("http://www.studata.tk/demo/backend/APIs.php?option=LoadStudentsNumber");
    $expect = $service->LoadStudentsNumber();
    if ($res == $expect)
    {
        echo "API: LoadStudentsNumber";
        echo "<br>";
        echo "PASS!";
        echo "<br>";

    }
    else
    {
        echo "API: LoadStudentsNumber";
        echo "<br>";
        echo "Fail!";
        echo "<br>";
    }

    //Load Courses Number API test
    $res = file_get_contents("http://www.studata.tk/demo/backend/APIs.php?option=LoadCoursesNumber");
    $expect = $service->LoadCoursesNumber();
    if ($res == $expect)
    {
        echo "API: LoadCoursesNumber";
        echo "<br>";
        echo "PASS!";
        echo "<br>";

    }
    else
    {
        echo "API: LoadCoursesNumber";
        echo "<br>";
        echo "Fail!";
        echo "<br>";
    }
    //Load Courses Detail API test
    $res = file_get_contents("http://www.studata.tk/demo/backend/APIs.php?option=LoadCoursesDetail");
    $expect = $service->LoadCoursesDetail();
    if ($res == $expect)
    {
        echo "API: LoadCoursesDetail";
        echo "<br>";
        echo "PASS!";
        echo "<br>";

    }
    else
    {
        echo "API: LoadCoursesDetail";
        echo "<br>";
        echo "Fail!";
        echo "<br>";
    }
    //Load post Name API test
    $res = file_get_contents("http://www.studata.tk/demo/backend/APIs.php?option=postName");
    $expect = $service->postName();
    if ($_SESSION['username']!= NULL)
    {
        if ($res != null)
        {
            echo "API: postName";
            echo "<br>";
            echo "PASS!";
            echo "<br>";
    
        }
        else
        {
            echo "API: postName";
            echo "<br>";
            echo "Fail!";
            echo "<br>";
        }  

    }
    else
    {
        $html = '<i class="fa fa-user fa-fw"></i> ';
        $username ='<a href="../../login">Please Login</a>';
        $str = $html .$username;
        if($res == $str)
        {
            echo "API: postName";
            echo "<br>";
            echo "PASS!";
            echo "<br>";
        }
        else
        {
            echo "API: postName";
            echo "<br>";
            echo "Fail!";
            echo "<br>";

        }
    }

    //Load Name API test
    $res = file_get_contents("http://www.studata.tk/demo/backend/APIs.php?option=Name");
    $expect = $service->Name();
    if ($_SESSION['username']!= NULL)
    {
        if ($res != null)
        {
            echo "API: Name";
            echo "<br>";
            echo "PASS!";
            echo "<br>";
    
        }
        else
        {
            echo "API: Name";
            echo "<br>";
            echo "Fail!";
            echo "<br>";
        }  

    }
    else
    {
        $str = '<a href="../../login/">Please Login</a>';
        if($res == $str)
        {
            echo "API: Name";
            echo "<br>";
            echo "PASS!";
            echo "<br>";
        }
        else
        {
            echo "API: Name";
            echo "<br>";
            echo "Fail!";
            echo "<br>";

        }
    }
    $res = file_get_contents("http://www.studata.tk/demo/backend/APIs.php?option=IndexCharts");
    $expect = $service->IndexCharts();
    if ($res == $expect)
    {  
        echo "API: IndexCharts";
        echo "<br>";
        echo "PASS!";
        echo "<br>";
    }
    else
    {
        echo "API: IndexCharts";
        echo "<br>";
        echo "Fail!";
        echo "<br>";
    }
    $res = file_get_contents("http://www.studata.tk/demo/backend/APIs.php?option=xxx");
    $expect = "Invaild Request! ";
    if ($res == $expect)
    {  
        echo "API: Invaild Request";
        echo "<br>";
        echo "PASS!";
        echo "<br>";
    }
    else
    {
        echo "API: Invaild Request";
        echo "<br>";
        echo "Fail!";
        echo "<br>";
    }



// elseif($option == "")
// {
//     echo $service->IndexCharts();
// }
// else
// {
//     echo "Invaild Request! ";
// }









?>

