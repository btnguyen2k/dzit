<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
class Dzit_Demo_Controller_DeletePost extends Dzit_Demo_Controller_BaseController {

    public function execute($module, $action) {
        $postId = isset($_GET['id']) ? $_GET['id'] + 0 : 0;
        $simpleBlogDao = $this->getDao(self::DAO_SIMPLE_BLOG);
        $simpleBlogDao->deletePost($postId);
        $mav = new Dzit_ModelAndView();
        $mav->setView(new Dzit_View_RedirectView($this->getUrlHome()));
        return $mav;
    }
}
?>
