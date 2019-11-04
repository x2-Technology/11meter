<?php

/**
 * Created by PhpStorm.
 * User: tSoftX
 * Date: 13/02/2017
 * Time: 21:11
 */
class Login extends Controller
{

        /**
         * Login constructor.
         * @param $pars
         * @throws ReflectionException
         */
        function __construct($pars)
        {
                parent::__construct($pars);
        }

        function index()
        {
                
                // highlight_string(var_export(REPOSITORY::read(REPOSITORY::CURRENT_DEVICE), true));

                // highlight_string(var_export($_SESSION, true));
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                /*if (!is_null($this->pars->id)) {
                }*/

                $this->view->data = $this->pars;
                $this->view->render("Login", "index");
        }

        function signup()
        {
                #highlight_string(var_export(REPOSITORY::read(REPOSITORY::CURRENT_DEVICE), true));

                // highlight_string(var_export($_SESSION, true));
                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                /*if (!is_null($this->pars->id)) {
                }*/

                $this->view->data = $this->pars;
                $this->view->render("Login", __FUNCTION__ );
        }


        function logout()
        {

                $this->storage->killAll(function () {

                        header("Location: " . Config::BASE_URL);

                });


        }


}