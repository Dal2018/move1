<?php 
session_start();
include('controller.php');

// if the link contains no movies id then back to index
if(empty($_GET['mv_id'])){
    echo '<script>window.location.href = "index.php";</script>';
}

// if the user click on star icon
if(!empty($_GET['action'])){
    // if there is no logged user
    if(empty($_SESSION['u_id'])){
        // redirect to login page
        echo '<script>window.location.href = "login.php";</script>';
    }
    
    // if the action is
    switch($_GET['action']){
        case 'fav':{ // to favorite this movie
            
            // add this movie to this user
            add_to_favorite($_GET['mv_id'], $_SESSION['u_id']);
            break;
        }
        case 'unfav':{ // to remove this movie from favorite
            
            // remove the movie
            remove_from_favorite($_GET['mv_id'], $_SESSION['u_id']);
            break;
        }
    }
}

// get this movie details by the movie id from database 
$movie = getMovies($_GET['mv_id'],null,1)[0]; // the function will retrn an array so we will take the first index

// if this movie id is wrong and the movie was not found the redirect to the index
if(empty($movie)){
    echo '<script>window.location.href = "index.php";</script>';
}

// get 5 similar movies from this movie category
$similar_movies = getMovies(null,null,5,$movie['mv_categ_id']);
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
                    <h2>
                        <?php echo $movie['mv_name'];
                            // if the user logged in and this movie is a favorite then show filled star
                            if(!empty($_SESSION['u_id']) && is_favorite($_SESSION['u_id'],$movie['mv_id'])){?>
                        <a href="?action=unfav&mv_id=<?php echo $movie['mv_id'];?>">
                                <span class="fas fa-star"></span></a>
                           
                        <?php  // if the user is not logged in anord this movie is a not favorite then show empty star
                            } else{ 
                        ?>
                            <a href="?action=fav&mv_id=<?php echo $movie['mv_id'];?>">
                                <span class="far fa-star"></span></a>
                            <?php 
                               }
                        ?>

                    </h2>
                </div>
                <div class="Registro edit pad" style="float:left">
                    <table class="sides" width="100%">
                        <tr>
                            <td>
                                <table class="formTable" style="text-align: left;">
                                    <tbody>
                                        <tr>
                                            <td><label>Category</label></td>
                                            <td><label><?php echo getCategory($movie['mv_categ_id']);?></label></td>
                                        </tr>


                                        <tr>
                                            <td><label>Year</label></td>
                                            <td><label><?php echo $movie['mv_year'];?></label></td>
                                        </tr>
                                        <tr>
                                            <td><label>Description</label></td>
                                            <td><label><?php echo $movie['mv_desc'];?></label></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td><img name="poster" id="poster" src="<?php echo 'mv_pics'.'/'.$movie['mv_pic'];?>"></td>
                        </tr>
                    </table>
                </div>


                <?php 
                // if there are similar movies
                if(count($similar_movies) > 1){?>
                <div class="similar">
                <br><br><br><br><br><br><br>
                    
                    <div class="head">
                        <h2>SIMILAR MOVIES</h2>
                    </div>
                    <div class="box">

                        <?php foreach($similar_movies as $id => $mv){
                            if($mv['mv_id'] != $movie['mv_id']){
                        ?>
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
                        <?php }} ?>
                        <div class="cl">&nbsp;</div>
                    </div>

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
