<?php defined('DZIT_SKIN') || die('No direct access allowed!'); global $MODEL; ?>
<div id="main">
    <h1><?php echo $MODEL['site']['title']; ?></h1>
    <p>A simple web-based blog to demostrate <strong>Dzit Framework</strong>.</p>
    <p>
        This application uses:
        <ul>
            <li><strong>MySql</strong> as storage engine.</li>
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
    <p><em>Displaimer: <strong>SimpleBlog</strong> is a free, W3C-compliant, CSS-based website
    template by <a target="_blank" href="http://www.styleshout.com/">styleshout.com</a>.</em></p>

    <?php
        if (isset($MODEL['latestPosts']) && count($MODEL['latestPosts']) >0 ) {
            foreach ( $MODEL['latestPosts'] as $post ) {
                echo '<h1>', htmlentities($post->getTitle()), '</h1>';
                echo '<div class="post-body">', $post->getBody(), '</div>';
                ?>
                <p class="post-footer">
                    <!--
                    <a href="index.html" class="readmore">Read more</a>
                    <a href="index.html" class="comments">Comments (7)</a>
                    -->
                    <span class="date"><?php echo $post->getCreatedTime(); ?></span>
                </p>
                <?php
            }
        }
    ?>

