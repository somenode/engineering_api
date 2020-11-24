<?php
/**
 * Created by PhpStorm.
 * User: josh
 * Date: 6/15/18
 * Time: 11:04 AM
 */

namespace Drupal\engineering_api\Plugin\resource\entity\node\udc;

use Drupal\restful\Plugin\resource\DataInterpreter\DataInterpreterInterface;
use Drupal\restful\Plugin\resource\Field\ResourceFieldInterface;
use Drupal\restful\Plugin\resource\ResourceEntity;
use Drupal\restful\Plugin\resource\ResourceInterface;

/**
 * Class UDC
 * @package Drupal\engineering_api\Plugin\resource\entity\node\udc
 *
 * @Resource(
 *   name = "udc:1.0",
 *   resource = "udc",
 *   label = "University departments, centers, and programs",
 *   description = "University departments, centers, and programs.",
 *   authenticationTypes = TRUE,
 *   authenticationOptional = TRUE,
 *   dataProvider = {
 *     "entityType": "taxonomy_term",
 *     "bundles": {
 *       "engineering_departments",
 *       "engineering_centers",
 *       "affiliated_department",
 *       "affiliated_center",
 *       "interdisciplinary_programs",
 *     },
 *     "sort": {
 *      "name": "ASC"
 *      }
 *   },
 *   majorVersion = 1,
 *   minorVersion = 0
 * )
 */
class UDC__1_0 extends ResourceEntity implements ResourceInterface
{

    /**
     * {@inheritdoc}
     **/

    protected function publicFields()
    {
        $public_fields = parent::publicFields();

        unset($public_fields['label']);

        // Rename label
        $public_fields['name'] = array(
            'wrapper_method' => 'label',
            'wrapper_method_on_entity' => TRUE,

        );

        $public_fields['description'] = array(
            'property' => 'description',
            'process_callbacks' => array('strip_tags'),
        );

        $public_fields['url'] = $public_fields['path'];
        $public_fields['url'] = array(
            'property' => 'url',
        );


        return $public_fields;
    }
}

