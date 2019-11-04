<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 2019-05-15
 * Time: 14:12
 */

class TermsAndConditions extends Controller
{

        const TAC_APP_USING             = 1;
        const TAC_CREATE_CLUB           = 2;


        public function __construct($pars)
        {
                parent::__construct($pars);
        }

        /**
         * @throws \ReflectionException
         */
        public function index()
        {
                // TODO: Implement index() method.

                $this->model->pars= $this->pars;
                $tac_data = $this->model->getTACContent();


                $context = new ReflectionClass(get_class($this));





                $content = $this->helper->readFileContent("de", "Tacs", $tac_data["file"] . "_" . $tac_data["file_rev"], $tac_data["file_ext"] );








                $this->view->data = array(
                        "content"=>$content
                );
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT );



                $this->view->render($context->getShortName(), $context->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__ );

        }


}

