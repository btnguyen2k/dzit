<?php defined('DZIT_SKIN') || die('No direct access allowed!'); global $MODEL; ?>
<div id="main">
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

