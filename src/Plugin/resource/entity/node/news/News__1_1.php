<?php
/**
 * Created by PhpStorm.
 * User: josh
 * Date: 6/14/18
 * Time: 12:30 PM
 */

namespace Drupal\engineering_api\Plugin\resource\entity\node\news;
use Drupal\restful\Plugin\resource\Field\ResourceFieldBase;
use Drupal\restful\Plugin\resource\ResourceInterface;

/**
 * Class News__1_1
 * @package Drupal\engineering_api\Plugin\resource\entity\node\news
 *
 * @Resource(
 *   name = "news:1.1",
 *   resource = "news",
 *   label = "News",
 *   description = "School of Engineering and Applied Science news stories.",
 *   authenticationOptional = TRUE,
 *   dataProvider = {
 *     "entityType": "node",
 *     "bundles": {
 *       "news"
 *     },
 *   },
 *   majorVersion = 1,
 *   minorVersion = 1
 * )
 */
class News__1_1 extends News__1_0 implements ResourceInterface {

    /**
     * Overrides ResourceEntity::publicFields().
     */
    protected function publicFields() {
        $public_fields = parent::publicFields();

        // Rename label
        $public_fields['title'] = $public_fields['label'];
        unset($public_fields['label']);

        $public_fields['publish_date'] = array(
            'property' => 'field_publish_date',
            'formatter' => array(
                'type' => 'date_plain',
            )
        );

        $public_fields['news_author'] = array(
            'property' => 'field_news_author'
        );


        $public_fields['url'] = $public_fields['path'];
        $public_fields['url'] = array(
            'property' => 'url',
        );

        // Expose summary
        $public_fields['summary'] = array(
            'property' => 'field_summary',
            'sub_property' => 'value',
            'process_callbacks' => array('strip_tags'),
        );

        $public_fields['lede'] = [
            'property' => 'field_news',
            'resource' => [
                'name' => 'lede',
                'fullView' => TRUE,
                'majorVersion' => 1,
                'minorVersion' => 0
            ]
        ];

        $public_fields['content'] = [
            'property' => 'field_news',
            'resource' => [
                'name' => 'news_content',
                'fullView' => TRUE,
                'majorVersion' => 1,
                'minorVersion' => 0
            ]
        ];

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

        $public_fields['featured_image_caption'] = array(
            'property' => 'field_hero_image_caption'
        );

        $public_fields['hide_featured_image'] = array(
            'property' => 'field_hide_featured_image'
        );

        $public_fields['research'] = array(
            'property' => 'field_topics',
            'wrapper_method' => 'getIdentifier',
        );

        $public_fields['faculty'] = array(
            'property' => 'field_related_people',
            'wrapper_method' => 'getIdentifier',
        );

        $public_fields['department'] = array(
            'property' => 'field_department',
            'wrapper_method' => 'getIdentifier',
        );

        $public_fields['center'] = array(
            'property' => 'field_center',
            'wrapper_method' => 'getIdentifier',
        );


        $public_fields['eqn'] = array(
            'property' => 'field_eqn_reference',
            'wrapper_method' => 'getIdentifier',
        );

        $public_fields['series'] = array(
            'property' => 'field_series',
            'wrapper_method' => 'getIdentifier',
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
    public function imageProcess($value) {
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
