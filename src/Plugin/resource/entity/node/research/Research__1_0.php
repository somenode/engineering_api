<?php
/**
 * Created by PhpStorm.
 * User: josh
 * Date: 6/13/18
 * Time: 4:30 PM
 */

namespace Drupal\engineering_api\Plugin\resource\entity\node\research;

use Drupal\restful\Plugin\resource\DataInterpreter\DataInterpreterInterface;
use Drupal\restful\Plugin\resource\Field\ResourceFieldInterface;
use Drupal\restful\Plugin\resource\ResourceEntity;
use Drupal\restful\Plugin\resource\ResourceInterface;

/**
 * Class Research
 * @package Drupal\engineering_api\Plugin\resource\entity\node\research
 *
 * @Resource(
 *   name = "research:1.0",
 *   resource = "research",
 *   label = "Research",
 *   description = "School of Engineering and Applied Science research areas.",
 *   authenticationTypes = TRUE,
 *   authenticationOptional = TRUE,
 *   dataProvider = {
 *     "entityType": "taxonomy_term",
 *     "bundles": {
 *       "engineering_impact"
 *     },
 *     "sort": {
 *      "name": "ASC"
 *      }
 *   },
 *   majorVersion = 1,
 *   minorVersion = 0
 * )
 */
class Research__1_0 extends ResourceEntity implements ResourceInterface
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