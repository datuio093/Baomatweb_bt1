
<!DOCTYPE html>
<html lang="en">
   
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>BT1 - BẢO MẬT WEB </title>
</head>
<body> 



<?php

// session_start();

$conn =  mysqli_connect("db", "php_docker", "password", "php_docker");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $username = $_POST["username"];
  $password = $_POST["password"];

  $sql = "SELECT * FROM users WHERE name='$username' AND password='$password'";
  $result = $conn->query($sql);


  if ($result->num_rows == 1) {
    
    $user = $result->fetch_assoc();
    $_SESSION["user_id"] = $user["id"];
    $_SESSION["username"] = $user["username"];
 
    echo "<script> window.location.href='home.php';</script>";
    exit;
  } else {
   
    $error = "Invalid username or password";
  }
}

$conn->close();
?>


<form class="container" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

  <div class="form-group ">
          <h1> Đăng Nhập </h1>
          <label for="exampleInputEmail1">Email address</label>
          <input id="username" name="username"  class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
       
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" name="password" class="form-control" id="password" placeholder="Password">
        </div>
        <div class="thongbao"></div>
        <button name="submit" type="submit" onclick="check()" class="btn btn-primary">Submit</button>
</form>


<?php if (isset($error)) { ?>
  <p class="container"><?php echo $error; ?></p>
<?php } ?>
</body> 
</html>