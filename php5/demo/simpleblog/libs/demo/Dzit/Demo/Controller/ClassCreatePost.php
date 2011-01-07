<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
class Dzit_Demo_Controller_CreatePost extends Dzit_Demo_Controller_BaseController {

    const VIEW_NAME = 'createPost';
    const MODEL_FORM = 'form';
    const FORM_FIELD_TITLE = 'title';
    const FORM_FIELD_BODY = 'body';

    const MAX_LENGTH_TITLE = 128;
    const MAX_LENGTH_BODY = 1024;

    public function execute($module, $action) {
        $this->populateCommonModels();
        $form = Array();
        $form['urlSubmit'] = $this->getUrlCreatePost();
        $form['urlCancel'] = $this->getUrlHome();

        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $title = isset($_POST[self::FORM_FIELD_TITLE]) ? trim($_POST[self::FORM_FIELD_TITLE]) : NULL;
            $body = isset($_POST[self::FORM_FIELD_BODY]) ? trim($_POST[self::FORM_FIELD_BODY]) : NULL;
            if ($title === NULL || $title == '' || strlen($title) > self::MAX_LENGTH_TITLE) {
                if (!isset($form['errors'])) {
                    $form['errors'] = Array();
                }
                $form['errors'][] = 'Invalid title! Title must not be empty or longer than ' . self::MAX_LENGTH_TITLE . ' characters!';
            }
            if ($body === NULL || $body == '' || strlen($body) > self::MAX_LENGTH_BODY) {
                if (!isset($form['errors'])) {
                    $form['errors'] = Array();
                }
                $form['errors'][] = 'Invalid body! Body must not be empty or longer than ' . self::MAX_LENGTH_BODY . ' characters!';
            }
            if (!isset($form['errors'])) {
                //no error
                $simpleBlogDao = $this->getDao(self::DAO_SIMPLE_BLOG);
                $post = new Dzit_Demo_Bo_Post();
                $post->setTitle($title);
                $post->setBody($body);
                $post = $simpleBlogDao->createPost($post);

                $mav = new Dzit_ModelAndView();
                $mav->setView(new Dzit_View_RedirectView($this->getUrlHome()));
                return $mav;
            }
        }

        $this->setModel(self::MODEL_FORM, $form);

        $mav = new Dzit_ModelAndView(self::VIEW_NAME, $this->getRootModel());
        return $mav;
    }
}
?>
