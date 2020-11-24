<?php
/**
 * Created by PhpStorm.
 * User: josh
 * Date: 6/15/18
 * Time: 10:16 AM
 */

namespace Drupal\engineering_api\Plugin\resource\entity\node\faculty;

use Drupal\restful\Plugin\resource\ResourceEntity;
use Drupal\restful\Plugin\resource\ResourceInterface;

/**
 * Class Faculty
 * @package Drupal\engineering_api\Plugin\resource\entity\node\faculty
 *
 * @Resource(
 *   name = "faculty:1.1",
 *   resource = "faculty",
 *   label = "Faculty",
 *   description = "School of Engineering and Applied Science faculty.",
 *   authenticationTypes = TRUE,
 *   authenticationOptional = TRUE,
 *   dataProvider = {
 *     "entityType": "node",
 *     "bundles": {
 *       "faculty"
 *     },
 *     "sort": {
 *      "name": "ASC"
 *      }
 *   },
 *   majorVersion = 1,
 *   minorVersion = 1
 * )
 */

class Faculty__1_1 extends Faculty__1_0 implements ResourceInterface {

    /**
     * Overrides ResourceEntity::publicFields().
     */
    protected function publicFields() {
        $public_fields = parent::publicFields();


        $public_fields['research']['resource']['name'] = 'research';
        $public_fields['primary_affiliations']['resource']['name'] = 'udc';
        $public_fields['other_affiliations']['resource']['name'] = 'udc';

        return $public_fields;
    }
}