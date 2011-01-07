<?php
    defined('DZIT_CONTENT_FILE') || die('No main content defined!');
    define('DZIT_SKIN', TRUE);
    global $MODEL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title><?php echo $MODEL['site']['title']; ?></title>
    <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
    <meta name="description" content="<?php echo $MODEL['site']['description']; ?>" />
    <meta name="keywords" content="<?php echo $MODEL['site']['keywords']; ?>" />
    <base href="<?php echo $MODEL['baseUrl'].'skins/default/'; ?>" />
    <link rel="stylesheet" type="text/css" media="screen" href="images/SimpleBlog.css" />
</head>

<body>
    <!-- Wrap -->
    <div id="wrap">
        <div id="header">
            <h1 id="logo"><?php echo $MODEL['site']['name']; ?></h1>
            <h2 id="slogan"><?php echo $MODEL['site']['slogan']; ?></h2>
            <div id="searchform">
                <!--
                <form method="post" class="search" action="#">
                    <p>
                        <input name="search_query" class="textbox" type="text" />
                        <input name="search" class="button" type="submit" value="search" />
                    </p>
                </form>
                -->
            </div>
        </div>

        <!-- menu -->
        <div id="menu">
            <ul>
                <li <?php if (DZIT_CONTENT_FILE=='content_home.php') echo 'id="current"';?>><a href="<?php echo $MODEL['urlHome']; ?>"><span>Home</span></a></li>
                <li <?php if (DZIT_CONTENT_FILE=='content_createPost.php') echo 'id="current"';?>><a href="<?php echo $MODEL['urlCreatePost']; ?>"><span>Create Post</span></a></li>
                <!--
                <li><a href="index.html"><span>Archives</span></a></li>
                <li><a href="index.html"><span>Downloads</span></a></li>
                <li><a href="index.html"><span>Services</span></a></li>
                <li><a href="index.html"><span>Support</span></a></li>
                <li><a href="index.html"><span>About</span></a></li>
                -->
            </ul>
        </div>

        <!--Content Wrap -->
        <div id="content-wrap"><?php include DZIT_CONTENT_FILE; ?></div>
        <div id="sidebar">
            <h1>Sidebar Menu</h1>
            <ul class="sidemenu">
                <li><a href="http://code.google.com/p/dzit/">Dzit Framework</a></li>
                <li><a href="http://code.google.com/p/dphp/">dPHP Library</a></li>
                <li><a href="http://www.styleshout.com/">Free Web Templates</a></li>
            </ul>

            <h1><?php echo $MODEL['site']['name']; ?></h1>
            <p>A simple web-based blog to demostrate <strong>Dzit Framework</strong>.</p>
            <p>
                This application uses:
                <ul>
                    <li><strong>MySql</strong> as storage engine.</li>
                    <li><strong>dphp-dao</strong> as database access layer.</li>
                    <li><strong>dphp-commons-logging</strong> as logging system.</li>
                </ul>
            </p>
            <p>
                This application does not demonstrate:
                <ul>
                    <li>Multi-languages support.</li>
                    <li>Multi-templates support.</li>
                </ul>
            </p>
            <p>Feel free to use this demo as starting point of your Dzit Framework application.</p>
            <p><em>Displaimer: The template, <strong>SimpleBlog</strong>, is a free, W3C-compliant, CSS-based website
            template by <a target="_blank" href="http://www.styleshout.com/">styleshout.com</a>. Icons by
            <a target="_blank" href="http://www.famfamfam.com/lab/icons/silk/">famfamfam.com</a></em></p>

            <h1>Wise Words</h1>
            <p>&quot;Be not afraid of life. Believe that life is worth living, and your belief will help create
            the fact.&quot;</p>
            <p class="align-right">- William James</p>
        </div>
        <!--End content-wrap-->
    </div>

    <!-- Footer -->
    <div id="footer">
        <p>&copy; 2010 Your Company &nbsp;&nbsp; <strong>SimpleBlog</strong> template by
        <a href="http://www.styleshout.com/">styleshout</a> | <strong>Silk icons</strong>
        by <a href="http://www.famfamfam.com/lab/icons/silk/">famfamfam</a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?php echo $MODEL['urlHome']?>">Home</a>
        |
        <a href="http://validator.w3.org/check/referer">XHTML</a>
        |
        <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a></p>
    </div>
    <!-- END Wrap -->
</div>
</body>
</html>
