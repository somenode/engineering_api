<?php
/**
 * Created by PhpStorm.
 * User: josh
 * Date: 6/14/18
 * Time: 12:30 PM
 */

/**
 * @file
 * Contains \Drupal\engineering_api\Plugin\resource\entity\node\Event\Event__1_1.
 */

namespace Drupal\engineering_api\Plugin\resource\entity\node\event;
use Drupal\restful\Plugin\resource\Field\ResourceFieldBase;
use Drupal\restful\Plugin\resource\ResourceInterface;

/**
 * Class Event__1_!
 * @package Drupal\engineering_api\Plugin\resource\entity\node\event
 *
 * @Resource(
 *   name = "event:1.1",
 *   resource = "event",
 *   label = "Event",
 *   description = "School of Engineering and Applied Science events.",
 *   authenticationOptional = TRUE,
 *   dataProvider = {
 *     "entityType": "node",
 *     "bundles": {
 *       "eng_events"
 *     },
 *     "sort" = {
 *      "date": "DESC",
 *      }
 *   },
 *   majorVersion = 1,
 *   minorVersion = 1
 * )
 */
class Event__1_1 extends Event__1_0 implements ResourceInterface {

    /**
     * Overrides ResourceEntity::publicFields().
     */
    protected function publicFields() {
        $public_fields = parent::publicFields();


        $public_fields['research']['resource']['name'] = 'research';
        $public_fields['department']['resource']['name'] ='udc';
        $public_fields['center']['resource']['name'] = 'udc';


        return $public_fields;
    }

}
