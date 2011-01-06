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
                <form method="post" class="search" action="#">
                    <p>
                        <input name="search_query" class="textbox" type="text" />
                        <input name="search" class="button" type="submit" value="search" />
                    </p>
                </form>
            </div>
        </div>

        <!-- menu -->
        <div id="menu">
            <ul>
                <li id="current"><a href="<?php echo $MODEL['urlHome']; ?>"><span>Home</span></a></li>
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
                <li><a href="index.html">Home</a></li>
                <li><a href="#TemplateInfo">Template Info</a></li>
                <li><a href="#SampleTags">Sample Tags</a></li>
                <li><a href="http://www.styleshout.com/">More Free Templates</a></li>
                <li><a href="http://www.dreamtemplate.com" title="Web Templates">Web Templates</a></li>
            </ul>

            <h1>Sponsors</h1>
            <ul class="sidemenu">
                <li><a href="http://www.dreamtemplate.com" title="Website Templates">DreamTemplate</a></li>
                <li><a href="http://www.themelayouts.com" title="WordPress Themes">ThemeLayouts</a></li>
                <li><a href="http://www.imhosted.com" title="Website Hosting">ImHosted.com</a></li>
                <li><a href="http://www.dreamstock.com" title="Stock Photos">DreamStock</a></li>
                <li><a href="http://www.evrsoft.com" title="Website Builder">Evrsoft</a></li>
                <li><a href="http://www.webhostingwp.com" title="Web Hosting">Web Hosting</a></li>
            </ul>

            <h1>Wise Words</h1>
            <p>&quot;Be not afraid of life. Believe that life is worth living, and your belief will help create
            the fact.&quot;</p>
            <p class="align-right">- William James</p>

            <h1>Support Styleshout</h1>
            <p>If you are interested in supporting my work and would like to contribute, you are welcome to make
            a small donation through the <a href="http://www.styleshout.com/">donate link</a> on my website - it
            will be a great help and will surely be appreciated.</p>
        </div>
        <!--End content-wrap-->
    </div>

    <!-- Footer -->
    <div id="footer">
        <p>&copy; 2010 Your Company &nbsp;&nbsp; <a href="http://www.bluewebtemplates.com/"
        title="Website Templates">website templates</a> by <a href="http://www.styleshout.com/">styleshout</a>

        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="index.html">Home</a> | <a href="index.html">Sitemap</a>
        | <a href="index.html">RSS Feed</a> | <a href="http://validator.w3.org/check/referer">XHTML</a> | <a
        href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a></p>
    </div>
    <!-- END Wrap -->
</div>
</body>
</html>