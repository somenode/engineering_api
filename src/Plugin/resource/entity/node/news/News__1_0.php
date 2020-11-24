<?php
/**
 * @file
 * Contains \Drupal\engineering_api\Plugin\resource\entity\node\impact\News__1_0.
 */

namespace Drupal\engineering_api\Plugin\resource\entity\node\news;

use Drupal\restful\Plugin\resource\Field\ResourceFieldEntityReference;
use Drupal\restful\Plugin\resource\Field\ResourceFieldEntityReferenceInterface;
use Drupal\restful\Plugin\resource\ResourceNode;
use Drupal\restful\Plugin\resource\ResourceInterface;
use Drupal\restful\Plugin\resource\ResourceEntity;

/**
 * Class Impact__1_0
 * @package Drupal\engineering_api\Plugin\resource\entity\node\news
 *
 * @Resource(
 *   name = "news:1.0",
 *   resource = "news",
 *   label = "News",
 *   description = "School of Engineering and Applied Science news stories.",
 *   authenticationTypes = TRUE,
 *   authenticationOptional = TRUE,
 *   dataProvider = {
 *     "entityType": "node",
 *     "bundles": {
 *       "news"
 *     },
 *   },
 *   majorVersion = 1,
 *   minorVersion = 0
 * )
 */


class News__1_0 extends ResourceEntity implements ResourceInterface  {


}