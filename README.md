The config file can now be exported using the command listed below, creating a postpackage.php file in the config directory of the Laravel project in which the package was required.

```cmd
php artisan vendor:publish --provider="Freziertz\PostPackage\PostServiceProvider" --tag="config"

```


The migrations of this package are now publishable under the "migrations" tag via:


```cmd
php artisan vendor:publish --provider="Freziertz\PostPackage\PostServiceProvider" --tag="migrations"

```

The view can be exported by user of our package as follows.

```cmd

php artisan vendor:publish --provider="Freziertz\PostPackage\PostServiceProvider" --tag="views"

```


The assets can then be exported by users of our package using:

```cmd

php artisan vendor:publish --provider="Freziertz\PostPackage\PostServiceProvider" --tag="assets"

```

We can reference the stylesheet and javascript file in our views as follows:



```cmd

<script src="{{ asset('blogpackage/js/app.js') }}"></script>
<link href="{{ asset('blogpackage/css/app.css') }}" rel="stylesheet" />

```