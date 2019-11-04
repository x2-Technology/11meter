<?php
/**
 * Created by PhpStorm.
 * User: suleymantopaloglu
 * Date: 03.12.18
 * Time: 09:57
 */
namespace manage;
use Controller;
use FETCH_STRUCTURE;
use SHARED_APPLICATION;
use ACTIVITY;
use Helper;

class More extends Controller
{

        public function index()
        {
                // TODO: Implement index() method.


                $fb_data = array();
                // Navigation Title
                $fb_data["display_name"]              = SHARED_APPLICATION::X2SharedApplicationFacebookKey;
                // Activity Full Url
                $fb_data["link"]                      = "527864557247686"; // SVH link
                // With Right Bar Button on Navigation
                $fb_data[ACTIVITY::ACTIVITY]          = ACTIVITY::go(ACTIVITY::ACTIVITY_SHARED);

                $fb_data[SHARED_APPLICATION::X2SharedApplicationKey] = SHARED_APPLICATION::X2SharedApplicationFacebookKey;


                $tw_data = array();
                // Navigation Title
                $tw_data["display_name"]              = SHARED_APPLICATION::X2SharedApplicationTwitterKey;
                // Activity Full Url
                $tw_data["link"]                      = "SVHorchheim"; // Lisa Kestel
                // With Right Bar Button on Navigation
                $tw_data[ACTIVITY::ACTIVITY]          = ACTIVITY::go(ACTIVITY::ACTIVITY_SHARED);

                $tw_data[SHARED_APPLICATION::X2SharedApplicationKey] = SHARED_APPLICATION::X2SharedApplicationTwitterKey;

                $wa_data = array();
                // Navigation Title
                $wa_data["display_name"]              = SHARED_APPLICATION::X2SharedApplicationWhatsAppKey;
                // Activity Full Url
                $wa_data["link"]                      = "Wie geht's";
                // With Right Bar Button on Navigation
                $wa_data[ACTIVITY::ACTIVITY]          = ACTIVITY::go(ACTIVITY::ACTIVITY_SHARED);

                $wa_data[SHARED_APPLICATION::X2SharedApplicationKey] = SHARED_APPLICATION::X2SharedApplicationWhatsAppKey;

                $arg = array(
                        SHARED_APPLICATION::X2SharedApplicationFacebookKey => Helper::JSONCleaned($fb_data),
                        SHARED_APPLICATION::X2SharedApplicationTwitterKey => Helper::JSONCleaned($tw_data),
                        SHARED_APPLICATION::X2SharedApplicationWhatsAppKey => Helper::JSONCleaned($wa_data),
                );



                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                $this->view->data = $arg;
                $this->view->render("More", "index");

        }
}