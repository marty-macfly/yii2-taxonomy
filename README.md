# yii2-taxonomy

Yii2 Taxonomy management. A component which adds generic taxonomy functionalities to your application. The component comes with a couple of term definitions(tags, properties). Those definitions can be enable on any models by adding the chossen behavior. This extension depends of [yii2-taxonomy-term](https://github.com/mhndev/yii2-taxonomy-term) (by [mhndev](https://github.com/mhndev)).

## Installation

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

## Migration

```
php yii migrate --migrationPath=@vendor/mhndev/yii2-taxonomy-term/src/migrations
```

## Usage

## Configuring to manage Taxonomy and Term in web interface

Configure **config/web.php** as follows

```php
'modules' => [
    ................
    'taxonomy' => [
        'class' => 'macfly\taxonomy\Module'
    ],
    ................
],
```

- Pretty Url's /taxonomy
- No pretty Url's index.php?r=taxonomy

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

Basically tags represent properties of type 'tag' and name 'name'. You can add multiple tags to an item.

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

## get tags of an entity

```php
$post = Post::findOne(['id'=>1]);
$post->tags;
```

## set tags of an entity (will remove all other term)

```php
$post = Post::findOne(['id'=>1]);
$post->tags = ['tags1', 'tag2', 'test'];
// Or
$post->tags = 'tags1,tag2,test';
```

## detach a tag from an entity

```php
$post = Post::findOne(['id'=>1]);
$post->delTag('tags1');
```

## check if tag exist on entity

```php
$post = Post::findOne(['id'=>1]);
$post->hasTag('test');
```

## add tag to an entity (will keep others tag)

```php
$post = Post::findOne(['id'=>1]);
$post->addTag('foo');
```

# Configuring to purge unused Term

Basically unused Term will be delete in the period of time (default is 30 day) it's help to remove useless tag.

Configure route for action **config/console.php** as follows:

```php
'modules' => [
    ................
    'taxonomy' => [
        'class' => 'macfly\taxonomy\Module'
    ],
    ................
],
```

Default term will be delete if _updated_at_ later than one month, if you want to define specific period time, just specify it on command line:

And you can add a cron job (<http://www.crontab-generator.org/>) to run at _00:00 on every Sunday_ with some controller action like this:

on **Linux:**

```bash
    0 0 * * 0 /path/to/yii/application/yii taxonomy/term/clear 50 >> /var/log/console-app.log 2>&1
```

on **Window Task Schedule:**

```bash
    /path/to/yii/application/yii taxonomy/term/clear
```
