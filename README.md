WebLibraryManager: a PHP class to manage Javascript/CSS dependencies in your project
====================================================================================

WebLibraryManager is a [Mouf package](http://mouf-php.com) that allows you to import CSS/Javascript in your project the simple way.

You can use it without Mouf, but most of the time, you will use Mouf and its install process to get quickly started.

When installed, the WebLibraryManager package creates a `defaultWebLibraryManager` instance (from
`WebLibraryManager` class).

The usage is simple: when you want to import a new Javascript/CSS library, you create an instance of *WebLibrary*, you put the list of CSS/JS files in it, and you add this instance to *defaultWebLibraryManager*.
When you call the `toHtml()` method of the *defaultWebLibraryManager*, it will output all HTML tags to import CSS files first, then all JS files.

If your WebLibrary depends on other web libraries (for instance, if you import jQueryUI, that requires jQuery), the WebLibraryManager will manage all the dependencies for you.
If you have special needs about the way to import CSS/JS files, you can develop your own WebLibraryRenderer that will render your library (for instance with inline JS, ...)

<script src="http://www.sveido.com/mermaid/dist/mermaid.full.min.js"></script>
<style>
g.label {
	color: #333;
}
</style>
<div class="mermaid">
graph LR;
    A[WebLibraryManager]-->B[jQuery];
    A-->C[jQuery-UI];
    A-->D[Bootstrap];
    A-->E[Other library];
    A-->F[...];
</div>

Installing WebLibraryManager:
-----------------------------

WebLibraryManager comes as a composer package (the name of the package is *mouf/html.utils.weblibrarymanager*)
Usually, you do not install this package by yourself. It should be a dependency of a Mouf template that you will use.

Still want to install it manually? Use the packagist package:

**composer.json**
```json
{
    "require": {
        "mouf/html.utils.weblibrarymanager": "~3.0"
    } 
}
```

Adding a new WebLibrary
-----------------------
###Using Mouf user interface

TODO: screenshot

###Using code

TODO:
- from a controller
- from anywhere (Mouf::getDefaultWebLibraryManager()->... (not recommended))


Writing your own WebLibraries
-----------------------------

TODO: explain the rendering system. 


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

Support for Bower packages
--------------------------
TODO