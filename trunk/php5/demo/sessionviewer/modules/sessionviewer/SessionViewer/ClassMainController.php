<?php
class SessionViewer_MainController extends SessionViewer_BaseController {

    const VIEW_NAME = 'main';

    protected function getViewName() {
        return self::VIEW_NAME;
    }
}
