# YumYum

**Installation**

1. Setup this GitHub repo as a composer repository in your `composer.json`.

```json
"repositories": [
    {
        "type": "vcs",
        "url":  "git@github.com:doublethreedigital/yumyum.git"
    },
]
```

2. Add this package to your list of `require`ments in your `composer.json`

```json
"require": {
    ...
    "doublethreedigital/yumyum": "dev-master"
},
```

3. Install with Composer - `composer install`

4. You should now be able to configure a feed in your Control Panel and run the feed from inside there.

**Example of feed**
Until the whole feed creation process is actually ready, you can create a `.yaml` in your `content/feeds` folder with the contents similar to:

```yaml
id: 08af8d74-75ba-43d5-9ed5-2f80fad417fc
name: 'Commonwealth Cast'
type: rss
source: 'https://feeds.transistor.fm/commonwealth-cast'
destination:
  type: entries
  collection: podcast
```

Once you clear the cache `php artisan cache:clear`, you should be able to see and run the feed in your control panel.
