# Engineering API

This module creates custom endpoints to serve content as JSON. It is also able to access content stored in "[paragraph entities](https://www.drupal.org/project/paragraphs)" which is described in more detail below.

It was developed for the School of Engineering and Applied Science at Princeton University.

## Requirements

- [Drupal 7](https://www.drupal.org/drupal-7.0)
- [RESTful](https://github.com/RESTful-Drupal/restful)

## Declaring a REST Endpoint

The RESTful project has [excellent documentation](https://github.com/RESTful-Drupal/restful#declaring-a-rest-endpoint) to begin this process.

## Configuring Custom Entity References

In order to retrieve content defined as an entity, we must create a custom resource plugin.

### Referencing taxonomies

The news content type includes many-to-many relationships that reference sets of taxonomies. In order to include these relationships in an endpoint, a custom resource plugin must be defined.
<br>
<br>

```
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
class Research__1_0 extends ResourceEntity implements ResourceInterface {
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
```

### After defining a custom taxonomy plugin, use it in your resource.

```
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
```

<br>
<br>

#### Snippet of JSON response before adding taxonomy plugin (full field list above)

<br>

```
{
	"id": 8212,
	"self": "https://engineering.princeton.edu/api/v1.2/news/8212",
	"title": "Machine learning guarantees robots’ performance in unknown territory",
	"publish_date": "2020-11-17 00:00:00",
	"news_author": "Molly Sharlach",
	"url": "https://engineering.princeton.edu/news/2020/11/17/machine-learning-guarantees-robots-performance-unknown-territory",
	"summary": "As engineers increasingly turn to machine learning methods to develop adaptable robots, new work by Princeton University researchers makes progress on safety and performance guarantees for robots operating in novel environments with diverse types of obstacles and constraints"
}
```

#### Snippet of JSON response after adding taxonomy plugin

```
{
	"id": 8212,
	"self": "https://engineering.princeton.edu/api/v1.2/news/8212",
	"title": "Machine learning guarantees robots’ performance in unknown territory",
	"publish_date": "2020-11-17 00:00:00",
	"news_author": "Molly Sharlach",
	"url": "https://engineering.princeton.edu/news/2020/11/17/machine-learning-guarantees-robots-performance-unknown-territory",
	"summary": "As engineers increasingly turn to machine learning methods to develop adaptable robots, new work by Princeton University researchers makes progress on safety and performance guarantees for robots operating in novel environments with diverse types of obstacles and constraints.",
	"research": [{
			"id": "19",
			"self": "https://engineering.princeton.edu/api/v1.0/research/19",
			"name": "Data Science",
			"description": "Research in data science at Princeton integrates three strengths: the fundamental mathematics of machine learning; the interdisciplinary application of machine learning to solve a wide range of real-world problems; and deep examination and innovation regarding the societal implications of artificial intelligence, including issues such as bias, equity, and privacy.\n",
			"url": "https://engineering.princeton.edu/research/data-science"
		},
		{
			"id": "16",
			"self": "https://engineering.princeton.edu/api/v1.0/research/16",
			"name": "Robotics and Cyberphysical Systems",
			"description": "The use of robots is moving rapidly beyond controlled environments such as factories to complex environments in the midst of human activity, demanding a nimble cross-disciplinary approach. Research in this area at Princeton includes computer vision, dynamics and control, integrated electronic systems, internet of things, smart cities, and stochastic control. The goal is to advance the productive, safe, and ethical use of robotics by connecting expertise in sensing, artificial intelligence, neuroscience, public policy, and other fields.\n",
			"url": "https://engineering.princeton.edu/research/robotics-and-cyberphysical-systems"
		}
	]
}
```

### Referencing paragraphs

Use the same approach by defining a custom plugin and using the paragraphs namespace.

```
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
 *   name = "lede:1.0",
 *   resource = "lede",
 *   label = "Lede",
 *   description = "Paragraph type: Lede",
 *   authenticationOptional = TRUE,
 *   dataProvider = {
 *     "entityType": "paragraphs_item",
 *     "bundles": {
 *       "news_lede"
 *     },
 *     "sort": {
 *       "item_id": "DESC"
 *     },
 *   },
 *   majorVersion = 1,
 *   minorVersion = 0
 * )
 */
class lede__1_0 extends ResourceEntity implements ResourceInterface {
    /**
     * Overrides ResourceNode::publicFields().
     */
    protected function publicFields() {
        $public_fields = parent::publicFields();

        if (!is_null($this->getEntityType()) == 'paragraphs_item') {
            // Fetch the lede
            $public_fields['lede_content'] = [
                'property' => 'field_news_content',
            ];
        }

        return $public_fields;
    }
}
```

<br>
<br>

#### Snippet of JSON response before adding paragraph plugin

<br>

```
{
	"id": 8212,
	"self": "https://engineering.princeton.edu/api/v1.2/news/8212",
	"title": "Machine learning guarantees robots’ performance in unknown territory",
	"publish_date": "2020-11-17 00:00:00",
	"news_author": "Molly Sharlach",
	"url": "https://engineering.princeton.edu/news/2020/11/17/machine-learning-guarantees-robots-performance-unknown-territory",
	"summary": "As engineers increasingly turn to machine learning methods to develop adaptable robots, new work by Princeton University researchers makes progress on safety and performance guarantees for robots operating in novel environments with diverse types of obstacles and constraints."
}
```

#### Snippet of JSON response after adding paragraph plugin

<br>
<br>

```
{
    "id": 8212,
	"self": "https://engineering.princeton.edu/api/v1.2/news/8212",
	"title": "Machine learning guarantees robots’ performance in unknown territory",
	"publish_date": "2020-11-17 00:00:00",
	"news_author": "Molly Sharlach",
	"url": "https://engineering.princeton.edu/news/2020/11/17/machine-learning-guarantees-robots-performance-unknown-territory",
	"summary": "As engineers increasingly turn to machine learning methods to develop adaptable robots, new work by Princeton University researchers makes progress on safety and performance guarantees for robots operating in novel environments with diverse types of obstacles and constraints.\n",
	"lede": [{
		"id": "5011",
		"label": "",
		"self": "https://engineering.princeton.edu/api/v1.0/lede/5011",
		"lede_content": "A small drone takes a test flight through a space filled with randomly placed cardboard cylinders acting as stand-ins for trees, people or structures. The algorithm controlling the drone has been trained on a thousand simulated obstacle-laden courses, but it’s never seen one like this. Still, nine times out of 10, the pint-sized plane dodges all the obstacles in its path."
	}]
}
```

## Note

This module was developed exclusively for the School of Engineering and Applied Science in a Drupal 7 environment using [RESTful](https://github.com/RESTful-Drupal/restful) as a foundation. Adapting it for your use case is possible, though you should probably use [Drupal 8](https://www.drupal.org/8).

The RESTful module used here inspired the development of [Drupal 8's own version](https://www.drupal.org/docs/8/core/modules/rest/overview) which uses a similar approach in designing restful APIs.
