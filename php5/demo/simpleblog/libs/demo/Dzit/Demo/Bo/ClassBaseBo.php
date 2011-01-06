<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
abstract class Dzit_Demo_Bo_BaseBo {
    /**
     * Gets the url creator instance.
     *
     * @return Dzit_IUrlCreator
     */
    protected function getUrlCreator() {
        $key = Dzit_Demo_GlobalCache::CACHE_URL_CREATOR;
        $urlCreator = Dzit_Demo_GlobalCache::getEntry($key);
        if ($urlCreator === NULL) {
            $urlCreator = new Dzit_DefaultUrlCreator();
            Dzit_Demo_GlobalCache::setEntry($key, $urlCreator);
        }
        return $urlCreator;
    }
}
