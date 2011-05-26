<?php
define('INC_ALLOWED', 1);
include 'inc_header.php';
?>
<p>Current cookie values:</p>
<table border="1" cellpadding="4">
    <thead>
        <tr>
            <th>Key</th>
            <th>Value</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php
        global $MODEL;
        $script = $_SERVER['SCRIPT_NAME'];
        foreach ($MODEL as $key => $value) {
            echo '<tr><td>', htmlspecialchars($key), '</td><td>', htmlspecialchars($value), '</td>';
            echo "<td><a href='$script/delete?key=", urlencode($key), "'>Delete</a></td>";
            echo '</tr>';
        }
        ?>
    </tbody>
</table>

<p>Add a new value:</p>
<form method="post" action="<?php
echo "$script/add";
?>">
<table>
    <tr>
        <td>Name:</td>
        <td><input type="text" name="key"></td>
    </tr>
    <tr>
        <td>Value:</td>
        <td><input type="text" name="value"></td>
    </tr>
    <tr>
        <td colspan="2"><input type="submit" value="Add"></td>
    </tr>
</table>
</form>
<?php
include 'inc_footer.php';
