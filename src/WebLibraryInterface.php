<?php
namespace Mouf\Html\Utils\WebLibraryManager;

/**
 * A class implementing the WebLibraryInterface provides JS and CSS files that should be included
 *
 * @author David Négrier
 */
interface WebLibraryInterface
{
    
    /**
     * Returns an array of Javascript files to be included for this library.
     *
     * @return array<string>
     */
    public function getJsFiles(): array;

    /**
     * Returns an array of CSS files to be included for this library.
     *
     * @return array<string>
     */
    public function getCssFiles(): array;

    /**
     * Returns a list of libraries that must be included before this library is included.
     *
     * @return array<WebLibraryInterface>
     */
    public function getDependencies(): array;
}
