<?php
/**
 * Created by PhpStorm.
 * User: josh
 * Date: 6/15/18
 * Time: 8:40 AM
 */

namespace Drupal\engineering_api\Plugin\resource\entity\node\event;
use Drupal\restful\Plugin\resource\DataInterpreter\DataInterpreterInterface;
use Drupal\restful\Plugin\resource\Field\ResourceFieldInterface;
use Drupal\restful\Plugin\resource\ResourceEntity;
use Drupal\restful\Plugin\resource\ResourceInterface;

/**
 * Class Faculty
 * @package Drupal\engineering_api\Plugin\resource\entity\node\event
 *
 * @Resource(
 *   name = "event:1.0",
 *   resource = "event",
 *   label = "Event",
 *   description = "School of Engineering and Applied Science events.",
 *   authenticationTypes = TRUE,
 *   authenticationOptional = TRUE,
 *   dataProvider = {
 *     "entityType": "node",
 *     "bundles": {
 *       "eng_events"
 *     },
 *      "sort" = {
 *      "date": "DESC",
 *      }
 *   },
 *   majorVersion = 1,
 *   minorVersion = 0
 * )
 */


class Event__1_0 extends ResourceEntity implements ResourceInterface {

    /**
     * {@inheritdoc}
     **/

    protected function publicFields()
    {
        $public_fields = parent::publicFields();
    
    
        // Rename label
        $public_fields['title'] = $public_fields['label'];
        unset($public_fields['label']);
    
        $public_fields['speaker'] = array(
            'property' => 'field_event_speaker',
        );
    
        $public_fields['date'] = array(
            'property' => 'field_event_time',
        );
    
        $public_fields['princeton_location'] = array(
            'property' => 'field_building_location',
        );
    
        $public_fields['princeton_room'] = array(
            'property' => 'field_room',
        );
    
        $public_fields['other_location'] = array(
            'property' => 'field_event_google_map',
        );

        $public_fields['website'] = array(
            'property' => 'field_event_website',
            'value' => 'path',
        );

        $public_fields['research'] = array(
            'property' => 'field_event_impact',
            'wrapper_method' => 'getIdentifier',
        );

        $public_fields['department'] = array(
            'property' => 'field_event_department',
            'wrapper_method' => 'getIdentifier',
        );

        $public_fields['center'] = array(
            'property' => 'field_event_center',
            'wrapper_method' => 'getIdentifier',
        );
    
        $public_fields['url'] = $public_fields['path'];
        $public_fields['url'] = array(
            'property' => 'url',
        );


        return $public_fields;
    }


}