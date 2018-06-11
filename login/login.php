<?php
ob_start();
session_start();
include('../one_connection.php');


if(!isset($_POST['submit']))
{
  exit('<a href="index.html"> Back </a>');
}
//include connection file
$username = "";
$password = "";



if(isset($_POST['username']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];
}
    if($username!="" && $password!="")
    {
        $sql = "select password from login where username = '$username' limit 1";
        $query = mysql_query($sql);
        $row = mysql_fetch_array($query);
        if($password == $row[0])
        {
            $_SESSION['username'] = $username;
            $_SESSION['login_status'] = true;
            echo $username,' Welcome!';
            echo '<script type="text/javascript"> window.location.href = "../demo/index.html";</script>';
            exit;
        } 
        else 
        {
            echo '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <meta name="description" content="">
                <meta name="author" content="">
                <link rel="icon" href="favicon.ico">
                <title>Login Failure</title>
                <!-- Bootstrap core CSS -->
                <link href="../css/bootstrap.min.css" rel="stylesheet">
                <!-- Custom styles -->
                <link href="../css/stu_data.css" rel="stylesheet">
            </head>
            <body>
            
            <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="#">Login Failure</a>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav mr-auto">
                    </ul>
                </div>
            </nav>
            <div id="404" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img class="first-slide" src="../image/404.png" alt="First slide">
                        <div class="container">
                            <div class="carousel-caption  d-md-block text-left">     
                                <h1 class="text-center">Login Failure</h1>
                                <br><br><br>
                                <h1> </h1>
                                <p class="text-center"><a class="btn btn-lg btn-warning" href="/login" role="button">Try Again</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 404 FOOTER -->
                <hr class="featurette-divider">
                <footer>
                <div id="404_footer" class="col-sm-6 offset-sm-4 col-md-8 offset-md-0 pt-3">
                    <p class="text-center">&copy; 2017 Student_data Project Team. &brvbar; <a href="../privacy.html">Privacy</a> &middot;
                    <a href="../terms.html">Terms</a></p>
                </div>
                </footer>
            </div>
            <script src="js/bootstrap.min.js"></script>
            </body>
            </html>';
            // exit('Login Fail <a href="javascript:history.back(-1);"> Back </a>Try Again');
        }
    }
    else 
    {
        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="description" content="">
            <meta name="author" content="">
            <link rel="icon" href="favicon.ico">
            <title>Login Failure</title>
            <!-- Bootstrap core CSS -->
            <link href="../css/bootstrap.min.css" rel="stylesheet">
            <!-- Custom styles -->
            <link href="../css/stu_data.css" rel="stylesheet">
        </head>
        <body>
        
        <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">Login Failure</a>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                </ul>
            </div>
        </nav>
        <div id="404" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <img class="first-slide" src="../image/404.png" alt="First slide">
                    <div class="container">
                        <div class="carousel-caption  d-md-block text-left">     
                            <h1 class="text-center">Login Failure</h1>
                            <br><br><br>
                            <h1> </h1>
                            <p class="text-center"><a class="btn btn-lg btn-warning" href="/login" role="button">Try Again</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 404 FOOTER -->
            <hr class="featurette-divider">
            <footer>
            <div id="404_footer" class="col-sm-6 offset-sm-4 col-md-8 offset-md-0 pt-3">
                <p class="text-center">&copy; 2017 Student_data Project Team. &brvbar; <a href="../privacy.html">Privacy</a> &middot;
                <a href="../terms.html">Terms</a></p>
            </div>
            </footer>
        </div>
        <script src="js/bootstrap.min.js"></script>
        </body>
        </html>';
        // exit('Login Fail <a href="javascript:history.back(-1);"> Back </a>Try Again');
    }
?>