WebLibraryManager: a PHP class to manage Javascript/CSS dependencies in your project
====================================================================================

WebLibraryManager is a [Mouf package](http://mouf-php.com) that allows you to import CSS/Javascript in your project the simple way.

You can use it without Mouf, but most of the time, you will use Mouf and its install process to get quickly started.

When installed, the WebLibraryManager package creates to instances:
- `defaultWebLibraryManager` (an instance of the WebLibraryManager class)
- `defaultWebLibraryRenderer` (an instance of the DefaultWebLibraryRenderer class)

The usage is simple: when you want to import a new Javascript/CSS library, you create an instance of *WebLibrary*, you put the list of CSS/JS files in it, and you add this instance to *defaultWebLibraryManager*.
You put the *defaultWebLibraryManager* in your template (this is usually done by default by the template installer).
When the *toHtml* method is called on the *defaultWebLibraryManager*, it will automatically import all JS/CSS files.

If your WebLibrary depends on other web libraries (for instance, if you import jQueryUI, that requires jQuery), the WebLibraryManager will manage all the dependencies for you.
If you have special needs about the way to import CSS/JS files, you can develop your own WebLibraryRenderer that will render your library (for instance with inline JS, ...)

Installing WebLibraryManager:
-----------------------------

WebLibraryManager comes as a composer package (the name of the package is *mouf/html.utils.weblibrarymanager*)
Usually, you do not install this package by yourself. It should be a dependency of a Mouf template that you will use.

Still want to install it manually?

Not used to Composer? The first step is installing Composer. 
This is essentially a one line process:

```bash
curl -s https://getcomposer.org/installer | php
```

Windows users can download the phar file here: [http://getcomposer.org/download/](install composer).
Then create a *composer.json* file at the root of your project:

```json
{
    "require": {
        "mouf/html.utils.weblibrarymanager": ">=1.0-dev"
    },
    "minimum-stability": "dev" 
}
```

and finally, run

```bash
php composer.phar install
```

Support for Rob Loach's components
----------------------------------

If you are looking for Javascript packages into Composer, you certainly found some packages that are
respecting the "component" bundling format. [This is a format developped by Rob Loach](http://github.com/robloach/component-installer) and that
enables packaging Javascript and CSS files in Packagist easily.

For instance, have a look at the **component/jquery** package on Packagist.

The **WebLibraryManager** has a built in support for these components. If you import one of those Composer packages
in your project, the **WebLibraryManager** will detect these packages and will automatically create the **WebLibrary** instances
matching those packages.

Note: if you import these packages _before_ installing the WebLibraryManager, Mouf will detect the missing instances on the
status page and will offer a button to create those missing instances automatically.