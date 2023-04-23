<?php

function auth(){
  if(!isset($_SERVER['PHP_AUTH_USER'])){
    header('HTTP/1.0 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="Basic Auth 04"');
  
    print "LOGIN was canceled.";
    exit;
  }
   
  $user = $_SERVER['PHP_AUTH_USER'];

  @$con = pg_connect("!SECRET!");
  if($con == false){
    print "Database Connection Error";
    exit;
  }

  $sql = "select pass from poisonunamepassdb where uname = '$user'";
  @$result = pg_query($sql);
  if($result == false){
    print "Database Acquisition Error";
    exit;
  }

  if(pg_num_rows($result) != 1){
    header('HTTP/1.0 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="Basic Auth 04"');
  
    print "LOGIN was canceled.";
    exit;
  } 

  $pass = pg_fetch_result($result,0,0);
  $newpass = $_SERVER['PHP_AUTH_PW'];
  if($pass != $newpass){
    header('HTTP/1.0 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="Basic Auth 04"');
  
    print "LOGIN was canceled.";
    exit;
  }
}
