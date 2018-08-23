<?php

namespace Mouf\Html\Utils\WebLibraryManager;

use Interop\Container\ServiceProviderInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Simplex\Container;
use TheCodingMachine\Discovery\Discovery;
use TheCodingMachine\Funky\Annotations\Factory;
use TheCodingMachine\Funky\Annotations\Tag;
use TheCodingMachine\Funky\ServiceProvider;

class WebLibraryManagerTest extends TestCase
{
    public function testToHtml()
    {
        $webLibraryServiceProvider = new class extends ServiceProvider {
            /**
             * @Factory(name="myWebLibrary", tags={@Tag(name="webLibraries")})
             */
            public static function createWebLibrary(ContainerInterface $container): WebLibrary
            {
                return new WebLibrary(['foo/bar.js', 'http://exemple.com/foo.js'],
                    ['foo/bar.css', 'http://exemple.com/foo.css'], $container->get('ROOT_URL'));
            }
        };

        $serviceProvidersNames = Discovery::getInstance()->get(ServiceProviderInterface::class);
        $serviceProviders = \array_map(function(string $className) {
            return new $className();
        }, $serviceProvidersNames);
        $serviceProviders[] = $webLibraryServiceProvider;

        $container = new Container($serviceProviders);
        $container->set('ROOT_URL', '/foo/bar/');

        /* @var WebLibraryManager $webLibraryManager */
        $webLibraryManager = $container->get(WebLibraryManager::class);
        \ob_start();
        $webLibraryManager->toHtml();
        $content = \ob_get_clean();

        $this->assertSame('<link href=\'/foo/bar/foo/bar.css\' rel=\'stylesheet\' type=\'text/css\' />
<link href=\'http://exemple.com/foo.css\' rel=\'stylesheet\' type=\'text/css\' />
<script type="text/javascript">
window.rootUrl = "\/foo\/bar\/"</script>
<script type="text/javascript" src="/foo/bar/foo/bar.js" ></script>
<script type="text/javascript" src="http://exemple.com/foo.js" ></script>
', $content);
    }
}
