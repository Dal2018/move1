<?php 
session_start();
include('controller.php');

$results ='';

// if there is sumbitted form
if(!empty($_POST['search'])){
    // take the search value
    $search_value = $_POST['search_value'];
    // search in the database and get the results
    $results = search($search_value);
} else{
    // back to index
    echo '<script>window.location.href = "index.php";</script>';
}

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

        <div id="main">
            <div id="content">
                <div class="head">

                    <h2>Search Results :</h2>
                </div>

                <?php if(empty($results)){
                    echo '<h3>No results found for "'.$search_value.'"</h3>'; 
                } else {
                    ?>
                <div class="box">
                    <?php foreach($results as $id => $mv){?>
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

                <?php
                }?>
            </div>
            <div class="cl">&nbsp;</div>
        </div>


        <?php include('footer.php');?>


    </div>
    <!-- END PAGE SOURCE -->
</body>

</html>
