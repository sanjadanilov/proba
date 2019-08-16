<?php
$email = $_POST['email'];
$nameofuser = $_POST['nameofuser'];
$message = $_POST['message'];
if(!empty($email) || !empty($nameofuser) || !empty($message))
{
  $host= "localhost";
  $dbUsername = "root";
  $dbPassword = "";
  $dbname = "cyberpunk1";

  //connecting
  $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

  if(mysqli_connect_error()){
    die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
  }else{
    $SELECT = "SELECT email From forminput Where email = ? Limit 1";
    $INSERT = "INSERT Into forminput(email,nameofuser,message) values(?,?,?)";
    //prepare Statement
    $stmt = $conn->prepare($SELECT);
    $stmt -> bind_param("s", $email);
    $stmt -> execute();
    $stmt -> bind_result($email);
    $stmt -> store_result();
    $rnum = $stmt -> num_rows;

    if($rnum==0){
      $stmt -> close();
      $stmt = $conn->prepare($INSERT);
      $stmt ->bind_param("sss", $email,$nameofuser,$message);
      $stmt ->execute();
      echo "New record inserted suessfully";
    }else{
      echo"Someone already sent using this email";
    }
    $stmt -> close();
    $conn -> close();
  }
}
else{
  echo "All field are required";
  die();
}

 ?>
