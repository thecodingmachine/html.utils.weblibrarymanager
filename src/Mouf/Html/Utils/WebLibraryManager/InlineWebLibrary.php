<?php
namespace Mouf\Html\Utils\WebLibraryManager;

use Mouf\Html\HtmlElement\Scopable;
use Mouf\Html\Utils\WebLibraryManager\WebLibraryInterface;
use Mouf\Html\Utils\WebLibraryManager\WebLibraryRendererInterface;

/**
 * This class can be used to insert JS or CSS directly into the &lt;head&gt; tag (inline).
 * Content is loaded from PHP files passed to this object.
 *
 * @Component
 */
class InlineWebLibrary implements WebLibraryInterface, WebLibraryRendererInterface {
	
	/**
	 * A PHP file to be executed fro including inline JS into your &lt;head&gt; tag.
	 * The path is relative to ROOT_PATH.
	 * 
	 * @Property
	 * @var string
	 */
	public $jsPhpFile;
	
	/**
	 * A PHP file to be executed fro including inline CSS into your &lt;head&gt; tag.
	 * The path is relative to ROOT_PATH.
	 * 
	 * @Property
	 * @var string
	 */
	public $cssPhpFile;
	
	/**
	 * A PHP file to be executed fro including inline CSS or JS into your &lt;head&gt; tag.
	 * The path is relative to ROOT_PATH.
	 * The content of this file is displayed BELOW JS and CSS inclusion.
	 *
	 * @Property
	 * @var string
	 */
	public $additionalPhpFile;
	
	/**
	 * The scope the files will be executed in.
	 *
	 * @Property
	 * @var Scopable
	 */
	public $scope;
    
    /**
     * Returns an array of Javascript files to be included for this library.
     *
     * @return array<string>
     */
    public function getJsFiles() {
    	return array();
    }
    
    /**
     * Returns an array of CSS files to be included for this library.
     *
     * @return array<string>
     */
    public function getCssFiles() {
    	return array();
    }
    
    /**
     * Returns a list of libraries that must be included before this library is included.
     *
     * @return array<WebLibraryInterface>
     */
    public function getDependencies() {
    	return array();
    }
    
    /**
     * Returns a list of features provided by this library.
     * A feature is typically a string describing what the file contains.
     *
     * For instance, an object representing the JQuery library would provide the "jquery" feature.
     *
     * @return array<string>
     */
    public function getFeatures() {
    	return array();
    }
    
    /**
     * Returns the renderer class in charge of outputing the HTML that will load CSS ans JS files.
     *
     * @return WebLibraryRendererInterface
     */
    public function getRenderer() {
    	return $this;
    }
    
    /**
     * Renders the CSS part of a web library.
     *
     * @param WebLibraryInterface $webLibrary
     */
    function toCssHtml(WebLibraryInterface $webLibrary) {
   		$fileName = ROOT_PATH.$this->cssPhpFile;

    	if ($this->scope != null) {
    		$this->scope->loadFile($fileName);
    	} else {
    		require $fileName;
    	}
    }
    
    /**
     * Renders the JS part of a web library.
     *
     * @param WebLibraryInterface $webLibrary
     */
    function toJsHtml(WebLibraryInterface $webLibrary) {
    	$fileName = ROOT_PATH.$this->jsPhpFile;

    	if ($this->scope != null) {
    		$this->scope->loadFile($fileName);
    	} else {
    		require $fileName;
    	}
    }
    
    /**
     * Renders any additional HTML that should be outputed below the JS and CSS part.
     *
     * @param WebLibraryInterface $webLibrary
     */
    function toAdditionalHtml(WebLibraryInterface $webLibrary) {
    $fileName = ROOT_PATH.$this->additionalPhpFile;

    	if ($this->scope != null) {
    		$this->scope->loadFile($fileName);
    	} else {
    		require $fileName;
    	}
    }
}
?>