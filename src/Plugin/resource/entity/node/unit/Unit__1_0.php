<?php
/**
 * Created by PhpStorm.
 * User: josh
 * Date: 6/15/18
 * Time: 9:27 AM
 */

namespace Drupal\engineering_api\Plugin\resource\entity\node\unit;


use Drupal\restful\Plugin\resource\DataInterpreter\DataInterpreterInterface;
use Drupal\restful\Plugin\resource\Field\ResourceFieldInterface;
use Drupal\restful\Plugin\resource\ResourceEntity;
use Drupal\restful\Plugin\resource\ResourceInterface;

/**
 * Class Unit
 * @package Drupal\engineering_api\Plugin\resource\entity\node\unit
 *
 * @Resource(
 *   name = "unit:1.0",
 *   resource = "unit",
 *   label = "Unit",
 *   description = "School of Engineering and Applied Science departments and centers.",
 *   authenticationTypes = TRUE,
 *   authenticationOptional = TRUE,
 *   dataProvider = {
 *     "entityType": "taxonomy_term",
 *     "bundles": {
 *       "engineering_departments",
 *       "engineering_centers",
 *     },
 *     "sort": {
 *      "name": "ASC"
 *      }
 *   },
 *   majorVersion = 1,
 *   minorVersion = 0
 * )
 */
class Unit__1_0 extends ResourceEntity implements ResourceInterface
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

