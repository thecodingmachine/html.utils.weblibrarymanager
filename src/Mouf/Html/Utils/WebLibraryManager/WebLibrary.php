<?php
namespace Mouf\Html\Utils\WebLibraryManager;

/**
 * A WebLibrary represents a set of CSS and JS files that can be integrated into your web application.
 * 
 * @author David Négrier
 */
class WebLibrary implements WebLibraryInterface {
	
	
	/**
	 * List of JS files to add in header.
     * If you don't specify http:// or https:// and if your URL does not start with /, the file is considered to be relative to ROOT_URL.
     * 
	 * @var array<string>
	 */
	private $jsFiles = array();

	/**
	 * List of CSS files to add in header.
	 * If you don't specify http:// or https:// and if your URL does not start with /, the file is considered to be relative to ROOT_URL.
	 *
	 * @var array<string>
	 */
	private $cssFiles = array();

	/**
	 * List of libraries this library depends on.
	 * 
	 * @var array<WebLibraryInterface>
	 */
	private $dependencies = array();
	
	
	/**
	 * Constructor
	 * 
	 * @param string[] $jsFiles List of JS files to add in header. If you don't specify http:// or https:// and if your URL does not start with /, the file is considered to be relative to ROOT_URL.
	 * @param string[] $cssFiles List of CSS files to add in header. If you don't specify http:// or https:// and if your URL does not start with /, the file is considered to be relative to ROOT_URL.
	 */
	
	public function __construct($jsFiles = array(), $cssFiles = array() ) {
		$this->jsFiles= $jsFiles;
		$this->cssFiles = $cssFiles;
	}
	
	/**
	 * Returns an array of Javascript files to be included for this library.
	 * 
	 * @return array<string>
	 */
	public function getJsFiles() {
		return $this->jsFiles;
	}
	
	/**
	 * List of JS files to put in the web library.
	 * <p>If you don't specify http:// or https:// and if the file does not start with /, the file is considered to be relative to ROOT_URL.</p>
	 * <div class="info">It is a good practice to make sure the file does not start with /, http:// or https:// (unless you are using a CDN).</div>
     * 
	 * @Property
	 * @param array<string> $jsFiles
	 */
	public function setJsFiles($jsFiles) {
		$this->jsFiles = $jsFiles;
	}
	
	/**
	 * Adds a JS file to the web library.
	 * <p>If you don't specify http:// or https:// and if the file does not start with /, the file is considered to be relative to ROOT_URL.</p>
	 * <div class="info">It is a good practice to make sure the file does not start with /, http:// or https:// (unless you are using a CDN).</div>
	 * 
	 * @param string $jsFile
	 */
	public function addJsFile($jsFile) {
		$this->jsFiles[] = $jsFile;
	}
	
	/**
	 * Returns an array of CSS files to be included for this library.
	 *
	 * @return array<string>
	 */
	public function getCssFiles() {
		return $this->cssFiles;
	}
	
	/**
	 * List of CSS files to add in web library.
	 * <p>If you don't specify http:// or https:// and if the file does not start with /, the file is considered to be relative to ROOT_URL.</p>
	 * <div class="info">It is a good practice to make sure the file does not start with /, http:// or https:// (unless you are using a CDN).</div>
	 *
	 * @Property
	 * @param array<string> $cssFiles
	 */
	public function setCssFiles($cssFiles) {
		$this->cssFiles = $cssFiles;
	}
	
	/**
	 * Adds a CSS file to the web library.
	 * <p>If you don't specify http:// or https:// and if the file does not start with /, the file is considered to be relative to ROOT_URL.</p>
	 * <div class="info">It is a good practice to make sure the file does not start with /, http:// or https:// (unless you are using a CDN).</div>
	 * 
	 * @param string $jsFile
	 */
	public function addCssFile($cssFile) {
		$this->cssFiles[] = $cssFile;
	}
	
	/**
	 * Returns a list of libraries that must be included before this library is included.
	 *
	 * @return array<WebLibraryInterface>
	 */
	public function getDependencies() {
		return $this->dependencies;
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
		throw new \Exception("Not implemented yet!");
	}
	
	/**
	 * The list of all libraries that are needed for this library
	 * 
	 * @Property
	 * @param array<WebLibraryInterface> $libraries
	 */
	public function setDependencies($libraries) {
		$this->dependencies = $libraries;
	}
}