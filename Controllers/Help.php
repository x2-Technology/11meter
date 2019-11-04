<?php

/**
 * Created by PhpStorm.
 * User: adler_supervisor
 * Date: 17.08.17
 * Time: 15:08
 * Developer:Süleyman Topaloglu
 */
class Help extends Controller
{
        /**
         * Help constructor.
         * @param $pars
         * @throws ReflectionException
         */
        function __construct($pars)
        {
                parent::__construct($pars);
        }


        public function index()
        {
                // TODO: Implement index() method.
        }

        function pforgot()
        {


                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);

                $this->view->data = array();

                if (isset($this->pars->save) && $this->pars->save) {
                        $this->view->data = $this->checkAccount();
                }


                $this->view->render(get_class($this), __FUNCTION__);


        }

        private function checkAccount()
        {


                $response = $this->model->{__FUNCTION__}($this->pars);

                $resulta = $response["count"];
                $data = $response["data"];

                $text_iFac = "";

                $link = "";
                if ($resulta) {
                        $link = Config::BASE_URL . "/Help/!/preset/utoken:{$data["utoken"]}";


                        $target_email = $data["cemail"];
                        if ($data["urole"] === Defaults::USER_ROLE_USER) {
                                $target_email = $data["uemail"];
                        }


                        // MAILING TEXT

                        $email = new Email(null);
                        $file = "Libs/Texts/Mails/{$this->lng_src}/password_forgot.txt";          // <- File With Language
                        if (!file_exists($file)) {
                                $file = "Libs/Texts/Mails/en/password_forgot.txt";     // <- Default file
                        }
                        $text_mail = "";
                        $file = fopen($file, 'r');
                        while (!feof($file)) {
                                $text_mail .= fgets($file) . "<br />";
                        }
                        fclose($file);

                        // String Replace
                        $text_mail = preg_replace("/\"temp_link\"/", $link, $text_mail);
                        $email->send("Iroc GmbH", $target_email, $this->label->reset_your_password, $text_mail, true, 1005);


                        // USER INTERFACE MESSAGE

                        $file = "Libs/Texts/Messages/{$this->lng_src}/password_forgot.txt";          // <- File With Language
                        if (!file_exists($file)) {
                                $file = "Libs/Texts/Messages/en/password_forgot.txt";     // <- Default file
                        }

                        $file = fopen($file, 'r');
                        while (!feof($file)) {
                                $text_iFac .= fgets($file) . "<br />";
                        }
                        fclose($file);

                        // String Replace
                        $text_iFac = preg_replace("/\"user_email\"/", $target_email, $text_iFac);


                        /*$message = "<div class=\"alert alert-success fade in alert-dismissable base-width center-block\">
                                    <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\" title=\"close\">×</a>
                                    {$this->label->success}
                                </div>";*/

                        $m = $this->helper->showUserMessage($this->label->success, "success", true, 1019);


                } else {

                        // Kodlar Yanlis girilmisse

                        /*$message = "<div class=\"alert alert-danger fade in alert-dismissable base-width center-block\">
                                    <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\" title=\"close\">×</a>
                                    {$this->label->incorrect_username_or_secret_key}
                                </div>";*/


                        $m = $this->helper->showUserMessage($this->label->incorrect_username_or_secret_key, "danger", true, 1020);

                }


                return array(
                    "saveresponse" => true,
                    "resulta" => $resulta,
                    "text_ifac" => $text_iFac,
                    "message" => $message

                );


        }


        function preset()
        {


                $this->view->data = array();

                if (isset($this->pars->save) && $this->pars->save) {
                        $this->view->data = $this->passwordChangeWithToken();
                }

                $this->view->setPostDataStructure(FETCH_STRUCTURE::FETCH_OBJECT);
                $this->view->render(get_class($this), __FUNCTION__);


        }

        private function passwordChangeWithToken()
        {


                $text_iFac = "";

                if ($this->pars->upass !== $this->pars->upass_confirm) {
                        $response = false;
                        /* $message = "<div class=\"alert alert-warning fade in alert-dismissable base-width center-block\">
                                   <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\" title=\"close\">×</a>
                                    {$this->label->password_does_not_match}
                                </div>";*/

                        $m = $this->helper->showUserMessage($this->label->password_does_not_match, "warning", true, 1021);


                } else {
                        $response = $this->model->{__FUNCTION__}($this->pars);

                        if ($response) {
                                // USER INTERFACE MESSAGE

                                $file = "Libs/Texts/Messages/{$this->lng_src}/after_password_change.txt";          // <- File With Language
                                if (!file_exists($file)) {
                                        $file = "Libs/Texts/Messages/en/after_password_change.txt";     // <- Default file
                                }

                                $file = fopen($file, 'r');
                                while (!feof($file)) {
                                        $text_iFac .= fgets($file) . "<br />";
                                }
                                fclose($file);

                                // String Replace
                                $text_iFac = preg_replace("/\"login_link\"/", "/Login/!/index", $text_iFac);


                                /*$message = "<div class=\"alert alert-success fade in alert-dismissable base-width center-block\">
                                        <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\" title=\"close\">×</a>
                                        {$this->label->success}
                                    </div>";*/

                                $m = $this->helper->showUserMessage($this->label->success, "success", true, 1022);


                        } else {

                                // Show error message
                                /*$message = "<div class=\"alert alert-danger fade in alert-dismissable base-width center-block\">
                                        <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\" title=\"close\">×</a>
                                        {$this->label->incorrect_token}
                                    </div>";*/

                                $m = $this->helper->showUserMessage($this->label->incorrect_token, "danger", true, 1023);


                        }


                }


                return array(
                    "saveresponse" => true,
                    "resulta" => $response,
                    "message" => $m,
                    "text_ifac" => $text_iFac,


                );


        }


}