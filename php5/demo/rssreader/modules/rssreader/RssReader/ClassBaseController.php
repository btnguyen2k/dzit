<?php
class RssReader_BaseController implements Dzit_IController {

    /**
     *
     * @see Dzit_IController::execute()
     */
    public function execute($module, $action) {
        $this->printPageHeader();

        $defaultRss = 'http://feeds.bbci.co.uk/sport/0/rss.xml?edition=uk';

        $script = $_SERVER['SCRIPT_NAME'];
        echo "<form method='post' action='$script'>";
        echo 'Url to RSS: ';
        echo "<input type='text' size='30' value='", isset($_POST['rss']) ? htmlspecialchars($_POST['rss']) : "$defaultRss", "' name='rss'>";
        echo "<input type='submit' value='Load RSS'>";
        echo "</form>";

        if (isset($_POST['rss'])) {
            $rssFile = $_POST['rss'];

            echo "<h1>News from <code>$rssFile</code>:</h1>";

            $xmlDoc = new DOMDocument();
            $xmlDoc->load($rssFile);

            // get the channel
            $channel = $xmlDoc->getElementsByTagName('channel')->item(0);
            $channel_title = $channel->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
            $channel_link = $channel->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
            $channel_desc = $channel->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;

            // print the header
            echo "<h2><a href='", $channel_link, "'>", $channel_title, "</a></h2>";
            echo '<em>', $channel_desc, '</em>';
            echo '<br /><br /><br />';

            // print items
            $itemList = $xmlDoc->getElementsByTagName('item');
            foreach ($itemList as $item) {
                $item_title = $item->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
                $item_link = $item->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
                $item_desc = $item->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;

                echo ("<p><a href='" . $item_link . "'>" . $item_title . "</a>");
                echo ("<br />");
                echo ($item_desc . "</p>");
            }
        }

        $this->printPageFooter();
    }

    protected function printPageHeader() {
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
        echo '<html>';
        echo '<head>';
        echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
        echo '<title>Dzit Demo::PwdEncrypt</title>';
        echo '</head>';
        echo '<body>';
    }

    protected function printPageFooter() {
        echo '</body>';
        echo '</html>';
    }
}