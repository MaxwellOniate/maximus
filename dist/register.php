<?php

$pageTitle = 'Register';

require('includes/config.php');
require('includes/classes/FormSanitizer.php');
require('includes/classes/Account.php');
require('includes/classes/Constants.php');

$account = new Account($con);

if (isset($_POST['submit'])) {
  $username = FormSanitizer::sanitizeFormUsername($_POST['username']);
  $firstName = FormSanitizer::sanitizeFormString($_POST['firstName']);
  $lastName = FormSanitizer::sanitizeFormString($_POST['lastName']);
  $email = FormSanitizer::sanitizeFormEmail($_POST['email']);
  $email2 = FormSanitizer::sanitizeFormEmail($_POST['email2']);
  $password = FormSanitizer::sanitizeFormPassword($_POST['password']);
  $password2 = FormSanitizer::sanitizeFormPassword($_POST['password2']);

  $success = $account->register($username, $firstName, $lastName, $email, $email2, $password, $password2);

  if ($success) {

    $_SESSION["userLoggedIn"] = $username;

    header('Location: index.php');
  }
}


?>

<?php require('includes/header.php'); ?>

<section class="main-form">
  <div class="container">
    <div class="row">

      <div class="col-md-5 py-5">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

          <?php echo $account->getError(Constants::$usernameCharacters); ?>
          <?php echo $account->getError(Constants::$usernameTaken); ?>
          <div class="form-group">
            <input type="text" name="username" class="form-control" placeholder="Username" value="<?php $account->getInputValue('username'); ?>" required>
          </div>

          <?php echo $account->getError(Constants::$firstNameCharacters); ?>
          <div class="form-group">
            <input type="text" name="firstName" class="form-control" placeholder="First Name" value="<?php $account->getInputValue('firstName'); ?>" required>
          </div>


          <?php echo $account->getError(Constants::$lastNameCharacters); ?>
          <div class="form-group">
            <input type="text" name="lastName" class="form-control" placeholder="Last Name" value="<?php $account->getInputValue('lastName'); ?>" required>
          </div>

          <?php echo $account->getError(Constants::$emailsDontMatch); ?>
          <?php echo $account->getError(Constants::$emailInvalid); ?>
          <?php echo $account->getError(Constants::$emailTaken); ?>
          <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="Email" value="<?php $account->getInputValue('email'); ?>" required>
          </div>

          <div class="form-group">
            <input type="email" name="email2" class="form-control" placeholder="Confirm Email" value="<?php $account->getInputValue('email2'); ?>" required>
          </div>

          <?php echo $account->getError(Constants::$passwordsDontMatch); ?>
          <?php echo $account->getError(Constants::$passwordLength); ?>
          <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
          </div>

          <div class="form-group">
            <input type="password" name="password2" class="form-control" placeholder="Confirm Password" required>
          </div>

          <button type="submit" name="submit" class="btn btn-success btn-block">Sign Up</button>
        </form>
        <small>
          By clicking on Sign up, you agree to Maximus's Terms and Conditions of Use.
        </small>
        <small>
          To learn more about how Maximus collects, uses, shares and protects your personal data please read Maximus's Privacy Policy.
        </small>
        <hr>
        <p>Already have an account? <a href="login.php">Log In.</a></p>

      </div>

      <?php include('includes/features.php'); ?>

    </div>


  </div>

</section>


<?php require('includes/footer.php'); ?>