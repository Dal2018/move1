<?php 
session_start();
require('database.php');
$message="";

if(!empty($_POST['login'])){
    $db = Database::getInstance();
    $sql = "SELECT * FROM User WHERE u_email='" . $_POST["email"] . "' and u_pass = '". $_POST["pass"]."'";
    $result = $db->select($sql);
    if(!empty($result)) {
        $_SESSION['u_id'] = $result[0]['u_id'];
        $_SESSION['u_type'] = $result[0]['u_type'];
    } else {
        $message = "Invalid Username or Password!";
    }
}
if(!empty($_SESSION['u_id'])){
//    header("Location:index.php");
    echo '<script>window.location.href = "index.php";</script>';
    
}

?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>MovieHunter - Login</title>
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
                        <form method="post">
                            <input type="text" name="email" id="email" required placeholder="Email">
                            <input type="password" name="pass" id="password" required placeholder="Password" autocomplete="off">
                            <input type="submit" value="Login" name="login" title="Login">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include('footer.php');?>

    </div>
</body>

</html>
