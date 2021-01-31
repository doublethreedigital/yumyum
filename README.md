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
