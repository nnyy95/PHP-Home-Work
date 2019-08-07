<?php
session_start();
require ("config.php");

try {
    $dbstart = new PDO("mysql:host=$dbHost; dbname=$dbName" ,$dbUser, $dbPass);
    $dbstart->exec("SET CHARACTER SET utf8");
    $dbstart->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die ("Error!: " . $e->getMessage() . "<br/>");
}




if (isset($_POST["btn_login"])){
    $loginName = $_POST['username'];
    $Password = $_POST['userpassword'];
     if($loginName != "" && $Password != ""){
         $query = $dbstart->prepare('SELECT UserID,PassWd FROM userlogin WHERE 
        UserID=? AND PassWd=? ');
        $query->execute(array($loginName,$Password));
        $row = $query->fetch(PDO::FETCH_BOTH);
        if($query->rowCount() > 0) {
            $_SESSION['username'] = $loginName;
            header('location:index.php');
            exit();
          } else {
            echo "帳號或密碼錯誤 請重新輸入";
          }
     }else  {
        echo "請輸入帳密";
     }
}

if(isset($_POST["btn_BackHome"])){
    header("Location: index.php");
    exit();
}

if(isset($_POST["btn_Creat"])){
    $loginName = $_POST['username'];
    $Password = $_POST['userpassword'];
    if($loginName != "" && $Password != ""){
        $query = $dbstart->prepare('SELECT UserID,PassWd FROM userlogin WHERE 
        UserID=? AND PassWd=? ');
        $query->execute(array($loginName,$Password));
        $row = $query->fetch(PDO::FETCH_BOTH);
        if($query->rowCount() <= 0) {
            $creat = $dbstart->prepare('insert into userlogin (UserID,PassWd) Values(?, ?)');
            $creat->execute(array($loginName,$Password));
            $_SESSION['username'] = $loginName;
           header('location:index.php');
           exit();
        } else {
           echo "有人使用了 請再重新輸入";
         }
    }else  {
       echo "請輸入帳密";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>XX購物網</title>
</head>
<body>
<form id="login" name="login" method="post" action="">
XX購物網會員中心<br>
帳號<br>
      <input type="text" name="username" id="username"  placeholder="請輸入帳號" ><br>
      <input type="password" name="userpassword" id="userpassword" placeholder="請輸入密碼" ><br>
      <input type="submit" name="btn_login" id="btn_login" value="登入" >
      <input type="submit" name="btn_Creat" id="btn_Creat" value="創新帳號" >
      <input type="reset" name="btn_Reset" id="btn_Reset" value="重設" >
      <input type="submit" name="btn_BackHome" id="btn_BackHome" value="回首頁" >
</form>
</body>
</html>