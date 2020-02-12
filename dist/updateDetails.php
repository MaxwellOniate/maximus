<?php

require('includes/includedFiles.php');

?>

<section id="user-details">
  <div class="container">
    <h1>Email</h1>
    <form>
      <div class="form-group">
        <span class="message"></span>
        <input type="email" name="email" class="email form-control" placeholder="New Email" value="<?php echo $userLoggedIn->getEmail();  ?>">
      </div>
      <input type="submit" name="saveDetailsBtn" class="btn btn-main btn-alt" value="Save">
    </form>
    <h1>Change Password</h1>
    <form>
      <div class="form-group">
        <span class="message"></span>
        <input type="password" name="oldPassword" class="form-control" placeholder="Current Password">
      </div>
      <div class="form-group">
        <span class="message"></span>
        <input type="password" name="password" class="form-control" placeholder="New Password">
      </div>
      <div class="form-group">
        <input type="password" name="password2" class="form-control" placeholder="Confirm New Password">
      </div>
      <input type="submit" name="savePasswordBtn" class="btn btn-main btn-alt" value="Save">
    </form>

  </div>
</section>