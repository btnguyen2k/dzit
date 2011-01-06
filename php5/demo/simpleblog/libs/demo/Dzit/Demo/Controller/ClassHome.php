<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
class Dzit_Demo_Controller_Home extends Dzit_Demo_Controller_BaseController {

    const VIEW_NAME = 'home';
    const MODEL_LATEST_POSTS = 'latestPosts';

    public function execute($module, $action) {
        $this->populateCommonModels();

        $simpleBlogDao = $this->getDao(self::DAO_SIMPLE_BLOG);
        $latestPosts = $simpleBlogDao->getLatestPosts(5);
        $this->setModel(self::MODEL_LATEST_POSTS, $latestPosts);

        $mav = new Dzit_ModelAndView(self::VIEW_NAME, $this->getRootModel());
        //$mav->setModel($this->getRootModel());
        return $mav;
    }
}
?>
