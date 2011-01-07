<?php defined('DZIT_SKIN') || die('No direct access allowed!'); global $MODEL; ?>
<div id="main">
    <script type="text/javascript">
    //<![CDATA[
        function confirmAndDeletePost(url) {
        	var result = confirm("Do you really want to delete this post?");
            if ( result ) {
                location.href = url;
            } else {
                return false;
            }
        }
    //]]>
    </script>
    <?php
        if (isset($MODEL['latestPosts']) && count($MODEL['latestPosts']) >0 ) {
            foreach ( $MODEL['latestPosts'] as $post ) {
                echo '<h1>', htmlspecialchars_decode($post->getTitle()), '</h1>';
                echo '<div class="post-body">', htmlspecialchars_decode($post->getBody()), '</div>';
                ?>
                <p class="post-footer">
                    <!--
                    <a href="index.html" class="readmore">Read more</a>
                    <a href="index.html" class="comments">Comments (7)</a>
                    -->
                    <a onclick="confirmAndDeletePost('<?php echo $post->getUrlDelete(); ?>');" href="javascript:;" class="delete">Delete</a>
                    <span class="date"><?php echo $post->getCreatedTime(); ?></span>
                </p>
                <?php
            }
        }
    ?>

