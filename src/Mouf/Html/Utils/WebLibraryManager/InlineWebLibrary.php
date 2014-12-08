<?php
namespace Mouf\Html\Utils\WebLibraryManager;
use Mouf\Html\HtmlElement\HtmlFromFile;

use Mouf\Html\HtmlElement\HtmlString;

use Mouf\Html\HtmlElement\HtmlElementInterface;
use Mouf\Html\HtmlElement\Scopable;
use Mouf\Html\Utils\WebLibraryManager\WebLibraryInterface;
use Mouf\Html\Utils\WebLibraryManager\WebLibraryRendererInterface;

/**
 * This class can be used to insert JS or CSS directly into the &lt;head&gt; tag (inline).
 * Content is loaded from PHP files passed to this object.
 *
 */
class InlineWebLibrary implements WebLibraryInterface {
	
	/**
	 * A custom Html element that will be inserted into the JS scripts into your &lt;head&gt; tag.
	 * 
	 * @var HtmlElementInterface
	 */
	protected $jsElement;
	
	/**
	 * A custom CSS element that will be inserted into the JS scripts into your &lt;head&gt; tag.
	 * 
	 * @var HtmlElementInterface
	 */
	protected $cssElement;
	
	/**
	 * A custom Html element that will be inserted into the additional scripts into your &lt;head&gt; tag.
	 * The content of this file is displayed BELOW JS and CSS inclusion.
	 *
	 * @var HtmlElementInterface
	 */
	protected $additionalElement;
	
	/**
	 * 
	 * @param HtmlElementInterface $jsElement A custom Html element that will be inserted into the JS scripts into your &lt;head&gt; tag.
	 * @param HtmlElementInterface $cssElement A custom CSS element that will be inserted into the JS scripts into your &lt;head&gt; tag.
	 * @param HtmlElementInterface $additionalElement A custom Html element that will be inserted into the additional scripts into your &lt;head&gt; tag. The content of this file is displayed BELOW JS and CSS inclusion.
	 */
	public function __construct(HtmlElementInterface $jsElement = null,
			HtmlElementInterface $cssElement = null,
			HtmlElementInterface $additionalElement = null) {
		$this->jsElement = $jsElement;
		$this->cssElement = $cssElement;
		$this->additionalElement = $additionalElement;
	}
	
	
	
	/**
	 * A custom Html element that will be inserted into the JS scripts into your &lt;head&gt; tag.
	 *
	 * @param HtmlElementInterface $jsElement
	 */
	public function setJsElement(HtmlElementInterface $jsElement) {
		$this->jsElement = $jsElement;
		return $this;
	}
	
	/**
	 * A custom CSS element that will be inserted into the JS scripts into your &lt;head&gt; tag.
	 * @param HtmlElementInterface $cssElement
	 */
	public function setCssElement(HtmlElementInterface $cssElement) {
		$this->cssElement = $cssElement;
		return $this;
	}
	
	/**
	 * A custom Html element that will be inserted into the additional scripts into your &lt;head&gt; tag.
	 * The content of this file is displayed BELOW JS and CSS inclusion.
	 *
	 * @param HtmlElementInterface $additionalElement
	 */
	public function setAdditionalElement(HtmlElementInterface $additionalElement) {
		$this->additionalElement = $additionalElement;
		return $this;
	}
	
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
     * Sets the script outputed in the JS section
     * @param string $script
     */
    function setJSFromText($script){
    	$this->jsElement = new HtmlString($script);
    }
    
    
    /**
     * Sets the script outputed in the JS section
     * 
     * @param string $filename
     * @param Scopable $scope
     * @param bool $relativeToRootPath
     */
    function setJSFromFile($filename, $scope = null, $relativeToRootPath = true){
    	$this->jsElement = new HtmlFromFile($filename, $scope, $relativeToRootPath);
    }
    
    /**
     * Sets the css outputed in the CSS section
     * @param string $css
     */
    function setCSSFromText($css){
    	$this->cssElement = new HtmlString($css);
    }
    
    /**
     * Sets the script outputed in the CSS section
     * 
     * @param string $filename
     * @param Scopable $scope
     * @param bool $relativeToRootPath
     */
    function setCSSFromFile($filename, $scope = null, $relativeToRootPath = true){
    	$this->cssElement = new HtmlFromFile($filename, $scope, $relativeToRootPath);
    }
    
    /**
     * Sets the additional items outputed below the JS and CSS sections
     * @param string $script
     */
    function setAdditionalElementFromText($script){
    	$this->additionalElement = new HtmlString($script);
    }
    
    /**
     * Sets the additional items outputed below the JS and CSS sections
     *
     * @param string $filename
     * @param Scopable $scope
     * @param bool $relativeToRootPath
     */
    function setAdditionalElementFromFile($filename, $scope = null, $relativeToRootPath = true){
    	$this->additionalElement = new HtmlFromFile($filename, $scope, $relativeToRootPath);
    }
	
	/**
	 * A custom Html element that will be inserted into the JS scripts into your &lt;head&gt; tag.
	 * @return the HtmlElementInterface
	 */
	public function getJsElement() {
		return $this->jsElement;
	}
	
	/**
	 * A custom CSS element that will be inserted into the JS scripts into your &lt;head&gt; tag.
	 * @return the HtmlElementInterface
	 */
	public function getCssElement() {
		return $this->cssElement;
	}
	
	/**
	 * A custom Html element that will be inserted into the additional scripts into your &lt;head&gt; tag.
	 * The content of this file is displayed BELOW JS and CSS inclusion.
	 * @return the HtmlElementInterface
	 */
	public function getAdditionalElement() {
		return $this->additionalElement;
	}
	
}
?>