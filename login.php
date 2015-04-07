<head>
    <title>Biology Questions &rsaquo; Log In</title>
    <link rel='stylesheet' id='wp-admin-css'  href='../wordpress/wp-admin/css/wp-admin.min.css?ver=3.8.1' type='text/css' media='all' />
    <link rel='stylesheet' id='buttons-css'  href='../wordpress/wp-includes/css/buttons.min.css?ver=3.8.1' type='text/css' media='all' />
    <link rel='stylesheet' id='colors-fresh-css'  href='../wordpress/wp-admin/css/colors.min.css?ver=3.8.1' type='text/css' media='all' />
    <script src="gen_validatorv4.js" type="text/javascript"></script>
</head>
<body>
    <div id='login'>
    <?php
    session_start();
    if(isset($_POST['log'])){
        //create connection    
            $con=mysqli_connect("50.62.209.111:3306", "zhlsh1113","iE9fo_97","zhlsh1113_question");
           // $con=mysqli_connect("localhost:3306", "root","qbasic","question");
            // Check connection
            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
            
        $username=$_POST['log'];
        $pwd=$_POST['pwd'];
        
        $result = mysqli_query($con,"SELECT * FROM user WHERE username='".$username."'");
        $row = mysqli_fetch_array($result);
        if($pwd==$row['pwd']){
            $_SESSION['user']=$username;
            header("Location:index.php");
        }
        else{
            header("Location:login.php?pwd=wrong");
        }
    }
    else{
    ?>
    <form name="loginform" id="loginform" action="login.php" method="post">
	<h1><a href="index.php" >Biology Questions</a></h1>
        <p>
		<label for="user_login">Username<br />
		<input type="text" name="log" id="user_login" class="input" value="" size="20" /></label>
	</p>
	<p>
		<label for="user_pass">Password<br />
		<input type="password" name="pwd" id="user_pass" class="input" value="" size="20" /></label>
	</p>
        <br>
        <?php 
        if(isset($_GET['pwd']))
        {
            if($_GET['pwd']=="wrong"){
                echo "<label> <font color='red'> Your user name or password is wrong</font></label>";
            }
        }
        ?>
	<p class="submit">
		<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="Log In" />
	</p>
    </form>
        <script>
            var frmvalidator  = new Validator("loginform");
            frmvalidator.EnableOnPageErrorDisplay();
            frmvalidator.EnableMsgsTogether();
 
            frmvalidator.addValidation("user_login","req","Please provide a username");
 
            frmvalidator.addValidation("user_pass","req","Please provide a password");
        </script>
    <?php } ?>
    </div>    
</body>

