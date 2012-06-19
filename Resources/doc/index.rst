MGIBlogBundle
=============

A blog bundle for Symfony 2 and Doctrine 2. It also provides a practical
example of the features of `LyraAdminBundle`_.

.. _LyraAdminBundle: https://github.com/mgiagnoni/LyraAdminBundle

Installation
============

Install `LyraAdminBundle`_ (instructions are in bundle docs).
To install MGIBlogBundle, from your project root folder run::

    git submodule add git://github.com/mgiagnoni/MGIBlogBundle.git vendor/bundles/MGI/BlogBundle

To install the bundle as git submodule your whole project must be under version
control with git or the command ``git submodule add`` will return an error. In
this case, you can simply clone the repository::

    git clone git://github.com/mgiagnoni/MGIBlogBundle.git vendor/bundles/MGI/BlogBundle

Register namespace
------------------

``MGI`` namespace must be registered for use by the autoloader::

    // app/autoload.php

    $loader->registerNamespaces(array(
        // other namespaces
        'MGI'  => __DIR__.'/../vendor/bundles',
    ));

    // ...

Add bundle to application kernel
--------------------------------

::

    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // other bundles
            new MGI\BlogBundle\MGIBlogBundle(),
        );

    // ...

Import routing configuration
----------------------------

::

    # app/config/routing.yml

    MGIBlogBundle:
        resource: "@MGIBlogBundle/Resources/config/routing.yml"
        prefix: /blog

Publish bundle assets
---------------------

::

    app/console assets:install web

Update database schema
----------------------

::

    app/console doctrine:schema:update

Import admin configuration
--------------------------

A file containing all the configuration options for the backend area
managed by LyraAdminBundle is included in the bundle and must be
imported in your application configuration::

    # app/config/config.yml

    imports:
        - { resource: '@MGIBlogBundle/Resources/config/lyra_admin.yml'}

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
