<?php
// require database file to access the database
require('database.php');

// feedback message when a user save form
$message ='';


function save_account($u_id,$name,$email,$pass){
    $sql = "UPDATE `User` SET `u_email`='$email',`u_pass`='$pass',`u_name`='$name' WHERE u_id =$u_id";
    $db = Database::getInstance();
    if( $db->execute($sql)){
        $GLOBALS['message'] = 'Account saved successfully!';
    }
}
function getUser($u_id){
    $sql = "SELECT * FROM User WHERE u_id = $u_id";
    $db = Database::getInstance();
    $results = $db->select($sql);
    return $results;
}

function getFavoritedMovies($u_id){
    $sql = "SELECT * FROM Movie,Favroite WHERE Movie.mv_id = Favroite.mv_id and Favroite.u_id = $u_id
";
    $db = Database::getInstance();
    $results = $db->select($sql);
    return $results;
}
function search($search_value){
    $db = Database::getInstance();
    $search_value = str_replace("'","\'",$search_value);
    $sql = "SELECT * FROM `Movie` WHERE `mv_name` LIKE '%$search_value%'  OR `mv_desc` LIKE '%$search_value%'";
    $results = $db->select($sql);
    return $results;
}
function add_to_favorite($mv_id, $u_id){
    $db = Database::getInstance();
    $sql = "INSERT INTO `Favroite`(`u_id`, `mv_id`) VALUES ($u_id,$mv_id)";
    $db->execute($sql);
}

function remove_from_favorite($mv_id, $u_id){
    $db = Database::getInstance();
    $sql = "DELETE FROM `Favroite` WHERE `u_id` = $u_id AND `mv_id` = $mv_id";
    $db->execute($sql);
}

function is_favorite($u_id,$mv_id){
    $db = Database::getInstance();
    $sql = "SELECT `u_id`, `mv_id` FROM `Favroite` WHERE `u_id` = $u_id AND `mv_id` = $mv_id";
    
    $is_fav = $db->select($sql);
    return !empty($is_fav);
    
}
function remove_query_string(){
    ?>
<script>if (location.href.match(/\?.*/) && document.referrer) {
   location.href = location.href.replace(/\?.*/, '');
}
</script>
<?php
}
function pa($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
    
}

function getCategory($id ='' , $name =''){
    $db = Database::getInstance();
    
    $sql = "SELECT * FROM Category ";
    if(!empty($id)){
        $sql .= " WHERE c_id = $id";
    }
    if(!empty($name)){
        $sql .= " WHERE c_name = '$name'";
    }
    
    $categories = $db->fetch($sql);
    while( $row = mysqli_fetch_assoc($categories)) {
        $resultset[$row['c_id']] = $row['c_name'];
    }
    
    if(!empty($id)){
        return $resultset[$id];
    }
    
    return $resultset;
}


function getMovies($id ='' , $order ='' , $limit = '' , $categ =''){
    $db = Database::getInstance();
    
    $moviesSQL = "SELECT * FROM Movie ";
    if(!empty($id)){
        $moviesSQL .= " WHERE mv_id = $id";
    } 
    if(!empty($categ)){
        $moviesSQL .= " WHERE mv_categ = $categ ";
    }
    if(!empty($order)){
        $moviesSQL .= " ORDER BY added_date $order";
    }
    if(!empty($limit)){
        $moviesSQL .= " LIMIT $limit";
    }
    
    $movies = $db->select($moviesSQL);
    
    $categories = getCategory();
    foreach($movies as $mv_id => $movie){
        $movies[$mv_id]['mv_categ_id'] = $movie['mv_categ'];
        $movies[$mv_id]['mv_categ'] = $categories[$movie['mv_categ']];
    }
    return $movies;
    
}

function actions($id){
    ?>
    <ul>
        <li><a href="?action=edit&mv_id=<?php echo $id;?>">Edit</a></li>
        <li><a onclick="return confirm('Are you sure you want to delete?')" href="?action=del&mv_id=<?php echo $id;?>">Delete</a></li>
    </ul>

    <?php
}

function manage_movies(){
    if(!isset($_GET['action']))
       return;
       
       
    switch($_GET['action']){
        case 'add':{
            show_movie_edit_form();
            break;
        }
        case 'edit' :{
            if(!isset($_GET['mv_id']))
                return;
            $movie_id = $_GET['mv_id'];
            show_movie_edit_form($movie_id);
            break;
        }
        case 'del' :{
            if(!isset($_GET['mv_id']))
                return;
            $movie_id = $_GET['mv_id'];
            delete_movie($movie_id);
            break;
        }
        default:{
            break;
        }  
    }
    
}
function delete_movie($movie_id){
    $db = Database::getInstance();
    $sql = "DELETE FROM `Movie` WHERE mv_id = $movie_id";
    if( $db->execute($sql)){
        $GLOBALS['message'] = 'Movie saved successfully!';
    }
}
function save_movie($id ='' ,$title,$year,$category,$description,$poster = ''){
    
    $db = Database::getInstance();
    $pic_name = '';
    
    if(!empty($poster) && $poster['size'] > 0 ){
        $uploadfile = 'mv_pics/' . basename($poster['name']);
        if (move_uploaded_file($poster['tmp_name'], $uploadfile)) {
            $pic_name = basename($poster['name']);
        } else {
            echo "File was not uploaded !\n";
        }
    } 
    
    if(!empty($id)){ // update movie
        $update_pic ='';
        if(!empty($pic_name)){
            $update_pic = ",`mv_pic`='$pic_name'";
        }
        $sql = "UPDATE `Movie` SET `mv_name`='$title',
                `mv_year`=$year,`mv_desc`='$description',
                `mv_categ`=$category $update_pic WHERE `mv_id`= $id";
    } else { // insert movie
        $sql = "INSERT INTO `Movie`(`mv_name`, `mv_year`, `mv_desc`, `mv_categ`, `mv_pic`) VALUES ('$title',$year,'$description',$category, '$pic_name')";
    }
    
    if( $db->execute($sql)){
        $GLOBALS['message'] = '<div class="head"><h3>Movie saved successfully!</h3></div>';
    }
}
function show_movie_edit_form($movie_id = ''){
    
    if(empty($movie_id)){
        $movie = array(
            'mv_id' =>'',
            'mv_name' =>'',
            'mv_year' =>'',
            'mv_categ_id' => 1 ,
            'mv_desc' => '',
            'mv_pic' => 'placeholder.png',
        );
    } else{
        $movie = getMovies($movie_id , null , 1 )[0];
    }
    ?>
    <div class="Registro edit" style="float:left">
            <div class="error-message">
                <?php if(isset($message)) { echo $message; } ?>
            </div>
            <form method="post" enctype="multipart/form-data" >
                <div class="head">
                    <h2>EDIT MOVIE</h2>
                </div>
                <table class="sides" width="100%">
                    <tr>
                        <td>
                            <table class="formTable">
                                <tbody>
                                    <tr>
                                        <td><label for="mv_name">Title<span class="required">*</span></label></td>
                                        <td><input type="text" name="mv_name" id="mv_name" required value="<?php echo $movie['mv_name'];?>">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><label for="mv_name">Poster</label></td>
                                        <td>
                                            <input onchange="readURL(this);" accept="image/*" type="file" name="upload_poster" id="upload_poster">
                                            <script>
                                                function readURL(input) {
                                                    if (input.files && input.files[0]) {
                                                        var reader = new FileReader();
                                                        reader.onload = function(e) {
                                                            $('#poster')
                                                                .attr('src', e.target.result);
                                                        };
                                                        reader.readAsDataURL(input.files[0]);
                                                    }
                                                }

                                            </script>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><label for="mv_categ">Category</label><span class="required">*</span></td>
                                        <td>
                                            <select name="mv_categ">
                                            <?php   
                                            $categories = getCategory();
                                            foreach($categories as $id => $name){?>
                                                  <option 
                                                    <?php if($id == $movie['mv_categ_id'])
                                                            echo 'selected';?>
                                                          value="<?php echo $id;?>">
                                                      <?php echo $name;?>
                                                  </option>
                                            <?php }?>
                                            </select>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td><label for="mv_year">Year</label><span class="required">*</span></td>
                                        <td><input type="text" name="mv_year" id="mv_year" required value="<?php echo $movie['mv_year'];?>"></td>
                                    </tr>
                                    <tr>
                                        <td><label for="mv_desc">Description</label><span class="required">*</span></td>
                                        <td><textarea rows="10" name="mv_desc" id="mv_desc" required><?php echo $movie['mv_desc'];?></textarea></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td><img name="poster" id="poster" src="<?php echo 'mv_pics'.'/'.$movie['mv_pic'];?>"></td>
                    </tr>
                </table>

                <input type="hidden" name="mv_id" value="<?php echo $movie_id;?>">
                <input type="submit" value="Save" name="save_movie" title="Save">
            </form>
        </div>
<?php }
?>
