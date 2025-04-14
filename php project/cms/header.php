<?php
/**
 * Created by PhpStorm.
 * User: rmalekar
 * Date: 10/2/15
 * Time: 10:56 AM
 */
?>
<nav class="navbar navbar-default navbar-fixed-top" id="mfn-navbar">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>

            </button>

            <div>
                <a href=" " class="navbar-brand " style="padding: 0 !important; margin-right: 20px"><img class="img-responsive" style="height: 50px" src="/assets/images/logo.png"></a>
            </div>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/cms/index.php">Dashboard<span class="sr-only">(current)</span></a></li>
                <li><a href="/cms/AboutUs/">Edit About Us</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">SlideShow<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/cms/slideshow/index.php">Parent Slide Show</a></li>
                        <li><a href="/cms/slideshow/ech-slideshow-img.php">Sister Slide Show</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Activities<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/cms/Events/New">Add New Activities</a></li>
                        <li><a href="/cms/Events/addGallery.php">Add New Gallery</a></li>
                        <li><a href="/cms/Events/Update/index.php">Update Activities</a></li>
                    </ul>
                </li>
            </ul>
            <div class="dropdown" id="dropDownDonate">
                <button class="btn btn-default dropdown-toggle" type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Welcome <?php echo  $_SESSION["username"]; ?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropDownDonate">
                    <li><a href="/cms/Auth/ULogOut/index.php">logout</a></li>
                </ul>
            </div>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>