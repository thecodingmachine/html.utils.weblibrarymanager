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

Getting an instance of WebLibraryManager
----------------------------------------

Most of the time, you will be using `WebLibraryManager` through a Mouf template.
You can simply get an instance of the `WebLibraryManager` from the template:

```php
class MyController {
	/**
	 * @var $template TemplateInterface
	 */
	protected $template;

	...
	
	public function myAction() {
		$webLibraryManager = $this->template->getWebLibraryManager();
		...
	}
}
```

You can also directly instanciate the webLibraryManager using Mouf (although it is not recommended
since that would be using Mouf as a service locator instead of a DI container):

```php
$webLibraryManager = Mouf::getDefaultWebLibraryManager();
...
``` 


Adding a JS or CSS file programmatically
----------------------------------------
The most trivial use of the WebLibraryManager is adding a JS or CSS file to your web page.
To do this, you simply write:

```php
// Import a JS file from your project
// The file is relative to your ROOT_URL
$webLibraryManager->addJsFile('src/javascript/myJsFile.js');

// Import a JS file from a CDN
$webLibraryManager->addJsFile('https://code.jquery.com/jquery-2.1.1.min.js');
```

```php
// Import a CSS file from your project
// The file is relative to your ROOT_URL
$webLibraryManager->addCssFile('src/css/myStyle.css');
```

<div class="alert alert-info">When you include a file, if the file does NOT start with a '/', it is relative to your root URL.
If the file start with a '/', it is absolute.</div>

You can add any kind of script at the end of the &lt;head&gt; tag using:

```php
$webLibraryManager->addAdditionalScript('<script>alert("Hello world!")</script>');
```


You can also declare a complete `WebLibrary` object and add it.

```php
$webLibrary = new WebLibrary(
	["javascript/file1.js", "javascript/file2.js"],
	["css/style1.css", "css/style2.css"]);

$webLibraryManager->addLibrary($webLibrary);
```

This codes create a new *WebLibrary* and adds it to the *WebLibraryManager*.
The *WebLibrary* takes an array of Javascript files as first argument, and an array
of CSS files as second argument.

Alternatively, if you want to add some CSS styles or Javascript scripts (or anything else) to your &lt;head&gt; tag,
you can simply use the `InlineWebLibrary` class that let's you add what you want in the JS, CSS or additional part
of your template.

Outputing the result
--------------------

Simply use the `toHtml()` method to output the content of the `WebLibraryManager`:

```php
$webLibraryManager->toHtml();
```

This call is usually performed by your template.

TODO: explain the structure: CSS first, then JS, then additional.

Adding a new WebLibrary by configuration
----------------------------------------
###Using Mouf user interface

TODO: screenshot



Writing your own WebLibraries
-----------------------------
If you have specific needs, the ...

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

Thanks to the marvelous [composer-asset-plugin libray](http://github.com/francoispluchino/composer-asset-plugin), we can now include
Bower assets (so basically any modern Javascript library) directly into Composer dependencies.

The **WebLibraryManager** has a built in support for these bower assets. When you insert new bower assets
in your `composer.json` file, the WebLibraryManager will detect those packages and automatically create the 
**WebLibrary** instances matching those packages.

Note: the included JS and CSS files are based on the "main" attribute declared in the `bower.json` file of the package. 

Note: if you import these packages _before_ installing the WebLibraryManager, Mouf will detect the missing instances on the
status page and will offer a button to create those missing instances automatically.
