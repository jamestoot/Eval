<?php
$strPageTitle = 'Admin Login';
include("layout/header.php");
?>
    <div class="row">
      <div class="medium-6 medium-centered columns">
        <form data-abide method="post" action="login.php">
          <div class="row">
            <div class="medium-12 columns">
              <div class="row collapse">
                <div class="medium-12 columns">
                  <img src="../images/logo.png" title=""/>
                </div>
              </div>
              <div class="row collapse">
                &nbsp;
              </div>
              <div class="row collapse">
                <div class="medium-12 columns">
                  <div class="panel">
                    <h3>Admin Login</h3>
                    <p>Please fill out your details below to login:</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="medium-12 columns">
              <div class="row collapse prefix-radius">
                <div class="columns">
                  <input name="username" type="text" placeholder="Username" required>
                  <small class="error">Please fill out your username.</small>
                </div>
              </div>
              <div class="row collapse prefix-radius">
                <div class="columns">
                  <input name="password" type="password" placeholder="Password" required>
                  <small class="error">Please fill out your password.</small>
                </div>
              </div>
              <div class="row">
                <div class="medium-3 medium-offset-9 columns">
                  <input type="submit" value="Login" class="button radius small expand" />
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
<?php
include("layout/footer_js.php");
include("layout/footer.php");
?>
