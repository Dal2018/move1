<div id="header">
    <h1 id="logo"><a href="index.php">MovieHunter</a></h1>
    <div id="navigation">
        <ul>
            <li><a class="active" href="index.php">HOME</a></li>
            <li><a href="all-movies.php?categ=0">ALL MOVIES</a></li>
            <?php
            // if there are a user logged in show logout and acccoutn page
            if(isset($_SESSION['u_id'])){
            ?>
                <li><a href="account.php">ACCOUNT</a></li>
                <li><a href="logout.php">LOGOUT</a></li>
                <?php
                // if the user is an admin show the dashboard link
                if($_SESSION['u_type'] == 0){?>
                    <li><a href="db.php">DASHBOARD</a></li>
                    <?php
                  }
                    }else{ // if no user
                ?>
                        <li><a href="login.php">LOGIN</a></li>
                        <li><a href="signup.php">SIGN UP</a></li>
                        <?php
                    }
              ?>

                            <li>
                                <form action="search.php" id="search-icon" method="post">
                                    <input type="search" name="search_value" placeholder="Search">
                                    <input type="submit" style="display:none" name="search">
                                </form>
                            </li>
        </ul>

    </div>
</div>
