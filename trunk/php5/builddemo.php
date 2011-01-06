<?php
require_once 'utils.php';

function buildDemo($demoApp) {
    removeTree("demo/$demoApp/libs/dzit");
    @mkdir("demo/$demoApp/libs/dzit");
    @mkdir("demo/$demoApp/libs/dzit/Dzit");
    copyDir("src/Dzit", "demo/$demoApp/libs/dzit/Dzit");
    copy("src/index.php", "demo/$demoApp/www/index.php");
}

$demoApps = Array('simpleblog');
foreach ($demoApps as $app) {
    echo "Building demo application [$app]...\n";
    buildDemo($app);
}

#removeTree('demo/libs/dzit');
#@mkdir('demo/libs/dzit');
#@mkdir('demo/libs/dzit/Dzit');
#copyDir('src/Dzit', 'demo/libs/dzit/Dzit');
#copy('src/index.php', 'demo/www/index.php');
?>
