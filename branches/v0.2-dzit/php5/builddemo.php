<?php
require_once 'utils.php';

removeTree('demo/libs/dzit');
@mkdir('demo/libs/dzit');
@mkdir('demo/libs/dzit/Ddth');
copyDir('src/Ddth', 'demo/libs/dzit/Ddth');
copy('src/index.php', 'demo/www/index.php');
?>