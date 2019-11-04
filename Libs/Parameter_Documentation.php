<?php
// TODO: Simple New Activity Post Data
$gen_data = array();
// Navigation Title
$gen_data["display_name"]              = "General";
// Navigation Full Url
$gen_data["link"]                      = Config::BASE_URL . DIRECTORY_SEPARATOR. "Settings". DIRECTORY_SEPARATOR . "_general" . DIRECTORY_SEPARATOR . "index/?uid=" . $this->uid;
// SharedApplication Data This is an Example
// $gen_data[SHARED_APPLICATION::X2SharedApplicationAdsKey] = SHARED_APPLICATION::X2SharedApplicationFacebookKey
// With Right Bar Button on Navigation
$gen_data["right_bar_button"]          = array(
        // Button Title
        "title"=>"Button Title", // show Button Title
        "icon"=>"Button Icon  floppy-disk", // Show Button Icon ( If Icon is not Empty than Icon else Show title)
        // Action With Confirm
        "confirm"=>array(
                // Alert View Title
                "title"=>"Speichern",
                "message"=>"Möchten Sie speichern?",
                // Alert View Actions
                "actions"=>array(
                        // Alert View Actions
                        array(
                                // Alert View Action[] title
                                "title"=>"Cancel",
                                // Alert View Action[] action dismiss alert controller if empty action
                                "action"=>"",
                                // Alert View Action[] action style support for ios, will combine with android
                                "style"=>ALERT_ACTION_STYLE::UIAlertActionStyleDestructive
                        ),

                        array(
                                // Alert View Action[] title
                                "title"=>"Save",
                                // Alert View Action[] action dismiss alert controller if empty action or call javascript code
                                "action"=>"javascript:new Layout().save('_availability');",
                                // Alert View Action[] action style support for ios, will combine with android
                                "style"=>ALERT_ACTION_STYLE::UIAlertActionStyleDefault
                        ),
                )
        )


);
$gen_data[ACTIVITY::ACTIVITY]          = ACTIVITY::go(ACTIVITY::ACTIVITY_2);


// Whit this code store the via JS data from active View for Back view
// Ttransfer this data to back view via Native content with JS Class unwindAction
$gen_data["unwind_get_data_store"]     = "javascript:new Layout().getUnwindDataStore();";

// Show Navigation header transparent
$gen_data["transparent_navigation_header"]     = true;



// After save with Javascrtip returned Result
return (object) array( "resulta"=>$process->resulta, "process"=>$process->process, "message"=>$message, "color"=>$color ) ;


// Notification Returned Data
$data = array (
    0 =>
        array (
            'N_TICKET' => '5bfc68d70de0e',
            'N_TIMEZONE' => 'Europe/Berlin',
            'N_TIME' => '2018-11-26 22:42:52',
            'N_TITLE' => 'Title 1',
            'N_MESSAGE' => 'Message 1',
            'N_REDIRECT_DATA' => 'N_REDIRECT_WITH_OBJECT',
            'N_REDIRECT_WITH_OBJECT' =>
                array (
                    'display_name' => 'Ligaspiel',
                    'link' => 'http://app.dfanet.de/Meeting/_details/index/?id=922',
                    'icon' => 'ic_wrench',
                    'unwind_get_data_store' => 'javascript:new Layout().getUnwindDataStore();',
                    'activity' => '8',
                    'isMatch' => '',
                ),
        ),
    1 =>
        array (
            'N_TICKET' => '5bfc68d70de49',
            'N_TIMEZONE' => 'Europe/Berlin',
            'N_TIME' => '2018-11-26 22:43:02',
            'N_TITLE' => 'Title 2',
            'N_MESSAGE' => 'Message 2',
            'N_REDIRECT_DATA' => 'N_REDIRECT_WITH_TAB_INDEX',
            'N_REDIRECT_WITH_TAB_INDEX' => '3',
        ),
);


// JS

?>

<!--Template-->
<script>

    $(function () {
        new Layout();
    });

    var Layout = function () {

            var L = this;

            // √
            this.init = function () {
                return this;
            };


            /// @Override
            // Set the data from Active View to this Parameter
            this.setUnwindDataStore = function( k, v ){

                unwindDataStore[k] = v;
            };

            /// @Override
            // Embed Data via Native content from Opened View to Opener (Parent) View JS
            this.setUnwindDataFromJSONString = function( data ){

                if( typeof data !== "object" ){
                    unwindDataStore = JSON.parse(data);
                } else {
                    unwindDataStore = data
                }

                return this;
            };

            /// @Override
            // Read Data via Native Content for Opened View
            this.getUnwindDataStore = function(){

                data = JSON.stringify(unwindDataStore);
                return data;
            };

            /// @Override
            // This Function Optional for Parent View
            this.runUnwind = function(){

                var obj = this.getUnwindDataStore();
                /// TODO Your Case

            };

            // √
            this.init();

            return this;

        },
        /// @Required for Layout
        unwindDataStore = {},
        // This action calling from Native Content data Post from Native Content And Need Absolute
        /// @Required For Native
        unwindAction = function (data) {

                // @Required Declaration for transfer
                new
                Layout()
                        // @Required Function for transfer
                        .setUnwindDataFromJSONString(data)

                        // @Optional Function if need
                        .runUnwind();

        };
</script>
