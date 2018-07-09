<?php 

// start session
session_start();

// include controller which contains all functions
include('controller.php');


// get last 8 movies order DESC ( descending ) from the database
$movies = getMovies(null,'desc' , 8);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MovieHunter</title>
<!--    include head page that contains all styles and javascript -->
<?php include('head.php');?>
</head>
<body>
<!-- START PAGE SOURCE -->
<div id="shell">
      <?php include('nav-bar.php');?>

    
    <div id="sub-navigation">
        <div class="middle-wrapper opacity">
      <div id="search">
        <form action="search.php" method="post" accept-charset="utf-8">
          <input type="text" name="search_value" placeholder="Write movie's name" id="search-field" class="blink search-field"  />
          <input type="submit" value="GO!" name="search" class="search-button" />
        </form>
      </div>
            </div>
    </div>
    
        <div class="cl">&nbsp;</div>
    
  <div id="main">
    <div id="content">
        <div class="head">
            
          <h2>LATEST TRAILERS</h2>
            
        </div>
        
        
        <?php 
        // if there are no movies in the array
        if(empty($movies)){
            echo '<h3>There are no movies yet</h3>';
        } else{?>
      <div class="box">
        
        <?php // loop through the array and print its details
               foreach($movies as $id => $mv){?>
        <div class="movie">
              <div class="movie-image"> 
                 
                  <a href="movie.php?mv_id=<?php echo $mv['mv_id'];?>">
                       <span class="play"><span class="name"><?php echo $mv['mv_name'];?></span></span> 
                      <img src="<?php echo 'mv_pics/'.$mv['mv_pic'];?>" alt="" /></a> </div>
            <div class="rating">
                <p><?php echo $mv['mv_name'];?></p>
                <p><?php echo $mv['mv_year'];?></p>
            </div>
        </div>
        <?php } ?>
        <div class="cl">&nbsp;</div>
      </div>
        <?php } ?>
    </div>
    <div class="cl">&nbsp;</div>
  </div>
    
    
    <?php include('footer.php');?>
    
  
</div>
<!-- END PAGE SOURCE -->
</body>
</html>