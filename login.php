<?php
//Start session
session_start();
?>
<html>
<head>
  <title>Login using php</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/design.css">
</head>
<body>
<div class="container outer">
  <form method="post" action="php/insert.php" data-toggle="validator" role="form">
    <div class="form-group">
      <label for="name" class="control-label">Name:</label>
      <input type="text" pattern="^[A-Za-z ]*$" placeholder="Please enter your name"       class="form-control" id="name"  name="my_name" 
              value="<?php 
                  if(isset($_SESSION['name'])){
                  echo $_SESSION['name'];
                  }
                  ?>"
              >
      <?php
      if($_SESSION['errors']['nameErr']){ 
      ?>
        <div id='alert'>
          <div class=' alert alert-danger alert-block alert-info fade in center'>
            <?php echo $_SESSION['errors']['nameErr'];?>
          </div>
        </div>
      <?php 
      }
      ?>
      <div class="help-block with-errors"></div>
    </div>
    <div class="form-group">
      <label for="email" class="control-label">Email address:</label>
      <input type="email" class="form-control" id="email" placeholder="Please enter your e-mail" name="my_email"
        value="<?php 
              if(isset($_SESSION['email'])){
              echo $_SESSION['email'];
              }
              ?>"
        >
      <?php
      if($_SESSION['errors']['emailErr']){ 
      ?>
        <div id='alert'>
          <div class=' alert alert-danger alert-block alert-info fade in center'>
            <?php echo $_SESSION['errors']['emailErr'];?>
          </div>
        </div>
      <?php 
        }
      ?>
      <div class="help-block with-errors"></div>
    </div>
    <div class="form-group">
      <label for="ph" class="control-label">Phone number:</label>
      <input  class="form-control" id="ph" placeholder="Please enter your phone number"        pattern="(\s*\d){10}\s*"  name="my_phone_number" 
              value="<?php 
                      if(isset($_SESSION['phone_no'])){
                      echo $_SESSION['phone_no'];
                      }
                      ?>"
              >
      <?php
        if($_SESSION['errors']['phoneErr']){ 
      ?>
        <div id='alert'>
          <div class=' alert alert-danger alert-block alert-info fade in center'>
            <?php echo $_SESSION['errors']['phoneErr'];?>
          </div>
        </div>
      <?php 
      }
      ?>       
      <div class="help-block with-errors" id="help" ></div>  
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-default"  name="btn-submit" class="form-control">Submit</button>
    </div>
  </form>
</div>
<?php
// remove all session variables
session_unset();

// destroy the session
session_destroy();
?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="js/validator.js"></script>
</body>
</html>