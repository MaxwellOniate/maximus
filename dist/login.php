<?php

$pageTitle = 'Login';

require('includes/config.php');
require('includes/classes/FormSanitizer.php');
require('includes/classes/Account.php');
require('includes/classes/Constants.php');

$account = new Account($con);

if (isset($_POST['submit'])) {
  $username = FormSanitizer::sanitizeFormUsername($_POST['username']);
  $password = FormSanitizer::sanitizeFormPassword($_POST['password']);

  $success = $account->login($username, $password);

  if ($success) {

    $_SESSION['userLoggedIn'] = $username;

    header('Location: index.php');
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Maximus | Register</title>
  <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>
  <section class="main-form">
    <div class="container">
      <div class="row">

        <div class="col-md-5 py-5">
          <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

            <?php echo $account->getError(Constants::$loginFailed); ?>
            <div class="form-group">
              <input type="text" name="username" class="form-control" placeholder="Username" value="<?php $account->getInputValue('username'); ?>" required>
            </div>

            <div class="form-group">
              <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <button type="submit" name="submit" class="btn btn-success btn-block">Log In</button>
          </form>
          <hr>
          <p>Don't have an account?</p>
          <a href="register.php" class="btn btn-outline-light btn-block">Sign Up</a>
          <hr>
          <small>If you click "Log in with Facebook" and are not a Maximus user, you will be registered and you agree to Maximus's Terms & Conditions and Privacy Policy.</small>

        </div>

        <?php include('includes/features.php'); ?>

      </div>


    </div>

  </section>


  <script src="https://kit.fontawesome.com/52d1564875.js" crossorigin="anonymous"></script>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/script.js"></script>


</body>

</html>