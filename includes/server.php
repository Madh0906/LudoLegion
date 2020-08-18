<?php
session_start();
// initializing variables
$user_name = "";
$phone_no    = "";
$errors = array(); 

// connect to the database and include functions
include('includes/db_connect.php');



// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $user_name = mysqli_real_escape_string($db, $_POST['user_name']);
  $phone_no = mysqli_real_escape_string($db, $_POST['phone_no']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $includes/errors array
  if (empty($user_name)) { array_push($errors, "Username is required"); }
  if (empty($phone_no)) { array_push($errors, "Role must be checked"); }
  if (empty($password)) { array_push($errors, "Password is required"); }


  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE phone_no='$phone_no' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['user_name'] === $username) {
      array_push($errors, "Username already exists");
    }

  }
  // Finally, register user if there are no includes/errors in the form
  if (count($errors) == 0) {
      
  	$query = "INSERT INTO users (user_name, phone_no, password) 
  			  VALUES('$user_name', '$phone_no', '$password')";
  	$registerQuery=mysqli_query($db, $query);
    
    if(!$registerQuery){
        die('Registration Failed');
    }
      else{
        
        echo '<script type="text/JavaScript">  
        alert("Registered successfully! Login now.."); 
        </script>'; 
        sleep(2);
       header('location: login.php');
      }
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
  $phone_no = mysqli_real_escape_string($db, $_POST['phone_no']);
  $password = mysqli_real_escape_string($db, $_POST['password']);
    
  if (empty($phone_no) || empty($password)) {
    if (empty($phone_no)) { array_push($errors, "Username is required"); }
    else if(empty($password)) { array_push($errors, "Password is required");}
  }
  else{
    //$password = md5($password); 
      
    $query = "SELECT * FROM users WHERE phone_no='$phone_no' AND password='$password'";
    $rq=array();
    $res1 = mysqli_query($db, $query);
    if (mysqli_num_rows($res1) == 1){
        while ($row=mysqli_fetch_assoc($res1)) {
        $_SESSION['userLogin']='true';
        $_SESSION['user_name']=$row['user_name'];
        $_SESSION['phone_no']=$row['phone_no'];
        }
        header('location: home.php');
    }
    else{
       array_push($errors, "Authentication Failed!"); 
    }
  }
}


if (isset($_POST['set'])) {
    
//    function to check if user have enough chips to play
    
    
    $user_name=$_SESSION['user_name'];
    $amount= mysqli_real_escape_string($db, $_POST['amount']);
    $status="Play";
    $phone_no=$_SESSION['phone_no'];
    
//    insert the values to open matches
    
    $query = "INSERT INTO open (user_name, amount, status, phone_no) 
  			  VALUES('$user_name', '$amount', '$status', '$phone_no')";
  	$setGameQuery=mysqli_query($db, $query);
    
    if(!$setGameQuery){
        die('Unable to set game now');
    }
      else{
        echo "Game set successfully";
      }   
    
}


//open matches retriving

$open = "SELECT * FROM open";
$openQuery=mysqli_query($db, $open);

//Running matches retrieving

$running = "SELECT * FROM running";
$runQuery=mysqli_query($db, $running);


//Matching players

if (isset($_POST['cancel'])) {
    $phone_no=$_SESSION['phone_no'];
    $reject = "DELETE FROM open WHERE phone_no='$phone_no'";
    mysqli_query($db, $reject);
    header('location: home.php');
}



//Accpt matches

//$phone_no=$_POST['postphone'];
//    $reject = "DELETE FROM open WHERE phone_no='$phone_no'";
//    mysqli_query($db, $reject);
//    
//    
//    $player1=$_SESSION['user_name'];
//    $amount=50;
//    $player2=$_POST['postplayer'];
//    
//    
//    $query1 = "INSERT INTO running (player1, player2, amount) 
//  			  VALUES('$player1', '$player2', '$amount')";
//  	$GameQuery=mysqli_query($db, $query1);
//    
//    if(!$GameQuery){
//        die('Unable to set game now');
//    }
//      else{
//        echo "Game set successfully";
//      } 


?>