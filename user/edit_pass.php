<!DOCTYPE html>
<html>
<head>
<!--  ?><script>alert("it works")</script>< ?php -->
</head>
<body>
<?php
  $message = '';
  //checks if save button is pressed
  if(isset($_POST['saveBtn'])){
     $db = mysqli_connect('localhost', 'root', '', 'riskories');
     //this call selects only current user from database
     $queryString = sprintf("SELECT * FROM `users` WHERE name='%s'", $_SESSION['user']);
     $res = mysqli_query($db,$queryString);
     $spec = mysqli_fetch_assoc($res);

    if(password_verify($_POST['currPass'],$spec["password"]) && ($_POST['newPass']!=='' && isset($_POST['newPass'])) && ($_POST['confirmPass']!=='' && isset($_POST['confirmPass'])) && (($_POST['newPass']) === ($_POST['confirmPass'])) ) {
      $hashed = password_hash($_POST['newPass'], PASSWORD_DEFAULT);
      $sql = sprintf(
      "UPDATE users
      SET password='%s'
      WHERE name='%s'",
      mysqli_real_escape_string($db,$hashed),
      $_SESSION['user']);
      $query = mysqli_query($db, $sql);
      $message = 'Your password has been changed';
    }
    else if(!password_verify($_POST['currPass'],$spec["password"])){
      $message = 'The wrong current password has been entered';
    }
    else if(!($_POST['newPass']!=='' && isset($_POST['newPass']))){
      $message = 'You forgot to put in a new password';
    }
    else if(!($_POST['confirmPass']!=='' && isset($_POST['confirmPass']))){
      $message = 'You forgot to retype your new password';
    }
    else /*if(isset($_POST['newPass']) !== isset($_POST['confirmPass']))*/ {
      $message = 'New password and Confirm password are not the same';
    }

  }
  echo "<p>$message</p>";
?>
<div>Please enter your current password, then enter your new password</div>
<div name="input_div">
  <form class="text-center" method="post" id="reg-form" action="">
    Old Password <input type="password" id="currPass" name = "currPass"><br>
    New Password <input type="password" id="newPass" name="newPass"><br>
    Confirm New Password <input type="password" id="confirmPass" name="confirmPass"><br>
    <input type="submit" name="saveBtn" value="Update password">
  </form>
</div>
</body>
</html>
