<?php
require_once 'utils.php';

removeTree('demo/libs/dzit');
@mkdir('demo/libs/dzit');
@mkdir('demo/libs/dzit/Dzit');
copyDir('src/Dzit', 'demo/libs/dzit/Dzit');
copy('src/index.php', 'demo/www/index.php');
?>
