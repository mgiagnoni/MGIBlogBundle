MGIBlogBundle
=============

A blog bundle for Symfony 2 and Doctrine 2. It also provides a practical
example of the features of `LyraAdminBundle`_.

Dependencies
------------

The blog backend is managed by `LyraAdminBundle`_.
The bundle uses `StofDoctrineExtensionsBundle`_ to *urlify* blog post titles.

.. _LyraAdminBundle: https://github.com/mgiagnoni/LyraAdminBundle
.. _StofDoctrineExtensionsBundle: https://github.com/stof/StofDoctrineExtensionsBundle

Installation
============

Install source code
-------------------

You can use Composer (easier) or perform a manual installation with git.

With Composer
~~~~~~~~~~~~~

Add the following line to the ``composer.json`` file in your project root
folder::

    {
        //...

        "require": {
            //...
            "mgiagnoni/blog-bundle" : "dev-master"
        }

        //...
    }

Get Composer, unless it's already present::

    curl -s http://getcomposer.org/installer | php

Install the bundle with::

    php composer.phar update mgiagnoni/blog-bundle

**MGIBlogBundle** and all its dependencies will be installed.

With git
~~~~~~~~

Install `LyraAdminBundle`_ and `StofDoctrineExtensionsBundle`_ (instructions
are in bundles docs).

Then install MGIBlogBundle, from your project root folder run::

    git submodule add git://github.com/mgiagnoni/MGIBlogBundle.git vendor/bundles/MGI/BlogBundle

To install the bundle as git submodule your whole project must be under version
control with git or the command ``git submodule add`` will return an error. In
this case, you can simply clone the repository::

    git clone git://github.com/mgiagnoni/MGIBlogBundle.git vendor/bundles/MGI/BlogBundle

Register namespace
------------------

This step must be entirely omitted if you have used Composer.

Register ``MGI`` namespace for use by the autoloader::

    // app/autoload.php

    $loader->registerNamespaces(array(
        // other namespaces
        'MGI'  => __DIR__.'/../vendor/bundles',
    ));

    // ...

Add bundles to application kernel
--------------------------------

::

    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // other bundles
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new Lyra\AdminBundle\LyraAdminBundle(),
            new MGI\BlogBundle\MGIBlogBundle(),
        );

    // ...

Import routing configuration
----------------------------

::

    # app/config/routing.yml

    LyraAdminBundle:
        resource: "@LyraAdminBundle/Resources/config/routing.yml"

    MGIBlogBundle:
        resource: "@MGIBlogBundle/Resources/config/routing.yml"
        prefix: /blog


Import admin configuration
--------------------------

A file containing all the configuration options for the backend area
managed by LyraAdminBundle is included in the bundle and must be
imported in your application configuration::

    # app/config/config.yml

    imports:
        - { resource: '@MGIBlogBundle/Resources/config/lyra_admin.yml'}

Enable sluggable listener
-------------------------

::

    # app/config/config.yml

    stof_doctrine_extensions:
        orm:
            # change below if you don't use default entity manager
            default:
                sluggable: true

Publish bundle assets
---------------------

::

    app/console assets:install web

Update database schema
----------------------

::

    app/console doctrine:schema:update

Go to backend area
------------------

::

    http://.../app_dev.php/admin/post/list

Backend is managed by LyraAdminBundle. Add some test posts.

Frontend
--------

::

    http://.../app_dev.php/blog

``blog`` is the prefix used when importing bundle routing file.
