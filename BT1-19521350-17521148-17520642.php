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

    <form class="container" method="POST">
        <div class="form-group">
          <h1> Đăng Kí </h1>
          <label for="exampleInputEmail1">Email address</label>
          <input id="username" name="username"  class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
       
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" name="password" class="form-control" id="password" placeholder="Password">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Confirm Password</label>
          <input type="password" name="confirmpassword" class="form-control" id="confirmpassword" placeholder="Confirm Password">
        </div>
        <div class="thongbao"></div>
        <button name="submit" type="submit" onclick="check()" class="btn btn-primary">Submit</button>
      </form>

     <?php 
       ob_start();
      $conn =  mysqli_connect("db", "php_docker", "password", "php_docker");

      if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
      }

      // echo "Connected successfully";

      if (isset($_POST['submit'])) {
       
      
          $stmt = $conn->prepare("SELECT * FROM users WHERE name = ?");
          $stmt->bind_param("s", $_POST['username']);
          $stmt->execute();
          $result = $stmt->get_result();
        if (!isset($_POST['username']) || empty($_POST['username']) || !isset($_POST['password']) || empty($_POST['password'])) {
            echo '<p class="container">Tên đăng nhập và mật khẩu không được để trống</p>';
        }

        else if (!preg_match('/^[A-Za-z0-9_-]+$/', $_POST['username'])) {
            echo '<p class="container">Tên đăng nhập không được chứa kí tự đặc biệt trừ - và _</p>';
        }
        else if ($_POST['password'] != $_POST['confirmpassword']) {
          echo '<p class="container"> Xác nhận mật khẩu không chính xác </p>';
        }  
      

        else if ($result->num_rows > 0) {
       
          echo '<p class="container">Username already exists</p>';
        } 
     
        else{
        $sql = "INSERT INTO users (name,password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $_POST['username'], $_POST['password']);
          

        if ($stmt->execute()) {
   
          echo "<script> window.location.href='dangnhap.php';</script>";
      } else {
          // Query failed to execute
          echo "Error executing query: " . $stmt->error;
      }
    }
        
    }
     ?>

</body>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <script>
     
        function check () {
            //  event.preventDefault();
             var name = document.getElementById('username').value;
             var password = document.getElementById('password').value;

             if(!name || !password )
             {
                alert("Tên đăng nhập hoặc mật khẩu ko dc để trống")
                return false
             }

             if(!/^[A-Za-z0-9_-]+$/.test(name))
             {
                alert("Tên đăng nhập ko được chứa kí tự đặc biệt trừ - và _")
                return false
             }
            
        }
    </script>
</html>
