<?php
//for displaying errors
ini_set('display_errors', 'on');
error_reporting(E_ALL);

session_start();
$servername = "localhost";
$username = "root";
$password = "mindfire";
//make connection
try {
    $conn = new PDO("mysql:host=$servername;dbname=db", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully". "</br>";
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

// Define variables and set to empty values
$nameErr = $emailErr = $phoneErr = "";
$name=$email=$phone_no="";
$error=false;

if ( isset($_POST['btn-submit']) ) {
// clean user inputs to prevent sql injection
    function test_input($data) {
        $data = trim($data);
        $data = strip_tags($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function assign_sessions($name,$email,$phone_no){
        $_SESSION['name']=$name;
        $_SESSION['email']=$email;
        $_SESSION['phone_no']=$phone_no;    
    }

    $name = test_input($_POST["my_name"]);
    $email=test_input($_POST["my_email"]);
    $phone_no=test_input($_POST["my_phone_number"]);



    //Check if name is empty
    if (empty($name)) {
        $error=true;
        $nameErr = "Name is required";
        $_SESSION['errors']['nameErr'] = $nameErr; 
        assign_sessions($name,$email,$phone_no);
        header("Location:../login.php");      
    }
    
    //Check if email is empty
    if (empty($email)) {
        $error=true;
        $emailErr = "Email is required";
        assign_sessions($name,$email,$phone_no);
        $_SESSION['errors']['emailErr'] = $emailErr;
        header("Location:../login.php");   
    }

    // check if e-mail address is well-formed
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {   
        $error=true;
        assign_sessions($name,$email,$phone_no);
        $emailErr = "Invalid email format"; 
        $_SESSION['errors']['emailErr'] = $emailErr;
        header("Location:../login.php");   
    }
    else{
        $sql = $conn->prepare("SELECT * FROM MyTable WHERE email=?");
        $sql->bindParam(1, $email);
        $sql->execute();
/*      $sql = $conn->prepare("SELECT email FROM MyTable WHERE email='$email'");
        $sql->execute();*/
        $count = $sql -> rowCount();
        // Check if email is in use
        if($count!=0){
            $error = true;
            assign_sessions($name,$email,$phone_no);
            $emailErr = "Provided Email is already in use.";
            $_SESSION['errors']['emailErr'] = $emailErr;
        }
    }

    //Check if phone number is empty
    if(empty($phone_no)){
        $error=true;
        assign_sessions($name,$email,$phone_no);
        $phoneErr="Phone number is required";
        $_SESSION['errors']['phoneErr'] = $phoneErr;
        header("Location:../login.php");   
    }

    else{
        
        // Replace spaces by empty string
        $phone_no=preg_replace('/\s+/', '',$phone_no );
        assign_sessions($name,$email,$phone_no);

        //Check phone number for length =10
        if(strlen($phone_no)!=10){
            $error=true;
            $phoneErr="Phone number should be of ten digits"; 
            $_SESSION['errors']['phoneErr'] = $phoneErr;           
            $_SESSION['errors']['length']=strlen($phone_no);
            header("Location: ../login.php");   
        }
        
    }

}

//If there is no error insert into table and  fetch data from database
if(!$error){

    try{
/*    $sql = "INSERT INTO MyTable VALUES ('$name','$email','$phone_no')";
        // use exec() because no results are returned
        $conn->exec($sql);
        echo "Inserted";*/
        // prepare and bind
        $sql = $conn->prepare("INSERT INTO MyTable  VALUES (? ,? ,?)");
        $sql->bindParam(1, $name);
        $sql->bindParam(2, $email);
        $sql->bindParam(3, $phone_no);
        $sql->execute();
    }   
    catch(PDOException $e){
        echo $sql . "<br>" . $e->getMessage();
    }

/*
$calories = 150;
$colour = 'red';
$sth = $dbh->prepare('SELECT name, colour, calories
    FROM fruit
    WHERE calories < ? AND colour = ?');
$sth->bindParam(1, $calories, PDO::PARAM_INT);
$sth->bindParam(2, $colour, PDO::PARAM_STR, 12);
$sth->execute();*/



}
$sql = $conn->prepare("SELECT * FROM MyTable WHERE email=?");
$sql->bindParam(1, $email);
$sql->execute();
/*$sql = $conn->prepare("SELECT * FROM MyTable WHERE email='$email'");
$sql->execute();*/

$row = $sql -> fetch();
echo "Name: " . $row["name"]."<br>"."  Email: " . $row["email"]. " <br>" .
"Phone Number: ". $row["PhoneNo"]. "<br>";
$conn=null;

?> 
