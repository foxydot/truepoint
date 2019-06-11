<?php
/*
Plugin Name: MSDLab GF Survey Addon
Description: Custom survey addon
Version: 0.1
Author: MSDLab
Author URI: http://msdlab.com/
License: GPL v2
*/

global $msd_gfsurvey_addon;

class MSDLabGFSurveyAddon
{
    private $ver;

    /**
     * MSDLabClientCustom constructor.
     */
    function __construct()
    {
        $this->ver = '0.1';

        register_activation_hook(__FILE__, array($this,'check_prerequisites'));
        add_action( 'gform_after_submission', array($this,'post_to_third_party_and_remove'), 10, 2 );

    }
/*
 * Make sure the GF and Survey are installed
 */
    function check_prerequisites(){
        return true;
    }

    function post_to_third_party_and_remove( $entry, $form ) {
        if(isset($entry['gsurvey_score'])){ //only do on surveys
            $post_url = 'https://prod-118.westus.logic.azure.com/workflows/1753fa6d691944abb635bcc2f45acee2/triggers/manual/paths/invoke?api-version=2016-06-01&sp=%2Ftriggers%2Fmanual%2Frun&sv=1.0&sig=3PvGxTvZvpNY_TJn54DakfFseyYXPHFvkLaOA8Sxc7w';
            $fields = GFAPI::get_fields_by_type( $form, array( 'survey' ) );
            $response_array = array();
            $survey_labels = array();

            foreach($fields as $field){
                foreach($field['choices'] as $choice){
                    $response_array[$choice['value']] = $choice['text'];
                }
                foreach ($field['inputs'] as $input){
                    $survey_labels[$input['id']]['label'] = $input['label'];
                    $response = explode(':',$entry[$input['id']]);
                    $survey_labels[$input['id']]['response'] = $response_array[$response[1]];
                }
            }

            $body = array(
                'first_name' => rgar( $entry, '3.3' ),
                'last_name' => rgar( $entry, '3.6' ),
            );

            foreach ($survey_labels AS $k => $v){
                $body[$v['label']] = $v['response'];
            }

            //GFCommon::log_debug( 'gform_after_submission: body => ' . print_r( $body, true ) );

            $request = new WP_Http();
            $response = $request->post( $post_url, array( 'body' => $body ) );
            //GFCommon::log_debug( 'gform_after_submission: response => ' . print_r( $response, true ) );

            GFAPI::delete_entry( $entry['id'] );
        }
    }

}
//instantiate
$msd_gfsurvey_addon = new MSDLabGFSurveyAddon();