<?php

require('includes/includedFiles.php');

?>

<section id="user-details">
  <div class="container">

    <div class="form">
      <h1>User Details</h1>

      <span class="user-details-message"></span>

      <div class="form-group">
        <input type="text" name="firstName" class="firstName form-control" value="<?php echo $userLoggedIn->getFirstName(); ?>" placeholder="First Name">
      </div>

      <div class="form-group">
        <input type="text" name="lastName" class="lastName form-control" value="<?php echo $userLoggedIn->getLastName(); ?>" placeholder="Last Name">
      </div>

      <div class="form-group">
        <input type="email" name="email" class="email form-control" value="<?php echo $userLoggedIn->getEmail(); ?>" placeholder="Email">
      </div>
      <div class="form-group">
        <button onclick="updateUserDetails('.firstName', '.lastName', '.email')" name="saveDetailsBtn" class="btn btn-main btn-alt">Save</button>
      </div>

    </div>

    <div class="form">
      <h1>Change Password</h1>

      <div class="form-group">
        <input type="password" name="oldPassword" class="oldPassword form-control" placeholder="Current Password">
      </div>
      <div class="form-group">
        <input type="password" name="password" class="password form-control" placeholder="New Password">
      </div>
      <div class="form-group">
        <input type="password" name="password2" class="password2 form-control" placeholder="Confirm New Password">
      </div>
      <div class="form-group">
        <button onclick="updatePassword('.oldPassword', '.password', '.password2')" name="savePasswordBtn" class="btn btn-main btn-alt">Save</button>
      </div>
    </div>


  </div>
</section>