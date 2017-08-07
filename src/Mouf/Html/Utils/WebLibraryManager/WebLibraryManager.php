<?php 
namespace Mouf\Html\Utils\WebLibraryManager;

use Mouf\Html\HtmlElement\HtmlElementInterface;
use Mouf\Html\Renderer\RendererInterface;
use Mouf\Html\HtmlElement\HtmlString;

/**
 * This class is in charge of including and keeping track of Javascript and CSS libraries into an HTML page.
 * <p>JS and CSS files are grouped into <b>WebLibraries</b>. If you want to add a new library, just create an instance
 * of the <b>WebLibrary</b> class, and add it to the <b>WebLibraryManager</b>.</p>
 * <p>You can use the <b>WebLibraryManager</b> class to add JS/CSS libraries. It will keep track of dependencies and ensure each file is included
 * only once.</p>

 * <p>If you have specific needs and don't want to use the <b>WebLibrary</b> class, you can either create your own class
 * that implements the WebLibraryInterface, or provide your own "renderer".</p>
 * 
 * 
 * @author David Négrier
 */
class WebLibraryManager implements HtmlElementInterface {
	
	/**
	 * The array of all included libraries.
	 * 
	 * @var WebLibraryInterface[]
	 */
	private $webLibraries = array();
	
	/**
	 * false if the toHtml method has not yet been called, true if it has been called.
	 * @var boolean
	 */
	private $rendered = false;
	
	/**
	 * The renderer used by the application. Usually, this points to the 'defaultRenderer' instance.
	 * 
	 * @var RendererInterface
	 */
	private $renderer;
	
	/**
	 * 
	 * @param RendererInterface $renderer The renderer used by the application. Usually, this points to the 'defaultRenderer' instance.
	 */
	public function __construct(RendererInterface $renderer) {
		$this->renderer = $renderer;
	}
	
	/**
	 * Adds a library to the list of libraries that should be loaded in the web page.
	 * <p>The function will also load the dependencies (if any) and will have no effect if the library has already been loaded.</p>
	 * 
	 * @param WebLibraryInterface $library
	 */
	public function addLibrary(WebLibraryInterface $library) {
		if ($this->rendered) {
			throw new WebLibraryException("The libraries have already been rendered. This call to addLibrary should be performed BEFORE the toHtml method of WebLibraryManager is called.");
		}
		if (array_search($library, $this->webLibraries) === false) {
			// Let's start by adding dependencies.
			$dependencies = $library->getDependencies();
			if ($dependencies) {
				foreach ($dependencies as $dependency) {
					/* @var $dependency WebLibraryInterface */
					$this->addLibrary($dependency);
				}
			}
			
			$this->webLibraries[] = $library;
		}
	}
		
	/**
	 * The list of all libraries that should be loaded in the web page.
	 * <p>If you do not pass all dependencies of a library, the dependencies will be loaded automatically.</p>
	 * 
	 * @param array<WebLibraryInterface> $libraries
	 */
	public function setWebLibraries($libraries) {
		foreach ($libraries as $library) {
			$this->addLibrary($library);
		}
	}
	
	/**
	 * Renders the HTML in charge of loading CSS and JS files.
	 * The Html is echoed directly into the output.
	 * This function should be called within the head tag.
	 *
	 */
	public function toHtml() {
		/*if ($this->rendered) {
			throw new WebLibraryException("The library has already been rendered.");
		}*/
		
		echo $this->getCssHtml();
		echo $this->getJsHtml();
		echo $this->getAdditionalHtml();

		$this->rendered = true;
	}

	/**
	 * Adds a single JS file to the list of files to be included in the &lt;head&gt; tag.
	 * <p>If you don't specify http:// or https:// and if the file does not start with /, the file is considered to be relative to ROOT_URL.</p>
	 * <div class="info">It is a good practice to make sure the file does not start with /, http:// or https:// (unless you are using a CDN).</div>
	 * 
	 * @param string $jsFile
	 */
	public function addJsFile($jsFile) {
		$this->webLibraries[] = new WebLibrary([$jsFile]);
	}
	
	/**
	 * Adds a single CSS file to the list of files to be included in the &lt;head&gt; tag.
	 * <p>If you don't specify http:// or https:// and if the file does not start with /, the file is considered to be relative to ROOT_URL.</p>
	 * <div class="info">It is a good practice to make sure the file does not start with /, http:// or https:// (unless you are using a CDN).</div>
	 *
	 * @param string $cssFile
	 */
	public function addCssFile($cssFile) {
		$this->webLibraries[] = new WebLibrary([], [$cssFile]);
	}
	
	/**
	 * Adds an additional script at the end of the &lt;head&gt; tag.
	 * The provided script can either be a string or an object implementing HtmlElementInterface.
	 * 
	 * @param string|HtmlElementInterface $additionalScript
	 */
	public function addAdditionalScript($additionalScript) {
		if (!$additionalScript instanceof HtmlElementInterface) {
			$additionalScript = new HtmlString($additionalScript);
		}
		$this->webLibraries[] = new InlineWebLibrary(null, null, $additionalScript);
	}

    /**
     * @return string
     */
	public function getCssHtml() {
	    ob_start();
        foreach ($this->webLibraries as $library) {
            $this->renderer->render($library, 'css');
        }
        $echo =  ob_get_contents();
        ob_end_clean();
        return $echo;
    }

    /**
     * @return string
     */
    public function getJsHtml() {
        ob_start();
        foreach ($this->webLibraries as $library) {
            $this->renderer->render($library, 'js');
        }
        $echo =  ob_get_contents();
        ob_end_clean();
        return $echo;
    }

    /**
     * @return string
     */
    public function getAdditionalHtml() {
        ob_start();
        foreach ($this->webLibraries as $library) {
            $this->renderer->render($library, 'additional');
        }
        $echo =  ob_get_contents();
        ob_end_clean();
        return $echo;
    }
}
