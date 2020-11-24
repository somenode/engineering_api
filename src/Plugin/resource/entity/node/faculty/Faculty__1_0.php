<?php
/**
 * Created by PhpStorm.
 * User: josh
 * Date: 6/15/18
 * Time: 8:40 AM
 */

namespace Drupal\engineering_api\Plugin\resource\entity\node\faculty;
use Drupal\restful\Plugin\resource\DataInterpreter\DataInterpreterInterface;
use Drupal\restful\Plugin\resource\Field\ResourceFieldInterface;
use Drupal\restful\Plugin\resource\ResourceEntity;
use Drupal\restful\Plugin\resource\ResourceInterface;

/**
 * Class Faculty
 * @package Drupal\engineering_api\Plugin\resource\entity\node\faculty
 *
 * @Resource(
 *   name = "faculty:1.0",
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
 *   },
 *   majorVersion = 1,
 *   minorVersion = 0
 * )
 */


class Faculty__1_0 extends ResourceEntity implements ResourceInterface {

    /**
     * {@inheritdoc}
     **/

    protected function publicFields()
    {
        $public_fields = parent::publicFields();


        // Rename label
        $public_fields['name'] = $public_fields['label'];
        unset($public_fields['label']);

        $public_fields['first_name'] = array(
            'property' => 'field_name',
            'sub_property' => 'given'

        );

        $public_fields['middle_name'] = array(
          'property' => 'field_name',
          'sub_property' => 'middle'

        );

        $public_fields['last_name'] = array(
          'property' => 'field_name',
          'sub_property' => 'family'

        );

        $public_fields['generational_name'] = array(
          'property' => 'field_name',
          'sub_property' => 'generational'

        );


      $public_fields['title'] = array(
            'property' => 'field_faculty_title',
        );

        $public_fields['website'] = array(
            'property' => 'field_website',
            'value' => 'path',
        );

        $public_fields['research'] = array(
            'property' => 'field_research',
            'wrapper_method' => 'getIdentifier',
        );

        $public_fields['primary_affiliations'] = array(
            'property' => 'field_primary_affiliations',
            'wrapper_method' => 'getIdentifier',
        );

        $public_fields['other_affiliations'] = array(
            'property' => 'field_other_affiliations',
            'wrapper_method' => 'getIdentifier',
        );


        return $public_fields;
    }


}
