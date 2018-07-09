<?php 
session_start();
include('controller.php');

// if the user is not an admin
// u_type = 1 for normal user
// then redirect to index
if(!isset($_SESSION['u_id']) || !isset($_SESSION['u_type']) ||  $_SESSION['u_type'] == 1){
    echo '<script>window.location.href = "index.php";</script>';
}

// if the save a movie ( by editing or add new )
if(isset($_POST['save_movie'])){
    $id = isset($_POST['mv_id'])? $_POST['mv_id'] : '';
    $title = isset($_POST['mv_name'])? $_POST['mv_name'] : '';
    $year = isset($_POST['mv_year'])? $_POST['mv_year'] : '';
    $category = isset($_POST['mv_categ'])? $_POST['mv_categ'] : '';
    $description = isset($_POST['mv_desc'])? $_POST['mv_desc'] : '';
    $poster = (isset($_FILES['upload_poster'])? $_FILES['upload_poster'] : '');
    
    // save the movie in database
    save_movie($id,$title,$year,$category,$description,$poster);
}

// get all movies to list them in the table
$movies = getMovies();
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>MovieHunter</title>

    <?php include('head.php');?>
</head>

<body>
    <!-- START PAGE SOURCE -->
    <div id="shell">
        <?php include('nav-bar.php');?>

        <div class="cl">&nbsp;</div>
        <br><br><br><br><br><br><br><br><br><br><br>
        <div id="main">
            <div id="content">

                <div class="head">
                    <h2>MANAGE MOVIES</h2>
                    <span><?php echo count($movies);?> Movie(s)</span>
                    <p class="text-right"> <a href="?action=add"><img class="icon" src="add.png"></a> </p>
                    
                </div>

                <table class="blueTable">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Year</th>
                            <th>Category</th>
                            <th>Added Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($movies as $id => $movie){ ?>
                        <tr>
                            <td>
                                <?php echo $movie['mv_name'];?>
                            </td>
                            <td>
                                <?php echo $movie['mv_desc'];?>
                            </td>
                            <td>
                                <?php echo $movie['mv_year'];?>
                            </td>
                            <td>
                                <?php echo $movie['mv_categ'];?>
                            </td>
                            <td>
                                <?php echo $movie['added_date'];?>
                            </td>
                            <td>
                             <?php actions($movie['mv_id']);?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>

                </table>

                <?php 
                echo $message;
                manage_movies(); ?>
            </div>
            <div class="cl">&nbsp;</div>
        </div>


        <?php include('footer.php');?>


    </div>
    <!-- END PAGE SOURCE -->
</body>

</html>
