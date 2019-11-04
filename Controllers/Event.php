<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 2019-05-22
 * Time: 16:59
 */
namespace int_;
abstract class AbstractEvent{





}




namespace events;
use Controller;
use FETCH_STRUCTURE;
use ReflectionClass;

class Event extends Controller
{
        public function index()
        {
                // TODO: Implement index() method.

                $this->view->data = array(
                );

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                try {
                        $rc = new ReflectionClass(get_class($this));
                } catch (\ReflectionException $e) {
                }

                $this->view->render($rc->getShortName(), $rc->getNamespaceName() . DIRECTORY_SEPARATOR . __FUNCTION__ );

        }


        public function testplay(){



                $this->view->data = array(

                        "play_area" => $this->playArea()

                );

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                try {
                        $rc = new ReflectionClass(get_class($this));
                } catch (\ReflectionException $e) {
                }

                $this->view->render($rc->getShortName(),
                        $rc->getNamespaceName() .
                        DIRECTORY_SEPARATOR .
                        __FUNCTION__ .
                        DIRECTORY_SEPARATOR .
                        "index"
                );



        }


        public function playArea(){


                return array(
                        $this->playAreaLocal(),
                        $this->playAreaOutwards()
                );

        }

        private function playAreaLocal(){

                $this->view->data = array(
                );

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                try {
                        $rc = new ReflectionClass(get_class($this));
                } catch (\ReflectionException $e) {
                }

                return $this->view->fileContent(
                        $rc->getShortName() .
                        DIRECTORY_SEPARATOR .
                        $rc->getNamespaceName() .
                        DIRECTORY_SEPARATOR .
                        "testplay",
                        "play_local.php"
                         );


        }

        private function playAreaOutwards(){

                $this->view->data = array(
                );

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                try {
                        $rc = new ReflectionClass(get_class($this));
                } catch (\ReflectionException $e) {
                }

                return $this->view->fileContent(
                        $rc->getShortName() .
                        DIRECTORY_SEPARATOR .
                        $rc->getNamespaceName() .
                        DIRECTORY_SEPARATOR .
                        "testplay",
                        "play_outwards.php"
                );


        }



}


