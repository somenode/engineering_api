<?php
/**
 * Created by PhpStorm.
 * User: josh
 */

namespace Drupal\engineering_api\Plugin\resource\entity\node\eqn;
use Drupal\restful\Plugin\resource\Field\ResourceFieldBase;
use Drupal\restful\Plugin\resource\ResourceInterface;
use Drupal\restful\Plugin\resource\ResourceEntity;

/**
 * Class Series
 * @package Drupal\engineering_api\Plugin\resource\entity\node\eqn
 *
 * @Resource(
 *   name = "eqn:1.0",
 *   resource = "eqn",
 *   label = "EQN",
 *   description = "School of Engineering and Applied Science EQN.",
 *   authenticationTypes = TRUE,
 *   authenticationOptional = TRUE,
 *   dataProvider = {
 *     "entityType": "node",
 *     "bundles": {
 *       "equad_news"
 *     },
 *   },
 *   majorVersion = 1,
 *   minorVersion = 0
 * )
 */


class EQN__1_0 extends ResourceEntity implements ResourceInterface {

    /**
     * {@inheritdoc}
     **/

    protected function publicFields()
    {
        $public_fields = parent::publicFields();


        // Rename label
        $public_fields['issue'] = $public_fields['label'];
        unset($public_fields['label']);

        $public_fields['publish_season'] = array(
            'property' => 'field_eqn_publication_season',
        );

        $public_fields['publish_year'] = array(
            'property' => 'field_eqn_publication_year',
        );

        $public_fields['volume'] = array(
            'property' => 'field_eqn_volume',
        );

        $public_fields['number'] = array(
            'property' => 'field_eqn_number',
        );

//        $public_fields['pdf'] = array(
//            'property' => 'field_eqn_pdf',
//        );

        $public_fields['publish_date'] = array(
            'property' => 'field_publish_date',
            'formatter' => array(
                'type' => 'date_plain',
            )
        );

        $public_fields['summary'] = array(
            'property' => 'field_summary',
        );

        $public_fields['content'] = array(
            'property' => 'body',
        );

        $public_fields['refer_text'] = array(
            'property' => 'field_series_refer_text',
        );

        $public_fields['featured_image'] = array(
            'property' => 'field_hero_img',
            'process_callbacks' => array(
                array($this, 'imageProcess'),
            ),
            'image_styles' => array('thumbnail', 'medium', 'large'),
        );

        // By checking that the field exists, we allow re-using this class on
        // different tests, where different fields exist.
        if (field_info_field('field_images')) {
            $public_fields['images'] = array(
                'property' => 'field_images',
                'process_callbacks' => array(
                    array($this, 'imageProcess'),
                ),
                'image_styles' => array('thumbnail', 'medium', 'large'),
            );
        }

        $public_fields['url'] = $public_fields['path'];
        $public_fields['url'] = array(
            'property' => 'url',
        );

        return $public_fields;
    }

    /**
     * Process callback, Remove Drupal specific items from the image array.
     *
     * @param array $value
     *   The image array.
     *
     * @return array
     *   A cleaned image array.
     */
    public function imageProcess($value)
    {
        if (ResourceFieldBase::isArrayNumeric($value)) {
            $output = array();
            foreach ($value as $item) {
                $output[] = $this->imageProcess($item);
            }
            return $output;
        }
        return array(
            'id' => $value['fid'],
            'self' => file_create_url($value['uri']),
            'filemime' => $value['filemime'],
            'filesize' => $value['filesize'],
            'width' => $value['width'],
            'height' => $value['height'],
            'styles' => $value['image_styles'],
        );
    }


}