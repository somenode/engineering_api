<?php
/**
 * @file
 * Contains \Drupal\engineering_api\Plugin\resource\paragraphs\news_content__1_0.
 */

namespace Drupal\engineering_api\Plugin\resource\paragraphs;
use Drupal\restful\Http\RequestInterface;
use Drupal\restful\Plugin\resource\Field\ResourceFieldBase;
use Drupal\restful\Plugin\resource\ResourceEntity;
use Drupal\restful\Plugin\resource\ResourceInterface;

/**
 * Class lede__1_0
 * @package Drupal\engineering_api\Plugin\resource\paragraphs
 *
 * @Resource(
 *   name = "news_content:1.0",
 *   resource = "news_content",
 *   label = "News Content",
 *   description = "Paragraph type: News Content",
 *   authenticationOptional = TRUE,
 *   dataProvider = {
 *     "entityType": "paragraphs_item",
 *     "bundles": {
 *       "news_text_12col"
 *     },
 *     "sort": {
 *       "item_id": "DESC"
 *     },
 *   },
 *   majorVersion = 1,
 *   minorVersion = 0
 * )
 */

class News_Content__1_0 extends ResourceEntity implements ResourceInterface
{
    /**
     * Overrides ResourceNode::publicFields().
     */
    protected function publicFields()
    {
        $public_fields = parent::publicFields();

        if (!is_null($this->getEntityType()) == 'paragraphs_item') {
            // Fetch the news content
            $public_fields['news_content'] = [
                'property' => 'field_news_content',
            ];
        }
        return $public_fields;
    }

}