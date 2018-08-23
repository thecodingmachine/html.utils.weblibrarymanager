<?php
namespace Mouf\Html\Utils\WebLibraryManager;

use Mouf\Html\HtmlElement\HtmlFromFile;
use Mouf\Html\HtmlElement\HtmlString;
use Mouf\Html\HtmlElement\HtmlElementInterface;
use Mouf\Html\HtmlElement\Scopable;
use Mouf\Html\Utils\WebLibraryManager\WebLibraryInterface;

/**
 * This class can be used to insert JS or CSS directly into the &lt;head&gt; tag (inline).
 * Content is loaded from PHP files passed to this object.
 *
 */
class InlineWebLibrary implements WebLibraryInterface
{
    
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
    public function __construct(
        HtmlElementInterface $jsElement = null,
        HtmlElementInterface $cssElement = null,
        HtmlElementInterface $additionalElement = null
    ) {
        $this->jsElement = $jsElement;
        $this->cssElement = $cssElement;
        $this->additionalElement = $additionalElement;
    }
    
    
    
    /**
     * A custom Html element that will be inserted into the JS scripts into your &lt;head&gt; tag.
     *
     * @param HtmlElementInterface $jsElement
     */
    public function setJsElement(HtmlElementInterface $jsElement): self
    {
        $this->jsElement = $jsElement;
        return $this;
    }
    
    /**
     * A custom CSS element that will be inserted into the JS scripts into your &lt;head&gt; tag.
     * @param HtmlElementInterface $cssElement
     */
    public function setCssElement(HtmlElementInterface $cssElement): self
    {
        $this->cssElement = $cssElement;
        return $this;
    }
    
    /**
     * A custom Html element that will be inserted into the additional scripts into your &lt;head&gt; tag.
     * The content of this file is displayed BELOW JS and CSS inclusion.
     *
     * @param HtmlElementInterface $additionalElement
     */
    public function setAdditionalElement(HtmlElementInterface $additionalElement): self
    {
        $this->additionalElement = $additionalElement;
        return $this;
    }
    
    /**
     * Returns an array of Javascript files to be included for this library.
     *
     * @return array<string>
     */
    public function getJsFiles(): array
    {
        return array();
    }
    
    /**
     * Returns an array of CSS files to be included for this library.
     *
     * @return array<string>
     */
    public function getCssFiles(): array
    {
        return array();
    }
    
    /**
     * Returns a list of libraries that must be included before this library is included.
     *
     * @return array<WebLibraryInterface>
     */
    public function getDependencies(): array
    {
        return array();
    }
    
    /**
     * Sets the script outputed in the JS section
     * @param string $script
     */
    public function setJSFromText(string $script): void
    {
        $this->jsElement = new HtmlString($script);
    }
    
    
    /**
     * Sets the script outputed in the JS section
     *
     * @param string $filename
     * @param Scopable $scope
     * @param bool $relativeToRootPath
     */
    public function setJSFromFile(string $filename, Scopable $scope = null, bool $relativeToRootPath = true): void
    {
        $this->jsElement = new HtmlFromFile($filename, $scope, $relativeToRootPath);
    }
    
    /**
     * Sets the css outputed in the CSS section
     * @param string $css
     */
    public function setCSSFromText(string $css): void
    {
        $this->cssElement = new HtmlString($css);
    }
    
    /**
     * Sets the script outputed in the CSS section
     *
     * @param string $filename
     * @param Scopable $scope
     * @param bool $relativeToRootPath
     */
    public function setCSSFromFile(string $filename, Scopable $scope = null, bool $relativeToRootPath = true): void
    {
        $this->cssElement = new HtmlFromFile($filename, $scope, $relativeToRootPath);
    }
    
    /**
     * Sets the additional items outputed below the JS and CSS sections
     * @param string $script
     */
    public function setAdditionalElementFromText(string $script): void
    {
        $this->additionalElement = new HtmlString($script);
    }
    
    /**
     * Sets the additional items outputed below the JS and CSS sections
     *
     * @param string $filename
     * @param Scopable $scope
     * @param bool $relativeToRootPath
     */
    public function setAdditionalElementFromFile(string $filename, Scopable $scope = null, bool $relativeToRootPath = true): void
    {
        $this->additionalElement = new HtmlFromFile($filename, $scope, $relativeToRootPath);
    }
    
    /**
     * A custom Html element that will be inserted into the JS scripts into your &lt;head&gt; tag.
     */
    public function getJsElement(): ?HtmlElementInterface
    {
        return $this->jsElement;
    }
    
    /**
     * A custom CSS element that will be inserted into the JS scripts into your &lt;head&gt; tag.
     */
    public function getCssElement(): ?HtmlElementInterface
    {
        return $this->cssElement;
    }
    
    /**
     * A custom Html element that will be inserted into the additional scripts into your &lt;head&gt; tag.
     * The content of this file is displayed BELOW JS and CSS inclusion.
     */
    public function getAdditionalElement(): ?HtmlElementInterface
    {
        return $this->additionalElement;
    }
}
