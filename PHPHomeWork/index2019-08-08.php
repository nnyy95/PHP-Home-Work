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

$rs ="select * from item";
$reault = $dbstart->prepare($rs);
$reault->execute();


if (isset($_POST["btn_login"])){
    header("Location: login.php");
    exit();
}
$testname = "顧客";
if(isset($_SESSION['username'])){
  $testname = $_SESSION['username'];
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
<form id="index" name="index" method="post" action="">
<?php if ($testname == "顧客"){ ?>
    <a href="login.php">會員登入</a> 
    <?php  }else  {   ?>
      <a href="loginout.php">登出</a> 
    <?php }  ?>
    <a href="shopcart.php">購物車</a><br>
商品資訊:
<?php while ($row = $reault->fetch(PDO::FETCH_ASSOC)){ 
     $ID = $row['Id'];
     $itemID = $row['ItemID'];
     $Price = $row['Price']; 
     ?>
     <table border="1">
   
     <tr>
        <td>
            商品編號: <?php echo $ID; ?>
            商品名稱: <?php echo $itemID; ?>
            商品價格: <?php echo $Price; ?>
            <input type="text" name="Quantity" id="Quantity" size="4" maxlength="4" value="1">
            <input type="submit"name="btn_Order" id="btn_Order" value="訂購">
        </td>
       </tr>
      </table> 
  <?php  } ?>
   您好. <?php echo $testname ?> .歡迎光臨
</form>
</body>
</html>