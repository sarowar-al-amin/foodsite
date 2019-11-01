<?php session_start(); ?>
<?php
  if (isset($_SESSION['user_name'])) {
    header("Location: index.php");
  }
?>
<?php
  include 'php/db_fucntions.php';
  include 'php/utility_functions.php';
?>
<?php
  $search = '';
?>
<?php
    $valid = 0;
    $validate = false;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       if (isset($_POST['user_registration'])) {
         $validate = true;
       }
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <link rel="stylesheet" type= "text/css" href="css/style.css" media="screen,projection"/>
    <meta http-equiv="Content-Type" content="text/css; charset=UTF-8"/>
    <title>Astor Mediterranean</title>
  </head>
  <body>
    <div id="container">
      <div id="header">
      <h1>
        Mediterranean Food
      </h1>
      Healthy, Fresh... and Fast!
      <?php
        echo searchForm($search);  
      ?> 
      </div>
      <div id="subheader">
        <h2>User registration</h2>
        <ul id="navigation">
          <li>
           <a href="index.php"></a>
          </li>
          <li>
           <a href="about.php"></a>
          </li>
          <li>
           <a href="products.php"></a>
          </li>
          <li>
           <a href="contact.php"></a>
          </li>
        </ul>
      </div>
      <div id="content">
        <h3>User registration form</h3>
        <?php 
         if (isset($_SESSION['registration_successful'])) {
            echo "You have successfully logged in.";
            echo "<br />";
            echo "Click on the link, to go to <a href='index.php'>Home</a> page.";
            echo "<br />";
            echo "And there, you can Log In using your User Name/Password combination.";
            unset($_SESSION['registration_successful']);
        } else {?>
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
            <fieldset>
              <legend>User registration form</legend>
              <?php
               $user_name = "";
               if(isset($_POST['user_name'])) {
                $user_name = $_POST['user_name'];
               }

               $data = commonHtmlFormTag(
                   'User Name',
                   'user_name',
                   'text',
                   $user_name,
                   array('required' => true, 'max_length' => 20, 'min_lenght' => 5),
                   $validate
               );
               if($validate){
                   if($data['valid']){
                       $valid++;
                   }
               }
               echo $data['print'];
              ?>
              <br /><br />
              <?php 
               $confirm_passward = "";
               if(isset($_POST['confirm_passward'])){
                   $confirm_passward = $_POST['confirm_password'];
               }

               $data = commonHtmlFormTag(
                   'Confirm Password',
                   'comfirm_password',
                   'password',
                   $confirm_passward,
                   array('match' => $user_password),
                   $validate
               );

               if($validate){
                   if($data['valid']){
                       $valid++;
                   }
               }
               echo $data['priint'];
              ?>
              <br /><br />
              <?php
               $data = commonHtmlFormTag(
                   '',
                   'user_registration',
                   'submit',
                   'register'
               ); 
               echo $data['print'];
              ?>
              <?php
                if (isset($_SESSION['registration_error'])) {
                 echo "<br /><br />".$_SESSION['registration_error'];
                 unset($_SESSION['registration_error']);
                }
              ?>
              <br /><br />
              Click on the link to go to <a href='index.php'>home</a> page and login.

            </fieldset>
               
            </form>
        <?php } ?>
      </div>
      <?php
        if($validate){
            if($valid == 3){
                if(checkForExistingUserName($user_name)){
                    $_SESSION['registration_error'] = "<span class='error'>The provided User Name is unavailable. Enter a different User Name.</span>";
                    header("Location: register.php");
                } else{
                    if(registerUser($user_name,$user_password)){
                        $user_id = getUserIdByUserName($user_name);
                        addProfileForUserId("Unknown","Unknown","Unknown","example@domin.com", 0, $user_id);
                        $_SESSION['registration_successful'] = true;
                        header("Location: register.php");
                    } else{
                        $_SESSION['registration_error'] = "<span class='error'>Unknown problem occured. Try again.</span>";
                        header("Location: register.php");
                    }
                }
            }
        } 
      ?>
      <div id="subcontent">
       The user registration form is given on this page.
       <br /><br />
       A user can use this page to get registered, if he is not already logged in as a registered user.
      </div>
      <div id="footer">
       Small food restaurant business website.
      </div>

    </div>
  </body>
</html>