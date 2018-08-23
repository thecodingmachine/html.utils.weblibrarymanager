<?php


namespace Mouf\Html\Utils\WebLibraryManager;

use Mouf\Html\HtmlElement\HtmlFromFile;
use Mouf\Html\HtmlElement\Scopable;
use Mouf\Html\Renderer\RendererInterface;
use Psr\Container\ContainerInterface;
use TheCodingMachine\Funky\Annotations\Factory;
use TheCodingMachine\Funky\Annotations\Tag;
use TheCodingMachine\Funky\ServiceProvider;

class WebLibraryManagerServiceProvider extends ServiceProvider implements Scopable
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

    private $rootUrl;

    /**
     * @Factory(name="rootUrlInlineWebLibrary", tags={@Tag(name="webLibraries", priority=0.0)})
     */
    public static function createRootUrlWebLibrary(ContainerInterface $container): InlineWebLibrary
    {
        $scope = new self();
        $scope->rootUrl = $container->get('ROOT_URL');

        $webLibrarayManagerDir = \ComposerLocator::getPath('mouf/html.utils.weblibrarymanager');
        $htmlFromFile = new HtmlFromFile($webLibrarayManagerDir.'/javascript/rootUrl.php', $scope);
        return new InlineWebLibrary($htmlFromFile);
    }

    /**
     * Loads the file.
     *
     * @param string $file
     */
    public function loadFile($file)
    {
        require $file;
    }
}
