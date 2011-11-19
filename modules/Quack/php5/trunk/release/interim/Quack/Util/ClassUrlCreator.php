<?php
class Quack_Util_UrlCreator {
    /**
     * Creates a URI.
     *
     * @param string $scriptName URI pointing to the script
     * @param Array $vParams virtual parameters as an indexing array
     * @param Array $urlParams url parameters as an associative array
     */
    public static function createUri($scriptName, $vParams = Array(), $urlParams = Array()) {
        $uri = $scriptName;
        foreach ($vParams as $param) {
            $uri .= '/' . urlencode($param);
        }
        if (count($urlParams) > 0) {
            $uri .= '?';
            foreach ($urlParams as $key => $value) {
                $uri .= urlencode($key) . '=' . urlencode($param) . '&';
            }
        }
        return $uri;
    }

    /**
     * Creates an absolute URL.
     *
     * @param string $scriptName URI pointing to the script
     * @param Array $vParams virtual parameters as an indexing array
     * @param Array $urlParams url parameters as an associative array
     * @param int $secureType 0=default, 1=force https, 2=force http
     * @param string $host use this host/domain to build the URL; set to NULL to use the current host
     */
    public static function createUrl($scriptName, $vParams = Array(), $urlParams = Array(), $secureType = 0, $host = NULL) {
        $uri = self::createUri($scriptName, $vParams, $urlParams);
        $uri = preg_replace('/^\/+/', '', $uri);

        if ($host === NULL) {
            $host = $_SERVER['HTTP_HOST'];
        }
        $host = preg_replace('/\/+$/', '', $host);

        $uri = $host . '/' . $uri;
        $isHttps = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off';
        if ($secureType == 1) {
            //forece https
            $url = "https://$uri";
        } else if ($secureType == 2) {
            //forect http
            $url = "http://$uri";
        } else {
            $url = $isHttps ? "https://$uri" : "http://$uri";
        }
        return $url;
    }
}
