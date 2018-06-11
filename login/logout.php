<?php
    session_start();
    unset($_SESSION["username"]);
    unset($_SESSION["password"]);
    unset($_SESSION["login_status"]);
    $_SESSION["login_status"]=false;


    echo 'You have cleaned session, Please wait while we transfer you to Home Page!';
    header('Refresh: 2; URL = ../index.html');

?>
<script language="javascript">
   setTimeout(function() {
    window.location.href = "../index.html"
   }, 3000); 
</script>
