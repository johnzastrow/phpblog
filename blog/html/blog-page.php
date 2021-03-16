<?php
/**
 * Loads the markdown file given in the ?page query param into $markdown.
 */
require_once 'postRenderer.php';
$postSlug = $_GET['page'];
$page = 'posts/' . $postSlug;
if (file_exists($page)) {
    $markdown = file_get_contents($page);
    $pageTitle = getPostTitle($markdown);
} else {
    $markdown = "# 404 <br/> Post '$postSlug' not found 😢 ";
    $pageTitle = 'Blog post not found!';
}
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
<title><?php echo $pageTitle ?></title>


    <!--- basic page needs
    ================================================== -->
    <meta charset="utf-8">
    
    <meta name="description" content="a blog about technical topics, usually geospatial and open source software">
    <meta name="author" content="John C. Zastrow">

    <!-- mobile specific metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/prism.css">

    <!-- script
    ================================================== -->
    <script src="js/modernizr.js"></script>
    <script defer src="js/fontawesome/all.min.js"></script>
    <script src="js/prism.js"></script>
    

    <!-- favicons
    ================================================== -->
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">

</head>

<body id="top">

    <!-- preloader
    ================================================== -->
    <div id="preloader">
        <div id="loader" class="dots-fade">
            <div></div>
        </div>
    </div>

     <!-- Header
    ================================================== -->
    <header class="s-header">

        <div class="row">

            <div class="s-header__content column">
                <h1 class="s-header__logotext">
                    <a href="about.html" title="">GeoNotes</a>
                </h1>
                <p class="s-header__tagline">Like my sticky notes on the web</p>
            </div>

        </div> <!-- end row --> -->

          <nav class="s-header__nav-wrap">

            <div class="row">
                <ul class="s-header__nav">
                    <li class="current"><a href="https://northredoubt.com/blog/">Home</a></li>
                    <li><a href="about.html">About</a></li>
                </ul> <!-- end #nav -->
            </div>
          </nav> <!-- end #nav-wrap -->
         <a class="header-menu-toggle" href="#0" title="Menu"><span>Menu</span></a>
    </header> <!-- Header End -->


    <!-- Content
    ================================================== -->
    <div class="s-content">

        <div class="row">

            <div id="main" class="s-content__main large-8 column">

                <article class="entry">

                <?php echo renderMarkdown($markdown); ?>
                    
                    

                </article> <!-- end entry -->

           </div> <!-- end main -->


         

       </div> <!-- end row -->

   </div> <!-- end content-wrap -->


    <!-- Footer
    ================================================== -->
    <footer class="s-footer">

        <div class="row s-footer__top">
            <div class="column">
                <ul class="s-footer__social">
                    <li><a href="#0"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
                    <li><a href="#0"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                    <li><a href="#0"><i class="fab fa-youtube" aria-hidden="true"></i></a></li>
                    <li><a href="#0"><i class="fab fa-vimeo-v" aria-hidden="true"></i></a></li>
                    <li><a href="#0"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>
                    <li><a href="#0"><i class="fab fa-linkedin" aria-hidden="true"></i></a></li>
                    <li><a href="#0"><i class="fab fa-skype" aria-hidden="true"></i></a></li>
                </ul>
            </div>
        </div> <!-- end footer__top -->

        <div class="row s-footer__bottom">

             <div class="large-6 tab-full column">
                <div class="row">
                    <div class="large-8 tab-full column">        
                    </div>
        
                    
                </div>
            </div>

            <div class="ss-copyright">
                <span>© Copyright Keep It Simple 2019</span> 
                <span>Design by <a href="https://www.styleshout.com/">StyleShout</a></span>
            </div>

        </div> <!-- end footer__bottom -->


        

   </footer> <!-- end Footer-->


   <!-- Java Script
    ================================================== -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>