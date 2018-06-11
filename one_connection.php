<?php
// Please Use This connetion only!
    /**
    * @Database Connection
    */
    date_default_timezone_set('PRC'); 
    $host="localhost";
    $db_user="root";
    $db_pass="";
    $db_name="studentdata";
    
    
    $link=mysql_connect($host,$db_user,$db_pass);
    mysql_select_db($db_name,$link);
    mysql_query("SET names UTF8");
    
    header("Content-Type: text/html; charset=utf-8");

?>
