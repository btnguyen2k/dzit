<?php defined('DZIT_SKIN') || die('No direct access allowed!'); global $MODEL; ?>
<div id="main">
    <h1>Create New Post</h1>
    <form action="<?php echo $MODEL['form']['urlSubmit']; ?>" method="post">
        <?php if (isset($MODEL['form']['errors'])) {
            echo '<p class="error">';
            foreach ($MODEL['form']['errors'] as $msg) {
                echo $msg, '<br />';
            }
            echo '</p>';
        }?>
        <p>
            <label>Title</label>
            <input name="title" value="" type="text" style="width: 470px" maxlength="128" />
            <label>Content</label>
            <textarea name="body" rows="5" style="width: 470px"></textarea>
            <br />
            <input class="button" type="submit" value="Create New Post"/>
            <input class="button" type="button" value="Cancel" onclick="location.href='<?php echo $MODEL['form']['urlCancel']; ?>';"/>
        </p>
    </form>
