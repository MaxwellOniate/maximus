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

<?php require('includes/header.php'); ?>

<section class="main-form">
  <div class="container">
    <div class="row">

      <div class="col-md-5">
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


<?php require('includes/footer.php'); ?>