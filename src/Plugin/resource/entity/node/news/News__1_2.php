<?php
/**
 * Created by PhpStorm.
 * User: josh
 * Date: 6/14/18
 * Time: 12:30 PM
 */

/**
 * @file
 * Contains \Drupal\engineering_api\Plugin\resource\entity\node\news\News__1_2.
 */

namespace Drupal\engineering_api\Plugin\resource\entity\node\news;
use Drupal\restful\Plugin\resource\Field\ResourceFieldBase;
use Drupal\restful\Plugin\resource\ResourceInterface;

/**
 * Class News__1_2
 * @package Drupal\engineering_api\Plugin\resource\entity\node\news
 *
 * @Resource(
 *   name = "news:1.2",
 *   resource = "news",
 *   label = "News",
 *   description = "School of Engineering and Applied Science news stories.",
 *   authenticationOptional = TRUE,
 *   dataProvider = {
 *     "entityType": "node",
 *     "bundles": {
 *       "news"
 *     },
 *     "sort" = {
 *      "publish_date": "DESC",
 *      }
 *   },
 *   majorVersion = 1,
 *   minorVersion = 2
 * )
 */
class News__1_2 extends News__1_1 implements ResourceInterface {

    /**
     * Overrides ResourceEntity::publicFields().
     */
    protected function publicFields() {
        $public_fields = parent::publicFields();


        $public_fields['research']['resource']['name'] = 'research';
        $public_fields['faculty']['resource']['name'] = 'faculty';
        $public_fields['department']['resource']['name'] = 'unit';
        $public_fields['center']['resource']['name'] = 'unit';
        $public_fields['series']['resource']['name'] = 'series';
        $public_fields['series']['resource']['name'] = 'eqn';


        return $public_fields;
    }

}
