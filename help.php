<?php 
session_start();
include_once('one_connection.php');
$search = $_POST['keyword'];  

// echo $search;

global $sql;
global $result;
global $result_status;
$sql = "SELECT * FROM search WHERE title like '%$search%' or context like '%$search%' ";
$result = mysql_query($sql);
$i=0;
if ($result == false)
{
    die(mysql_error());
    $result_status = false;
}
while($row = mysql_fetch_array($result))
{
    
    // while($row[$i])
    // {
        // echo $row[$i];
        // echo "\n";
        // $i++;
        $result_status = true;
    // }
    // echo "\t";
    // $i=0;

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
    <title>Student-data Help Centre</title>
    <!-- Bootstrap Core CSS -->
    <link href="demo/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="demo/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="demo/css/simplequery.css" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="demo/vendor/morrisjs/morris.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="demo/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!--JQuery-->
    <link rel="stylesheet" href="/js/jquery-ui.min.css">
    <link rel="stylesheet" href="/js/jquery-ui.structure.min.css">
    <link rel="stylesheet" href="/js/jquery-ui.theme.min.css">
    <script type="text/javascript" src="/js/jquery-3.2.1.js"></script>
    <script src="demo/js/jquery-ui.min.js"></script>

</head>

<body>
    <script src="js/devicecheck.js"></script>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top bg-inverse" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Help Centre</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="demo/pages/help.html">Help Centre</a>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right">
            <!-- <li class="dropdown">
                <a class="dropdown-toggle" style="color:white" data-toggle="dropdown" href="#">
                    <i class="fa fa-envelope fa-fw"></i>
                    <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-messages">
                    <li>
                        <a href="#">
                            <div>
                                <strong>Name</strong>
                                <span class="pull-right text-muted">
                                    <em>Time</em>
                                </span>
                            </div>
                            <div>Message</div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a class="text-center" href="#">
                            <strong>Read All Messages</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </li> -->
            <!-- /.dropdown -->
            <!-- <li class="dropdown">
                <a class="dropdown-toggle" style="color:white" data-toggle="dropdown" href="#">
                    <i class="fa fa-tasks fa-fw"></i>
                    <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-tasks">
                   
                    <li>
                        <a href="#">
                            <div>
                                <p>
                                    <strong>Task Name</strong>
                                    <span class="pull-right text-muted">80% Complete</span>
                                </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"
                                        style="width: 80%">
                                        <span class="sr-only">80% Complete (danger)</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a class="text-center" href="#">
                            <strong>See All Tasks</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul> -->
                <!-- /.dropdown-tasks -->
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" style="color:white" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <a href="#" id='username'>username</a>
                        </li>
                        <!-- <li>
                            <a href="#">
                                <i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li> -->
                        <li class="divider"></li>
                        <li>
                            <a href="../../login/logout.php">
                                <i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
            </li>
                <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                    <form class="input-group custom-search-form" action="help.php" method="POST">
                        <input type="search" name="keyword" class="form-control" placeholder="Search...">
                        <span class="input-group-btn" input type="search">
                            <button class="btn btn-default" input type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </form>
                </li>
                        <li class="active">
                                <a href="demo/pages/index.html">
                                    <i class="fa fa-dashboard fa-fw" ></i> Dashboard</a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-bar-chart-o fa-fw"></i> Charts
                                    <span class="fa arrow"></span>
                                </a>
                                <ul class="nav nav-second-level">
                                    <!-- <li>
                                    <a href="dashboard/MoodleCharts.html">Moodle Charts</a>
                                </li>
                                <li>
                                    <a href="dashboard/WebSubmissionCharts.html">WebSubmission Charts</a>
                                </li>
                                <li>
                                    <a href="demo/pages/Moodlecharts.html"> new Moodle Charts</a>
                                </li>
                                <li>
                                    <a href="demo/pages/WebSubmissionCharts.html"> new WebSubmission Charts</a>
                                </li> -->
                                <li>
                                    <a href="demo/pages/Moodlecharts.html">Moodle Charts</a>
                                </li>
                                <li>
                                    <a href="demo/pages/WebSubmissionCharts.html">WebSubmission Charts</a>
                                </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="demo/pages/tables.html">
                                    <i class="fa fa-table fa-fw"></i> Tables</a>
                            </li>
    
                            <li>
                                <a href="#">
                                    <i class="fa fa-bar-chart-o fa-fw"></i> Simple Query
                                    <span class="fa arrow"></span>
                                </a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="demo/pages/simplequery.html"> Data Query</a>
                                    </li>
                                    <li>
                                        <a href="dashboard/CriticalQuestions.html"> Critical Questions</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-wrench fa-fw"></i>Setings
                                    <span class="fa arrow"></span>
                                </a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="https://github.com/JoeFu/mseproject/issues">Bug report</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-files-o fa-fw"></i>Survey
                                    <span class="fa arrow"></span>
                                </a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="demo/pages/survey1.html">Survey 1</a>
                                    </li>
                                    <li>
                                        <a href="demo/pages/survey2.html">Survey 2</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-lightbulb-o fa-fw"></i>About
                                    <span class="fa arrow"></span>
                                </a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="about.html">About us</a>
                                    </li>
                                    <li>
                                        <a href="privacy.html">Privacy</a>
                                    </li>
                                    <li>
                                        <a href="terms.html">Terms</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                        <li>
                            <a href="demo/pages/help.html">
                            <i class="fa fa-question fa-fw"></i> Help</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        <!--Dynamic Load Data -->
        <script type="text/javascript">
            $('#username').load('demo/backend/APIs.php?option=postName')
        </script>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Help Centre</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Help Centre
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <section class="search-box">
                                        <form id="forum-search-form" accept-charset="UTF-8" action="../../help.php" class="search" method="POST" role="help">
                                            <div class="search-match">
                                                <label for="top-search">
                                                    <input type="hidden" name="type" value="kb" />
                                                    <input type="search" id="help" name="keyword" placeholder="Enter keywords to go" autocomplete="off" x-webkit-speech />
                                                </label>
                                                <ul id="search-match-list" class="match-list"></ul>
                                            </div>
                                            <input type="submit">
                                        </form>
                                    </section>
                                </div>
                            </div>
                            <div>
                                <h2 class="page-search-title"> 
                                    <?php 
                                    if($search!=NULL)
                                    {
                                       if($result_status)
                                       {
                                        echo "Here are some results related to ";
                                        echo "<span style=\"color:pink\"\> \" $search \"</span\>";
                                       }
                                       else
                                       {
                                        echo "<span style=\"color:red\"\> Sorry, I can't find it T_T ~ </span\>";
                                       }   
                                    }
                                    else
                                    {
                                        echo "<span style=\"color:red\"\> Please Type a keyword ! </span\>";
                                    }
                                    ?>
                                </h2>
                            </div>
                            <div class="panel-body">
                                <?php 
                                if ($result_status != false && $search != NULL)
                                {
                                    $result = mysql_query($sql);
                                    while($row = mysql_fetch_array($result))
                                    {
                                        echo "
                                        <ul class= \"list-group list-group-full list-group-dividered \">
                                        <li class= \"list-group-item \">
                                            <h4>
                                                <a href= \"http://studata.tk$row[6] \"><span> $row[1]</span>
                                                |<span style= \"color: pink; \"> $search </span></a>
                                            </h4>
                                                <a class= \"search-result-link \" href= \"http://studata.tk$row[6] \" target=\"_blank\">
                                                    http://studata.tk$row[6]
                                                </a>
                                             <p><span>$row[2]</span></p>
                                        </li>
                                    </ul> 
                                        ";
                                    }
                                }
                                else
                                {
                                    echo "No Result can be shown here. ";
                                }
                                ?>
                        <nav>
                            <ul data-plugin="twbsPagination" data-total-pages="50" data-pagination-class="pagination pagination-no-border"></ul>
                        </nav>
                              
                            </div>
                        </div>
                    </div>
                    <!-- /.col-lg-6 -->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <br><br><br><br><br><br>
                    <p class="text-right"><a href="#" title="Back to Top"><i class="fa fa-arrow-up fa-3x" aria-hidden="true"></i></a></p>
                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->
            <script type="text/javascript">
             $("#forum-search-form").submit(function(){
                if($("#search").val()==""){
                    showNotice("Please enter Key Words",false);
                    return false;
                }
            });
            </script>
            <!--divider-->
            <hr class="featurette-divider">
            <!-- End features -->
            <!-- FOOTER -->
            <footer>
                <p class="text-center">&copy; 2017 Student_data Project Team. &brvbar; <a href="privacy.html">Privacy</a> &middot; <a href="terms.html">Terms</a>

                </p>
            </footer>
        </div>
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="demo/vendor/jquery/jquery.min.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="demo/vendor/bootstrap/js/bootstrap.min.js"></script>
        <!-- Metis Menu Plugin JavaScript -->
        <script src="demo/vendor/metisMenu/metisMenu.min.js"></script>
        <!-- Morris Charts JavaScript -->
        <script src="demo/vendor/raphael/raphael.min.js"></script>
        <script src="demo/vendor/morrisjs/morris.min.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="demo/js/studata-newdashboard.js"></script>

</body>

</html>





