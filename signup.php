<?php 
session_start();
require('database.php');
$message="";

if(!empty($_POST['signup'])){
    $db = Database::getInstance();
    
    $name = $_POST["name"];
    $email = $_POST["email"];
    $pass = $_POST["pass"];
    $sql = "INSERT INTO `User`(`u_email`, `u_pass`, `u_name`, `u_type`) VALUES ('$email','$pass','$name',1)";

    $u_id = $db->insert_and_get_pk($sql);
    echo 'id : '.$u_id;
    if(!empty($u_id) && $u_id > 0 ) {
        $_SESSION['u_id'] = $u_id;
        $_SESSION['u_type'] = 1;
    } else {
        $message = "This email already exist!";
    }
}
if(!empty($_SESSION['u_id'])){
    echo '<script>window.location.href = "index.php";</script>';
}

?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>MovieHunter - Sign Up</title>
    <?php include('head.php');?>

</head>

<body>
    <!-- START PAGE SOURCE -->
    <div id="shell">
        <?php include('nav-bar.php');?>

        <div id="form">
            <div class="middle-wrapper">
                <div id="search">
                    <div class="Registro">
                        <div class="error-message">
                            <?php if(isset($message)) { echo $message; } ?>
                        </div>
                        <form method="post" action="">

                            <input type="text" required placeholder="Name" name="name">

                            <input type="text" id="email" required name="email" placeholder="Email">

                            <input type="password" name="pass" id="pass" required placeholder="Password">

                            <input type="submit" value="Register" name="signup" title="Register">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include('footer.php');?>

    </div>
</body>

</html>
