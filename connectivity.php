<?php 
define('DB_HOST', 'localhost');
 define('DB_NAME', 'attportal'); 
 define('DB_USER','root');
 define('DB_PASSWORD','');
 $con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
 $db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error()); 
  $pass = $_POST['pass'];
  $email = $_POST['user'];
 function SignIn() { 
 session_start(); //starting the session for user profile page 
 if(!empty($_POST['user'])) //checking the 'user' name which is from Sign-In.html, is it empty or have some text 
 { $query = mysql_query("SELECT * FROM user where email = '$_POST[user]' AND password = '$_POST[pass]'") or die(mysql_error());
 $row = mysql_fetch_array($query) or die(mysql_error()); 
 if(!empty($row['email']) AND !empty($row['password']))
 {
    if($row['role']=="student"){
	   $sql = "SELECT * FROM  user where email = '".$row['email']."'";	
	    $dbname = 'attportal';
	    $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,$dbname);	   
	    $result = mysqli_query($conn, $sql );
	   
	   
	   if(! $result )
	   {
		  die('Could not get data: ' . mysqli_error($conn));
	   }
	   
	   $row = mysqli_fetch_array($result);
	   $userid = $row['id'];
	   
	   $sql = "SELECT * FROM user natural join attendance where id='".$userid."'";
	   $result = mysqli_query($conn, $sql );
	   echo "<h1>Attendance portal</h1>";
	   while($row = mysqli_fetch_array($result))
		   {
			  echo "<br> <h3>{$row['email']}</h3>: "."<p> {$row['isPresent']}</p> <br> ".
				 "<p> {$row['comments']}</p> <br> ".
				 "<hr><br>";
		   }
		   
	
	   
	   
	   mysqli_close($conn);
		}
		
		else if($row['role']=="teacher"){
			 $sql = "SELECT * FROM  user where email = '".$row['email']."'";	
	    $dbname = 'attportal';
	    $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,$dbname);	   
	    $result = mysqli_query($conn, $sql );
	   
	   
	   if(! $result )
	   {
		  die('Could not get data: ' . mysqli_error($conn));
	   }
	   
	   $row = mysqli_fetch_array($result);
	   $userid = $row['id']; 
	   
	   $sql = "SELECT * FROM user where role != 'teacher'";
	   $result = mysqli_query($conn, $sql );
	   $count=0;
	   echo "<h1> Take Attendance </h1>";
	   while($row = mysqli_fetch_array($result))
		   {
			  echo " <h4>{$row['email']}</h4> "."<p> {$row['fullname']}</p>Present: <input type =\"radio\" name=\"present.$count\">  </p>Absent: <input type =\"radio\" name=\"absent.$count\"> <br><hr> ";
		   }
		   
	
	   
	   
	   mysqli_close($conn);
		}
		else{
			//redirect("login.php");
		}
 } 
 else 
 {
 echo "SORRY... YOU ENTERD WRONG ID AND PASSWORD... PLEASE RETRY...";
 }
 }
 }
 if(isset($_POST['submit'])) { SignIn(); } 

 ?>
