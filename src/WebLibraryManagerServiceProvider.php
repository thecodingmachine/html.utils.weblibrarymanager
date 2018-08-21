<?php


namespace Mouf\Html\Utils\WebLibraryManager;

use Mouf\Html\HtmlElement\HtmlFromFile;
use Mouf\Html\Renderer\RendererInterface;
use Psr\Container\ContainerInterface;
use TheCodingMachine\Funky\Annotations\Factory;
use TheCodingMachine\Funky\Annotations\Tag;
use TheCodingMachine\Funky\ServiceProvider;

class WebLibraryManagerServiceProvider extends ServiceProvider
{
    /**
     * @Factory()
     */
    public static function createWebLibraryManager(ContainerInterface $container, RendererInterface $renderer): WebLibraryManager
    {
        return new WebLibraryManager($renderer, \iterator_to_array($container->get('webLibraries')));
    }

    /**
     * @Factory(name="webLibraries")
     */
    public static function createWebLibraries(): \SplPriorityQueue
    {
        return new \SplPriorityQueue();
    }

    /**
     * @Factory(name="rootUrlInlineWebLibrary", tags={@Tag(name="webLibraries", priority=0)})
     */
    public static function createRootUrlWebLibrary(): InlineWebLibrary
    {
        $htmlFromFile = new HtmlFromFile('vendor/mouf/html.utils.weblibrarymanager/javascript/rootUrl.php');
        return new InlineWebLibrary($htmlFromFile);
    }
}
