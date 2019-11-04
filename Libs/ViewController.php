<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 06.02.19
 * Time: 09:42
 */

class ViewController
{

        const EXTERNAL_URL_KEY = "externalUrl";
        const RUNNABLE_SCRIPT_KEY = "runnableScript";

        const SHOW_VIEW_NUMBER = true;
        const SHOW_VIEW_CLASS_NAME = true ;

        private $title;
        private $subTitle;
        private $controller;
        private $namespace;
        private $method;
        private $params;// = array();
        private $activity;
        private $leftBarButton;
        private $rightBarButton;
        private $unwind_action;
        private $viewControllerPath;
        private $backGroundColor;

        /**
         * @return mixed
         */
        public function getBackGroundColor()
        {
                return $this->backGroundColor;
        }

        /**
         * @param mixed $backGroundColor
         */
        public function setBackGroundColor($backGroundColor)
        {
                $this->backGroundColor = $backGroundColor;
        }

        /**
         * @return mixed
         */
        public function getViewControllerPath()
        {
                return $this->viewControllerPath;
        }

        /**
         * @param mixed $viewControllerPath
         */
        public function setViewControllerPath($viewControllerPath)
        {
                $this->viewControllerPath = $viewControllerPath;
        }

        private $runnableScript = null;
        private $runnableAction = null;

        private $viewBottomViewWithAction = null;
        private $viewBottomViewWithLabel  = null;

        /**
         * @return null
         */
        private function getViewBottomViewWithAction()
        {
                return $this->viewBottomViewWithAction;
        }

        /**
         * @param null $viewBottomViewWithAction
         */
        public function setViewBottomViewWithAction( $title = "No title", $action = "No action" )
        {
                $this->viewBottomViewWithAction = array(
                        "title" => $title,
                        "action" => $action
                );
        }

        /**
         * @return null
         */
        public function getViewBottomViewWithLabel()
        {
                return $this->viewBottomViewWithLabel;
        }

        /**
         * @param null $viewBottomViewWithLabel
         */
        public function setViewBottomViewWithLabel($viewBottomViewWithLabel)
        {
                $this->viewBottomViewWithLabel = $viewBottomViewWithLabel;
        }

        /**
         * @return null
         *
         */
        public function getRunnableAction()
        {
                return $this->runnableAction;
        }

        /**
         * @param null $runnableAction
         *
         */
        public function setRunnableAction($runnableAction)
        {
                $this->runnableAction = $runnableAction;
        }
        private $externalUrl    = null;

        /**
         * @return null
         */
        public function getExternalUrl()
        {
                return $this->externalUrl;
        }

        /**
         * @param null $externalUrl
         */
        public function setExternalUrl($externalUrl)
        {
                $this->externalUrl = $externalUrl;
        }



        /**
         * @return mixed
         */
        public function getRunnableScript()
        {
                return $this->runnableScript;
        }

        /**
         * @param mixed $runnableScript
         *
         */
        public function setRunnableScript($runnableScript)
        {
                $this->runnableScript = $runnableScript;
        }





        /**
         * @return mixed
         */
        public function getUnwindAction()
        {
                return $this->unwind_action;
        }

        /**
         * @param mixed $unwind_action
         */
        public function setUnwindAction($unwind_action)
        {
                $this->unwind_action = $unwind_action;
        }

        /**
         * @return mixed
         */
        public function getActivity()
        {
                return $this->activity;
        }

        /**
         * @param mixed $activity
         */
        public function setActivity($activity)
        {
                $this->activity = $activity;
        }

        /**
         * @return mixed
         */
        public function getLeftBarButton()
        {
                return $this->leftBarButton;
        }

        /**
         * @param mixed $leftBarButton
         */
        public function setLeftBarButton($leftBarButton)
        {
                $this->leftBarButton = $leftBarButton;
        }

        /**
         * @return mixed
         */
        public function getRightBarButton()
        {
                return $this->rightBarButton;
        }

        /**
         * @param mixed $rightBarButton
         */
        public function setRightBarButton($rightBarButton)
        {
                $this->rightBarButton = $rightBarButton;
        }

        /**
         * @return mixed
         */
        private function getController()
        {
                return $this->controller;
        }

        /**
         * @param mixed $controller
         */
        public function setController($controller)
        {
                $this->controller = $controller;
        }

        /**
         * @return mixed
         */
        private function getNamespace()
        {
                return $this->namespace;
        }

        /**
         * @param mixed $namespace
         */
        public function setNamespace($namespace)
        {
                $this->namespace = $namespace;
        }

        /**
         * @return mixed
         */
        private function getMethod()
        {
                return $this->method;
        }

        /**
         * @param mixed $method
         */
        public function setMethod($method)
        {
                $this->method = $method;
        }


        /**
         * @return mixed
         */
        private function getParams()
        {
                if( count($this->params) ){
                        return implode("&", $this->params);
                }
                return "";
        }

        /**
         * @param mixed $params
         */
        public function setParams($params = array())
        {
                $p = array();
                if( count($params) ){

                        foreach ($params as $k => $v ){
                                    array_push($p, $k."=".$v);
                        }

                        $this->params = $p;
                        return $this;
                }

                $this->params = $params;
                return $this;
        }

        /**
         * @param mixed $params
         * Add extra param to Params
         */
        /*public function addParam( $k, $v )
        {
                $params = $this->params;
                $params[$k]=$v;
                $this->params = $params;
                return $this;
        }*/

        /**
         * @return mixed
         */
        private function getTitle()
        {
                return $this->title;
        }

        /**
         * @param mixed $title
         */
        public function setTitle($title)
        {
                $this->title = $title;
        }

        /**
         * @return mixed
         */
        public function getSubTitle()
        {
                if( self::SHOW_VIEW_CLASS_NAME ){

                        if( self::SHOW_VIEW_NUMBER ){
                                return $this->getViewControllerPath() . " " .  "[" . $this->getActivity() . "]";
                        }
                        return $this->getViewControllerPath();

                } else {

                        if( self::SHOW_VIEW_NUMBER ){
                                return $this->subTitle . " " .  "[" . $this->getActivity() . "]";
                        }

                        return $this->subTitle;

                }


        }

        /**
         * @param mixed $subTitle
         */
        public function setSubTitle($subTitle)
        {
                $this->subTitle = $subTitle;
        }


        /*
         * Missing Method View Controller need for External Share Option
         *
         * */

        function __construct(
                $title = "View",
                $subTitle = NULL,
                $controller,
                $namespace,
                $method,
                $params = array(),
                $activity,
                $leftBarButton = NULL ,
                $rightBarButton = NULL,
                $backGroundColor = BACKGROUND_COLOR::BackgroundColorIphoneDefault
                /*{'title', 'icon', 'action'}*/
        ) {

                $this->setTitle($title);
                $this->setSubTitle($subTitle);
                $this->setController($controller);
                $this->setNamespace($namespace);
                $this->setMethod($method);
                $this->setParams($params);
                $this->setLeftBarButton($leftBarButton);
                $this->setRightBarButton($rightBarButton);
                $this->setActivity($activity);
                $this->setBackGroundColor($backGroundColor);

                return $this;
        }





        public function prepare(){



                $this->setViewControllerPath($this->getController() .
                        DIRECTORY_SEPARATOR .
                        $this->getNamespace() .
                        DIRECTORY_SEPARATOR .
                        $this->getMethod() .
                        DIRECTORY_SEPARATOR .
                        "?" .
                        $this->getParams());


                // VIEW CONTROLLER SUB TITLE
                $_ = array();

                $_["display_name"]              = $this->getTitle();

                if( !is_null($this->getSubTitle())){
                        $_["sub_title"]                 = $this->getSubTitle();
                }


                $_["link"]
                        = Config::BASE_URL .
                        DIRECTORY_SEPARATOR .
                        $this->getViewControllerPath();


                if(!is_null($this->getRightBarButton())){
                        $_["right_bar_button"]  = $this->getRightBarButton();
                }
                if( !is_null($this->getLeftBarButton())){
                        $_["left_bar_button"]   = $this->getLeftBarButton();
                }

                $_["unwind_get_data_store"]     = "javascript:new Layout().getUnwindDataStore();";
                $_["unwind_action"]             = "javascript:" . $this->getUnwindAction();



                $_["externalUrl"]       = $this->getExternalUrl();
                $_["runnableScript"]    = $this->getRunnableScript();
                // $_["runnableAction"]    = $this->getRunnableAction();

                $_["background_color"] = $this->getBackGroundColor();


                $_[ACTIVITY::ACTIVITY]          = ACTIVITY::go($this->getActivity());


                if( is_null($this->getLeftBarButton()) ){
                        $_[VIEW_CONTROLLER::X2UINavigationBackButtonKey] = VIEW_CONTROLLER::X2UINavigationBackButtonHide;
                } else {
                        $_[VIEW_CONTROLLER::X2UINavigationBackButtonKey] = VIEW_CONTROLLER::X2UINavigationBackButtonShow;
                }

                // Button View Additional View
                // Priority Button View Action

                if( !is_null($this->getViewBottomViewWithAction()) || !is_null($this->getViewBottomViewWithLabel()) ){

                        // $_["X2ViewControllerBottomView"] = [];

                        if( !is_null($this->getViewBottomViewWithAction()) ){
                                $_["X2ViewControllerBottomView"]["action"] = $this->getViewBottomViewWithAction();
                        } else {
                                if(!is_null($this->getViewBottomViewWithLabel())){
                                        $_["X2ViewControllerBottomView"]["label"]    = $this->getViewBottomViewWithLabel();
                                }
                        }
                }







                return $_;

        }

        /**
         * @deprecated
         * @param string $link
         * @return array
         */
        public function prepareWithExternalConnect( $link = "" ){

                $_ = array();
                $_["display_name"] = $this->getTitle();
                if( !is_null($this->getSubTitle())){
                        $_["sub_title"] = $this->getSubTitle();
                }
                $_["link"] = $link . "?" . $this->getParams();

                $_["right_bar_button"]  = $this->getRightBarButton();
                $_["left_bar_button"]   = $this->getLeftBarButton();
                $_["unwind_get_data_store"]     = "javascript:new Layout().getUnwindDataStore();";
                $_["unwind_action"]     = "javascript:" . $this->getUnwindAction();
                $_[ACTIVITY::ACTIVITY]  = ACTIVITY::go($this->getActivity());

                $_["runnableScript"]    = $this->getRunnableScript();


                if( is_null($this->getLeftBarButton()) ){
                        $_[VIEW_CONTROLLER::X2UINavigationBackButtonKey] = VIEW_CONTROLLER::X2UINavigationBackButtonHide;
                } else {
                        $_[VIEW_CONTROLLER::X2UINavigationBackButtonKey] = VIEW_CONTROLLER::X2UINavigationBackButtonShow;
                }


                return $_;

        }

}

class RightBarButton {

        private $title;

        /**
         * @return string
         */
        public function getTitle()
        {
                return $this->title;
        }

        /**
         * @param string $title
         */
        public function setTitle($title)
        {
                $this->title = $title;
        }

        /**
         * @return string
         */
        public function getIcon()
        {
                return $this->icon;
        }

        /**
         * @param string $icon
         */
        public function setIcon($icon)
        {
                $this->icon = $icon;
        }

        /**
         * @return string
         */
        public function getAction()
        {
                return $this->action;
        }

        /**
         * @param string $action
         */
        public function setAction($action)
        {
                $this->action = is_null($action)?"":$action;
        }
        private $icon = "ic_home";
        private $action = "";
        private $confirmation = "";

        /**
         * @return string
         */
        public function getConfirmation()
        {
                return $this->confirmation;
        }

        /**
         * @param string $confirmation
         */
        public function setConfirmation($confirmation)
        {
                $this->confirmation = $confirmation;
        }


        function __construct($title = "Button", $icon = "ic_home", $action = NULL, $confirmation = NULL ) {

                $this->setTitle($title);
                $this->setIcon($icon);
                $this->setAction($action);
                $this->setConfirmation($confirmation);

        }

        function prepare(){

                $_ = array();
                $_["title"]     = !is_null($this->getTitle()) ? $this->getTitle() : NULL;;
                $_["icon"]      = !is_null($this->getIcon()) ? $this->getIcon() : NULL;
                $_["action"]    = is_null($this->getAction()) ? "" : $this->getAction();
                $_["confirm"]   = $this->getConfirmation();

                return $_;
        }



}

class ConfirmationAlert {

        private $title;

        /**
         * @return mixed
         */
        public function getTitle()
        {
                return $this->title;
        }

        /**
         * @param mixed $title
         */
        public function setTitle($title)
        {
                $this->title = $title;
        }

        /**
         * @return mixed
         */
        public function getMessage()
        {
                return $this->message;
        }

        /**
         * @param mixed $message
         */
        public function setMessage($message)
        {
                $this->message = $message;
        }

        /**
         * @return array
         */
        public function getActions()
        {
                return $this->actions;
        }

        /**
         * @param array $actions
         */
        public function setActions($actions)
        {
                $this->actions = $actions;
        }
        private $message;
        private $actions = array();

        function __construct( $title, $message ) {

                $this->setTitle($title);
                $this->setMessage($message);

        }

        function setAction( $title = "Button", $style = NULL, $action = NULL){

                $style = is_null($style) ? ALERT_ACTION_STYLE::UIAlertActionStyleDefault : $style;
                $action = is_null($action)?"":$action;
                array_push($this->actions, array("title"=>$title, "style"=>$style, "action"=>$action ));
        }

        function prepare(){

                $_ = array();
                $_["title"]     = "Speichern";
                $_["message"]   = "Moechten Sie speichern?";
                $_["actions"]   = $this->getActions();

                return $_;
        }



}