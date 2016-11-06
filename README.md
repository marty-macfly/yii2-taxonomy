# yii2-taxonomy

Yii2 Taxonomy management. A component which adds generic taxonomy functionalities to your application. The component comes with a couple of term definitions(tags, properties). Those definitions can be enable on any models by adding the chossen behavior. This extension depends of [yii2-taxonomy-term](https://github.com/mhndev/yii2-taxonomy-term) (by [mhndev](https://github.com/mhndev)).

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist macfly/yii2-taxonomy "*"
```

or add

```
"macfly/yii2-taxonomy": "*"
```

to the require section of your `composer.json` file.

Migration
------------

```
php yii migrate --migrationPath=@vendor/mhndev/yii2-taxonomy-term/src/migrations
```

Usage
------------

## Configuring to use Term

Configure model as follows

```php
use macfly\taxonomy\behaviors\BaseTermBehavior;

/**
 * ...
 * @property array $terms
 */
class Post extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
        				BaseTermBehavior::className(),
								...
            ],
        ];
    }

}
```

### get terms of an entity
```php
    $post = Post::findOne(['id'=>1]);
    $post->terms;

```

### set terms of an entity (will remove all other term)
```php
    $post = Post::findOne(['id'=>1]);
		$terms = [
				Term::findOne(1),
				Term::findOne(12),
			];
    $post->terms = $terms;

```

### detach a term from an entity
```php
    $term = Term::findOne(['id'=>1]);
    $post = Post::findOne(['id'=>1]);
    $post->delTerm($term);

```

### check if term exist on entity
```php
    $term = Term::findOne(['id'=>1]);
    $post = Post::findOne(['id'=>1]);
    $post->hasTerm($term);

```

### add term to an entity (will keep others term)
```php
    $term = Term::findOne(['id'=>1]);
    $post = Post::findOne(['id'=>1]);
    $post->addTerm($term);

```

## Configuring to use Property and Term

Properties are taxonomy of defined 'type' and they have name and value. You can add multiple properties to an item. And a property can have multiple 'name' and values to an item.

Configure model as follows

```php
use macfly\taxonomy\behaviors\PropertyTermBehavior;

/**
 * ...
 * @property array $terms
 * @property array $envs
 */
class Post extends \yii\db\ActiveRecord
{   
    public function behaviors()
    {   
        return [
                PropertyTermBehavior::className(),
                ...
            ],
        ];
    }


		# Define the get method of property 'env'
		public function getEnvs()
		{
			return $this->getPropertyTerms('env');
		}

		# Define the set method of property 'env'
		public function setEnvs($terms)
		{
			return $this->setPropertyTerms('env', $terms);
		}

		# Add term by name and value
		public function addEnv($name, $value)
		{
			return $this->addPropertyTerm('env', $name, $value);
		}

		# Detach term by name and value
		public function delEnv($name, $value)
		{
			return $this->delPropertyTerm('env', $name, $value);
		}

		# Has term by name and value
		public function hasEnv($name, $value)
		{
			return $this->hasPropertyTerm('env', $name, $value);
		}

}
```

### get terms for property 'env' of an entity
```php
    $post = Post::findOne(['id'=>1]);
    $post->envs;

```

### set terms for property 'env' of an entity (will remove all other term for property 'env')
```php
    $post = Post::findOne(['id'=>1]);
    $terms = [
        Term::findOne(1),
        Term::findOne(12),
      ];
    $post->envs = $terms;

```

### detach property 'env' by is name and value from an entity (if you want to detach it by term, just use delTerm($term))
```php
    $post = Post::findOne(['id'=>1]);
    $post->delEnv('PWD', '/home/test/');

```

### check if property 'env' exist by name and value on entity (if you want to check it by term, just use hasTerm($term))
```php
    $post = Post::findOne(['id'=>1]);
    $post->hasEnv('PWD', '/home/test');

```

### add property 'env' by name and value to an entity (will keep others term, if you want to add it by term, just use addTerm($term))
```php
    $post = Post::findOne(['id'=>1]);
    $post->addEnv('PWD', '/home/test');

```

# Configuring to use Tags, Property and Term

Basically tags represent properties of type 'tag' and name 'name'.  You can add multiple tags to an item.

Configure model as follows

```php
use macfly\taxonomy\behaviors\TagTermBehavior;

/**
 * ...
 * @property array $terms
 * @property array $tags
 */
class Post extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
                TagTermBehavior::className(),
                ...
            ],
        ];
    }

}
```

You can change 'tag' taxonomy type and name for a specific model with the following :

```php
use macfly\taxonomy\behaviors\TagTermBehavior;

/**
 * ...
 * @property array $terms
 * @property array $tags
 */
class Post extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            'tag' => [
                'class' => TagBehavior::className(),
             		'type' => 'myposttagtype',
             		'name' => 'myposttagname',
            ],
        ];
    }
}
```

### get tags of an entity
```php
    $post = Post::findOne(['id'=>1]);
    $post->tags;

```

### set tags of an entity (will remove all other term)
```php
    $post = Post::findOne(['id'=>1]);
    $post->tags = ['tags1', 'tag2', 'test'];
// Or
    $post->tags = 'tags1,tag2,test';
```

### detach a tag from an entity
```php
    $post = Post::findOne(['id'=>1]);
    $post->delTag('tags1');

```

### check if tag exist on entity
```php
    $post = Post::findOne(['id'=>1]);
    $post->hasTag('test');

```

### add tag to an entity (will keep others tag)
```php
    $post = Post::findOne(['id'=>1]);
    $post->addTag('foo');

```

