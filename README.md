The config file can now be exported using the command listed below, creating a postpackage.php file in the config directory of the Laravel project in which the package was required.

```cmd
php artisan vendor:publish --provider="Freziertz\PostPackage\PostServiceProvider" --tag="config"

```


The migrations of this package are now publishable under the "migrations" tag via:


```cmd
php artisan vendor:publish --provider="Freziertz\PostPackage\PostServiceProvider" --tag="migrations"

```