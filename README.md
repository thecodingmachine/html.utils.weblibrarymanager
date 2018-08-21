[![Latest Stable Version](https://poser.pugx.org/mouf/html.utils.weblibrarymanager/v/stable.svg)](https://packagist.org/packages/mouf/html.utils.weblibrarymanager)
[![Total Downloads](https://poser.pugx.org/mouf/html.utils.weblibrarymanager/downloads.svg)](https://packagist.org/packages/mouf/html.utils.weblibrarymanager)
[![Latest Unstable Version](https://poser.pugx.org/mouf/html.utils.weblibrarymanager/v/unstable.svg)](https://packagist.org/packages/mouf/html.utils.weblibrarymanager)
[![License](https://poser.pugx.org/mouf/html.utils.weblibrarymanager/license.svg)](https://packagist.org/packages/mouf/html.utils.weblibrarymanager)
[![Build Status](https://travis-ci.org/thecodingmachine/html.utils.weblibrarymanager.svg?branch=4.0)](https://travis-ci.org/thecodingmachine/html.utils.weblibrarymanager)
[![Coverage Status](https://coveralls.io/repos/thecodingmachine/html.utils.weblibrarymanager/badge.svg?branch=4.0&service=github)](https://coveralls.io/github/thecodingmachine/html.utils.weblibrarymanager?branch=4.0)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/thecodingmachine/html.utils.weblibrarymanager/badges/quality-score.png?b=4.0)](https://scrutinizer-ci.com/g/thecodingmachine/html.utils.weblibrarymanager/?branch=4.0)

WebLibraryManager: a PHP class to manage Javascript/CSS dependencies in your project
====================================================================================

Tutorial
--------

If you need a nice introduction to managing JS/CSS files with Mouf, read the [JS/CSS introduction of the "getting things done with mouf" project](http://mouf-php.com/packages/mouf/getting-things-done-basic-edition/doc/adding_js_and_css_files.md).

Introduction
------------

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
        "mouf/html.utils.weblibrarymanager": "^4"
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

The WebLibraryManager will group its output in 3 categories:

- CSS declarations go first
- Then JS file declarations
- And finally anything else (usually JS scripts directly put in the web page)

Adding a new WebLibrary by configuration
----------------------------------------
The _WebLibraryManager_ comes with a default instance *defaultWebLibraryManager*, that is used by the template.

![Web library manager instance](doc/images/defaultWebLibraryManager.png)

You just need to add a new *WebLibrary* to the instance list.

Then, edit this weblibrary, and add the JS and CSS files you want to include.

![Web library instance](doc/images/weblibrary.png)

<div class="alert">_Note:_ Do not start the JS or CSS file path with a /. That way, the path is relative to the
ROOT_URL (the root of your web application). You can also enter a full path (http://...) if you want to
use hosted libraries, CDN, etc...</div>

Writing your own WebLibraries
-----------------------------
If you have specific needs, the WebLibrary class might not be enough.
For instance, you might want to output something else than &lt;script&gt; tags.

For these use-cases, you can write a class that implement the `WebLibraryInterface` interface.
Since the WebLibraryManager uses Mouf's rendering system, you will need to provide a template for
your class with 3 different contexts: "js", "css" and "additional".

Here is a simple sample:

The [`GoogleAnalyticsWebLibrary`](https://github.com/thecodingmachine/modules.google-analytics/blob/4.0/src/Mouf/Modules/GoogleAnalytics/GoogleAnalyticsWebLibrary.php#L16)
is a simple class that will output Javascript required by Google Analytics.
This class contains almost nothing except the 2 properties required (`accountKey` and `domainName`).

Rendering is performed by the 3 templates here:

- [JS template](https://github.com/thecodingmachine/modules.google-analytics/blob/4.0/src/templates/Mouf/Modules/GoogleAnalytics/GoogleAnalyticsWebLibrary__js.php) is empty
- [CSS template](https://github.com/thecodingmachine/modules.google-analytics/blob/4.0/src/templates/Mouf/Modules/GoogleAnalytics/GoogleAnalyticsWebLibrary__css.php) is empty
- [Additional template](https://github.com/thecodingmachine/modules.google-analytics/blob/4.0/src/templates/Mouf/Modules/GoogleAnalytics/GoogleAnalyticsWebLibrary__additional.php) contains the Google Analytics code.

Because the Google Analytics tracking code is in the "additional" section, it will be displayed after all CSS and JS files are loaded.


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
