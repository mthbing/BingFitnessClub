<?php
  session_start();
  $host = "localhost";
  $username = "root";
  $password = "";
  $database = "appdb";
  $message = "";
  try{
    $connect = new PDO("mysql:host=$host;dbname=$appdb", $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_POST["login"])){
      if(empty($_POST["username"]) || empty($_POST["password"]))
      {
        $message = '<label>All fields are missing!</label>';
      }
      else {
        $query = "SELECT * FROM admin WHERE username = :username AND password = :password";
        $statement = $connect->prepare($query);
        $statement->execute(
          array(
            'username' => $_POST["username"],
            'password' => $_POST["password"],
          )
        );
        $count = $statment->rowCount();
        if($count>0)
        {
          $_SESSION["username"] = $_POST["username"];
          header("location:login_success.php");
        }
        else {
          $message = '<label>Wrong Data</label>';
        }
      }
    }
  }catch(PDOException $error){
    $message = $error->getMessagae();
  }
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin LoginPage</title>
    <link rel="stylesheet" href="adminstyle.css" type="text/css">
  </head>
  <body>
    <?php
      if(isset($message))
      {
        echo '<label class="alert">.$message.</label>';
      }
     ?>
    <?php include('admin_header.php') ?>
    <?php include('admin_nav.php') ?>
    <main>
      <form class="loginform" action="index.html" method="post">
        <table>
          <tr>
            <th colspan="2">
              <h1>LoginForm</h1>
            </th>
          </tr>
          <tr>
            <td><label for="username">Username</label></td>
            <td><input type="text" name="username"></td>
          </tr>
          <tr>
            <td><label for="password1">Password</label></td>
            <td><input type="password" name="password"></td>
          </tr>
          <tr>
            <td><label for="email">Email Address</label></td>
            <td><input type="email" name="emailAddress"></td>
          </tr>
          <tr>
            <td>
              <input type="submit" name="login" value="login">
            </td>
          </tr>
        </table>
      </form>
    </main>
    <?php include('admin_footer.php') ?>
  </body>
</html>
