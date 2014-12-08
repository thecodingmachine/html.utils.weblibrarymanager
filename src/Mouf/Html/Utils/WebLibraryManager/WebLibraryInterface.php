<?php
namespace Mouf\Html\Utils\WebLibraryManager;

/**
 * A class implementing the WebLibraryInterface provides JS and CSS files that should be included 
 * 
 * @author David Négrier
 */
interface WebLibraryInterface {
	
	/**
	 * Returns an array of Javascript files to be included for this library.
	 * 
	 * @return array<string> 
	 */
	public function getJsFiles();

	/**
	 * Returns an array of CSS files to be included for this library.
	 * 
	 * @return array<string>
	 */
	public function getCssFiles();

	/**
	 * Returns a list of libraries that must be included before this library is included.
	 * 
	 * @return array<WebLibraryInterface>
	 */
	public function getDependencies();
	
	/**
	 * Returns a list of features provided by this library.
	 * A feature is typically a string describing what the file contains.
	 * 
	 * For instance, an object representing the JQuery library would provide the "jquery" feature.
	 * 
	 * @return array<string>
	 */
	public function getFeatures();
}