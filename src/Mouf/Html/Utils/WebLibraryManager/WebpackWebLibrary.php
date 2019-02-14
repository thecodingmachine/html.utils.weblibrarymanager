<?php
namespace Mouf\Html\Utils\WebLibraryManager;

/**
 * A WebpackWebLibrary represents a set of CSS and JS files that can be integrated into your web application
 * with the help of a manifest.json file.
 * 
 * @author Julien Neuhart
 */
class WebpackWebLibrary implements WebLibraryInterface
{
    /**
     * The path to the JSON manifest file, relative to ROOT_PATH.
     *
     * @var string
     */
    private $jsonManifestPath;

    /** @var null|array<string,string[]> */
    private $filesPaths = null;

    /**
     * List of libraries this library depends on.
     *
     * @var array<WebLibraryInterface>
     */
    private $dependencies = array();

	/**
	 * Constructor
	 *
     * @param string $jsonManifestPath The path to the JSON manifest file, relative to ROOT_PATH.
	 */
	public function __construct($jsonManifestPath) {
		$this->jsonManifestPath = $jsonManifestPath;
	}
	
	/**
	 * Returns an array of Javascript files to be included for this library.
	 * 
	 * @return array<string>
     * @throws \Exception
	 */
	public function getJsFiles() {
	    $filesPaths = $this->readManifestFile();
		return $filesPaths['js'];
	}
	

	/**
	 * Returns an array of CSS files to be included for this library.
	 *
	 * @return array<string>
     * @throws \Exception
	 */
	public function getCssFiles() {
        $filesPaths = $this->readManifestFile();
        return $filesPaths['css'];
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
     * Reads the manifest file and returns an array
     * of CSS (key = 'css') and JS (key = 'js') files paths.
     *
     * @return array<string,string[]>
     * @throws \Exception
     */
	private function readManifestFile() {
	    if (!empty($this->filesPaths)) {
	        return $this->filesPaths;
        }
	    $content = file_get_contents(ROOT_PATH . $this->jsonManifestPath);
	    if ($content === false) {
	        throw new \Exception('Unable to read the given JSON manifest file.');
        }
	    $decoded = json_decode($content, true);
        $baseDir = dirname($this->jsonManifestPath);
        $this->filesPaths = array();
        $this->filesPaths['css'] = array();
        $this->filesPaths['js'] = array();
	    foreach ($decoded as $name => $path) {
            $ext = pathinfo($baseDir . $path, PATHINFO_EXTENSION);
            if ($ext === 'js') {
                $this->filesPaths['js'][] = $baseDir . $path;
            } else if ($ext === 'css') {
                $this->filesPaths['css'][] = $baseDir . $path;
            }
        }
	    return $this->filesPaths;
    }
}