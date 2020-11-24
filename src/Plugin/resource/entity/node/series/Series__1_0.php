<?php
/**
 * Created by PhpStorm.
 * User: josh
 */

namespace Drupal\engineering_api\Plugin\resource\entity\node\series;
use Drupal\restful\Plugin\resource\Field\ResourceFieldBase;
use Drupal\restful\Plugin\resource\ResourceInterface;
use Drupal\restful\Plugin\resource\ResourceEntity;

/**
 * Class Series
 * @package Drupal\engineering_api\Plugin\resource\entity\node\series
 *
 * @Resource(
 *   name = "series:1.0",
 *   resource = "series",
 *   label = "Series",
 *   description = "School of Engineering and Applied Science series.",
 *   authenticationTypes = TRUE,
 *   authenticationOptional = TRUE,
 *   dataProvider = {
 *     "entityType": "node",
 *     "bundles": {
 *       "series"
 *     },
 *   },
 *   majorVersion = 1,
 *   minorVersion = 0
 * )
 */


class Series__1_0 extends ResourceEntity implements ResourceInterface {

    /**
     * {@inheritdoc}
     **/

    protected function publicFields()
    {
        $public_fields = parent::publicFields();


        // Rename label
        $public_fields['name'] = $public_fields['label'];
        unset($public_fields['label']);

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