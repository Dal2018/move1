<?php 
session_start();
include('controller.php');

// if there are no user logged and this page accessed - > then return to the index
if(!isset($_SESSION['u_id'])){
    echo '<script>window.location.href = "index.php";</script>';
}

// if the user clicks on save account
if(!empty($_POST['save_account'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    // then save the account
    save_account($_SESSION['u_id'],$name,$email,$pass);
}


$user = getUser($_SESSION['u_id'])[0];

// get all favorited movies from database
$favoritedMovies = getFavoritedMovies($_SESSION['u_id']);
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>MovieHunter - Account</title>
    <?php include('head.php');?>
</head>

<body>
    <!-- START PAGE SOURCE -->
    <div id="shell">
        <?php include('nav-bar.php');?>
        <div class="cl">&nbsp;</div>
        <div id="main">
            <div id="content">

                
                <div class="Registro edit" style="float:left">
                    <div class="error-message">
                        <?php if(isset($message)) { echo $message; } ?>
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="head">
                            <h2>EDIT ACCOUNT</h2>
                        </div>
                        <table class="sides" width="100%">
                            <tr>
                                <td>
                                    <table class="formTable">
                                        <tbody>
                                            <tr>
                                                <td><label for="name">Name<span class="required">*</span></label></td>
                                                <td>
                                                    <input type="text" required placeholder="Name" name="name" value="<?php echo $user['u_name'];?>">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><label for="email">Email</label><span class="required">*</span></td>
                                                <td>
                                                    <input type="text" id="email" required name="email" placeholder="Email" value="<?php echo $user['u_email'] ;?>">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><label for="pass">Password</label><span class="required">*</span></td>
                                                <td>
                                                  <input type="password" name="pass" id="pass" required placeholder="Password" value="<?php echo $user['u_pass'] ;?>">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <input type="hidden" name="mv_id" value="<?php echo $movie_id;?>">
                        <input type="submit" value="Save" name="save_account" title="Save">
                    </form>
                </div>


                <div class="head">
                    <h2>FAVORITED MOVIES</h2>
                </div>
                <?php if(empty($favoritedMovies)){
                    echo '<h3>There are no movies yet</h3>';
                } else{?>
                <div class="box">
                    <?php foreach($favoritedMovies as $id => $mv){?>
                    <div class="movie">
                        <div class="movie-image">

                            <a href="movie.php?mv_id=<?php echo $mv['mv_id'];?>">
                           <span class="play"><span class="name"><?php echo $mv['mv_name'];?></span></span> 
                          <img src="<?php echo 'mv_pics/'.$mv['mv_pic'];?>" alt="" /></a> </div>
                        <div class="rating">
                            <p>
                                <?php echo $mv['mv_name'];?>
                            </p>
                            <p>
                                <?php echo $mv['mv_year'];?>
                            </p>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="cl">&nbsp;</div>
                </div>
                <?php }?>
            </div>
            <div class="cl">&nbsp;</div>
        </div>

        <?php include('footer.php');?>


    </div>
    <!-- END PAGE SOURCE -->
</body>

</html>
