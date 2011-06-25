<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Controller with a pre-defined flow for web application.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dzit
 * @subpackage	Controller
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassIController.php 40 2010-12-23 19:29:19Z btnguyen2k $
 * @since       File available since v0.3
 */

/**
 * Controller with a pre-defined flow for web application.
 *
 * This controller embeds the following flow:
 * <ol>
 * <li>1. Call {@link populateParams()}</li>
 * <li>
 * 2. Call {@link validateParams()}
 * <ol>
 * <li>2.1. If {@link validateParams()} returns FALSE, return $this->{@link getModelAndView_Error()};</li>
 * <li>2.2. Otherwise, continue.
 * </ol>
 * </li>
 * <li>3. Call {@link validateAuthentication()}.
 * <ol>
 * <li>3.1. If {@link validateAuthentication()} return FALSE, return $this->{@link getModelAndView_Login()};</li>
 * <li>3.2. Otherwise, continue.
 * </ol>
 * </li>
 * <li>4. Call {@link validateAuthorization()}.
 * <ol>
 * <li>4.1. If {@link validateAuthorization()} return FALSE, return $this->{@link getModelAndView_Error()};</li>
 * <li>4.2. Otherwise, continue.
 * </ol>
 * </li>
 * <li>5. Check if the request is POST?
 * <ol>
 * <li>5.1. If POST request, call {@link performFormSubmission()}
 * <ol>
 * <li>5.1.1. If {@link performFormSubmission()} returns TRUE, return {@link getModelAndView_FormSubmissionSuccessful()}</li>
 * <li>5.1.2. Otherwise, continue to step 6.</li>
 * </ol>
 * </li>
 * <li>5.2. Otherwise, call {@link executeNonPost()} and continue to step 6.</li>
 * </ol>
 * </li>
 * <li>6. return {@link getModelAndView()}</li>
 * </ol>
 *
 * @package     Dzit
 * @subpackage	Controller
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since       Class available since v0.3
 */
class Dzit_Controller_FlowController implements Dzit_IController {

    private $module, $action;

    /**
     * Gets the model and view for non-POST page, or when the form submission fails.
     *
     * This function is part of the flow. It simply returns NULL. Sub-class overrides
     * the function to perform its own business logic.
     *
     * @return Dzit_ModelAndView
     */
    protected function getModelAndView() {
        return NULL;
    }

    /**
     * Gets the model and view for the case of error.
     *
     * This function is part of the flow. It simply returns NULL. Sub-class overrides
     * the function to perform its own business logic.
     *
     * @return Dzit_ModelAndView
     */
    protected function getModelAndView_Error() {
        return NULL;
    }

    /**
     * Gets the model and view for login page.
     *
     * This function is part of the flow. It simply returns NULL. Sub-class overrides
     * the function to perform its own business logic.
     *
     * @return Dzit_ModelAndView
     */
    protected function getModelAndView_Login() {
        return NULL;
    }

    /**
     * Gets the model and view for the case successful form submission.
     *
     * This function is part of the flow. It simply returns NULL. Sub-class overrides
     * the function to perform its own business logic.
     *
     * @return Dzit_ModelAndView
     */
    protected function getModelAndView_FormSubmissionSuccessful() {
        return NULL;
    }

    /**
     * Handles form submission. The function returns TRUE to indicate that the form
     * submission is successful, FALSE otherwise.
     *
     * This function is part of the flow. It does nothing and simply return FALSE.
     * Sub-class overrides the function to perform its own business logic.
     *
     * @return boolean
     */
    protected function performFormSubmission() {
        return FALSE;
    }

    /**
     * Populates parameters.
     *
     * This function is part of the flow. It does nothing. Sub-class overrides the
     * function to perform its own business logic.
     */
    protected function populateParams() {
        //EMPTY
    }

    /**
     * Performs authentication validations (e.g. check if login is required).
     *
     * This function is part of the flow. It simply return TRUE. Sub-class overrides
     * the function to perform its own business logic.
     *
     * @return boolean
     */
    protected function validateAuthentication() {
        return TRUE;
    }

    /**
     * Performs authorization validations (e.g. check if user has permission).
     *
     * This function is part of the flow. It simply return TRUE. Sub-class overrides
     * the function to perform its own business logic.
     *
     * @return boolean
     */
    protected function validateAuthorization() {
        return TRUE;
    }

    /**
     * Validates parameters (e.g. check if parameters are all valid).
     *
     * This function is part of the flow. It simply returns TRUE. Sub-class overrides
     * the function to perform its own business logic.
     *
     * @return boolean
     */
    protected function validateParams() {
        return TRUE;
    }

    /**
     * @see Dzit_IController::execute()
     */
    public function execute($module, $action) {
        $this->module = $module;
        $this->action = $action;

        $this->populateParams();
        if (!$this->validateParams()) {
            return $this->getModelAndView_Error();
        }

        if (!$this->validateAuthentication()) {
            return $this->getModelAndView_Login();
        }

        if (!$this->validateAuthorization()) {
            return $this->getModelAndView_Error();
        }

        if (isset($_POST)) {
            if ($this->performFormSubmission()) {
                return $this->getModelAndView_FormSubmissionSuccessful();
            }
        } else {
            $this->executeNonPost();
        }
        return $this->getModelAndView();
    }

    /**
     * Performs business logic for non-POST action.
     *
     * This function is part of the flow. It does nothing. Sub-class overrides the function
     * to perform its own business logic.
     */
    protected function executeNonPost() {
        //EMPTY
    }

    /**
     * Gets the current action.
     *
     * @return string
     */
    protected function getAction() {
        return $this->action;
    }

    /**
     * Gets the current module.
     *
     * @return string
     */
    protected function getModule() {
        return $this->module;
    }
}
