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

<br>
<br>
After defining a custom taxonomy plugin, create a new plugin which will use the newly defined taxonomy resource. 
<br>
<br>

```
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
```

<br>
<br>

### Snippet of JSON response before plugin

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
	"featured_image": {
		"id": "3109",
		"self": "https://engineering.princeton.edu/sites/default/files/robotics-compressed.gif",
		"filemime": "image/gif",
		"filesize": "4833463",
		"width": "700",
		"height": "421",
		"styles": {
			"thumbnail": "https://engineering.princeton.edu/sites/default/files/styles/thumbnail/public/robotics-compressed.gif?itok=zzvlFcLY",
			"medium": "https://engineering.princeton.edu/sites/default/files/styles/medium/public/robotics-compressed.gif?itok=UIlxFlfQ",
			"large": "https://engineering.princeton.edu/sites/default/files/styles/large/public/robotics-compressed.gif?itok=0EOdgj4T"
		}
	},
	"featured_image_caption": "Princeton researchers tested a new machine learning approach for guaranteeing robots’ safety and success in unfamiliar settings. Experiments included programming a small drone called a Parrot Swing to avoid obstacles while flying down a 60-foot-long corridor. Video by the Intelligent Robot Motion Lab; GIF by Josh Cartagena",
	"hide_featured_image": "false"
}
```

<br>
### Snippet of JSON response after 
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
	"featured_image": {
		"id": "3109",
		"self": "https://engineering.princeton.edu/sites/default/files/robotics-compressed.gif",
		"filemime": "image/gif",
		"filesize": "4833463",
		"width": "700",
		"height": "421",
		"styles": {
			"thumbnail": "https://engineering.princeton.edu/sites/default/files/styles/thumbnail/public/robotics-compressed.gif?itok=zzvlFcLY",
			"medium": "https://engineering.princeton.edu/sites/default/files/styles/medium/public/robotics-compressed.gif?itok=UIlxFlfQ",
			"large": "https://engineering.princeton.edu/sites/default/files/styles/large/public/robotics-compressed.gif?itok=0EOdgj4T"
		}
	},
	"featured_image_caption": "Princeton researchers tested a new machine learning approach for guaranteeing robots’ safety and success in unfamiliar settings. Experiments included programming a small drone called a Parrot Swing to avoid obstacles while flying down a 60-foot-long corridor. Video by the Intelligent Robot Motion Lab; GIF by Josh Cartagena",
	"hide_featured_image": "false",
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

## Note

This module was developed exclusively for the School of Engineering and Applied Science in a Drupal 7 environment using [RESTful](https://github.com/RESTful-Drupal/restful) as a foundation. Adapting it for your use case is possible, though you should probably use [Drupal 8](https://www.drupal.org/8).

The RESTful module used here inspired the development of [Drupal 8's own version](https://www.drupal.org/docs/8/core/modules/rest/overview) which uses a similar approach in designing restful APIs.
