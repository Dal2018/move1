<?php 
session_start();
include('controller.php');

// if the user did not choose a category then show all categories movies
if(empty($_GET['categ'])){
    $_GET['categ'] = 0;
}

// get all categories
$categories = getCategory();


if($_GET['categ'] == 0){ // all movies
    $movies = getMovies();
} else{ // get all movies in this category
    $movies = getMovies(null,null,null,$_GET['categ']);
}


$categories = array_merge( array('0' => 'All'),$categories);


?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>MovieHunter - All Movies</title>
    <?php include('head.php');?>
</head>

<body>
    <!-- START PAGE SOURCE -->
    <div id="shell">
        <?php include('nav-bar.php');?>
        <div class="cl">&nbsp;</div>
        <div id="main">
            <div id="content">
                <div class="head">
                    <h2>All Movies</h2>
                </div>
                <?php 
                // if there are no movies yet
                if(empty($movies)){
                    echo '<h3>There are no movies yet</h3>';
                } else{?>
                <table class="formTable">
                    <tr>
                        <td>
                            <aside>
                                <ul class="list">                                    
                                    <?php 
                                        foreach($categories as $id => $name){
                                            $class='';
                                        if($_GET['categ'] == $id )
                                            $class = ' active';
                                        echo '<li><a class="'.$class.'"href="?categ='.$id.'">'.$name.'</a></li>';
                                    }?>
                                </ul>
                            </aside>
                        </td>
                        <td>
                            <div class="box">
                                <?php foreach($movies as $id => $mv){?>
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
                        </td>
                    </tr>
                </table>
            <?php }?>
            </div>
            <div class="cl">&nbsp;</div>
        </div>

        <?php include('footer.php');?>


    </div>
    <!-- END PAGE SOURCE -->
</body>

</html>
