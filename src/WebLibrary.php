<?php
namespace Mouf\Html\Utils\WebLibraryManager;

/**
 * A WebLibrary represents a set of CSS and JS files that can be integrated into your web application.
 *
 * @author David Négrier
 */
class WebLibrary implements WebLibraryInterface
{
    
    
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
     * Boolean whether the dependencies are called asynchronously
     *
     * @var bool
     */
    private $async = false;

    /**
     * Constructor
     *
     * @param string[] $jsFiles List of JS files to add in header. If you don't specify http:// or https:// and if your URL does not start with /, the file is considered to be relative to ROOT_URL.
     * @param string[] $cssFiles List of CSS files to add in header. If you don't specify http:// or https:// and if your URL does not start with /, the file is considered to be relative to ROOT_URL.
     */
    
    public function __construct(array $jsFiles = [], array $cssFiles = [])
    {
        $this->jsFiles= $jsFiles;
        $this->cssFiles = $cssFiles;
    }
    
    /**
     * Returns an array of Javascript files to be included for this library.
     *
     * @return array<string>
     */
    public function getJsFiles(): array
    {
        return $this->jsFiles;
    }
    
    /**
     * List of JS files to put in the web library.
     * <p>If you don't specify http:// or https:// and if the file does not start with /, the file is considered to be relative to ROOT_URL.</p>
     * <div class="info">It is a good practice to make sure the file does not start with /, http:// or https:// (unless you are using a CDN).</div>
     *
     * @param array<string> $jsFiles
     */
    public function setJsFiles(array $jsFiles): void
    {
        $this->jsFiles = $jsFiles;
    }
    
    /**
     * Adds a JS file to the web library.
     * <p>If you don't specify http:// or https:// and if the file does not start with /, the file is considered to be relative to ROOT_URL.</p>
     * <div class="info">It is a good practice to make sure the file does not start with /, http:// or https:// (unless you are using a CDN).</div>
     *
     * @param string $jsFile
     */
    public function addJsFile(string $jsFile): void
    {
        $this->jsFiles[] = $jsFile;
    }
    
    /**
     * Returns an array of CSS files to be included for this library.
     *
     * @return array<string>
     */
    public function getCssFiles(): array
    {
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
    public function setCssFiles(array $cssFiles): void
    {
        $this->cssFiles = $cssFiles;
    }
    
    /**
     * Adds a CSS file to the web library.
     * <p>If you don't specify http:// or https:// and if the file does not start with /, the file is considered to be relative to ROOT_URL.</p>
     * <div class="info">It is a good practice to make sure the file does not start with /, http:// or https:// (unless you are using a CDN).</div>
     *
     * @param string $cssFile
     */
    public function addCssFile(string $cssFile): void
    {
        $this->cssFiles[] = $cssFile;
    }
    
    /**
     * Returns a list of libraries that must be included before this library is included.
     *
     * @return array<WebLibraryInterface>
     */
    public function getDependencies(): array
    {
        return $this->dependencies;
    }
    
    /**
     * The list of all libraries that are needed for this library
     *
     * @Property
     * @param array<WebLibraryInterface> $libraries
     */
    public function setDependencies(array $libraries): void
    {
        $this->dependencies = $libraries;
    }

    /**
     * Returns if the dependencies are loaded asynchronously
     *
     * @return bool
     */
    public function isAsync(): bool
    {
        return $this->async;
    }

    /**
     * Set if the dependencies are loaded asynchronously
     *
     * @Property
     * @param bool $async
     */
    public function setIsAsync(bool $async): void
    {
        $this->async = $async;
    }
}
