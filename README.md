# FlexPress popular posts component

## Install via pimple
```
$pimple['popularPostsHelper'] = function() {
    return new PopularPosts();
};
```

## Usage

```
$popularPostsHelper = $pimple['popularPostsHelper'];
$popularPosts = $popularPostsHelper->getPopular('post');
```

The getPopular method takes 3 params:
- The post type, can be an array/string, defaults to any.
- The total results you want back, defaults to five.
- How many to offset the results by, defaults to zero.