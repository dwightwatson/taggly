Taggly, a tag cloud generator
=============================

Taggly is a modern port of the old CodeIgniter Taggly library by [Gavin Vickery](http://qompile.com/resources-downloads). Packaged with a service provider and facade for Laravel, this package is totally framework agnostic and will help you to generate tag clouds just like the cool kids. Note, styling the cloud is up to you!

# Installation

Simply add the package to your `composer.json` file and run `composer update`.

```
"watson/taggly": "1.0.*"
```

If you're using Laravel, be sure to register the service provider and facade if you would like to use those.

Under providers:

```
'Watson\Taggly\TagglyServiceProvider',
```

And under aliases:

```
'Tag' => 'Watson\Taggly\TagFacade',
```

## Overview

First, let's look at what makes up a tag in Taggly. A tag is made up of 3 things:

* the tag name
* the number of times it occurs, or it's weight
* the path it should link to (optional)

You can either use an associative array or a `Watson\Taggly\Tag` object to represent a single tag. Here is how you represent a tag as an associative array:

    $tag = array('tag' => 'Laravel', 'count' => 4, 'url' => 'https://www.laravel.com');

Simply passing this array to a new Tag object to use an object instead.

    $tag = new Watson\Taggly\Tag($tag);

Once you have a collection of tags, you can pass them to Taggly and generate a cloud.

    $taggly = new Watson\Taggly\Taggly;
    $taggly->setTags([$tag1, $tag2, ...]);

    echo $taggly->cloud();

You can also just pass the tags to the `cloud()` method, which is great if you're using the facade too.

    Tag::cloud($tags);