<?php
namespace Mouf\Html\Utils\WebLibraryManager;

use Mouf\Html\Renderer\AbstractPackageRendererServiceProvider;

class WebLibraryManagerRendererServiceProvider extends AbstractPackageRendererServiceProvider
{
    /**
     * Returns the path to the templates directory.
     *
     * @return string
     */
    public static function getTemplateDirectory(): string
    {
        $path = \ComposerLocator::getPath('mouf/html.utils.weblibrarymanager');
        return $path.'/templates';
    }
}
