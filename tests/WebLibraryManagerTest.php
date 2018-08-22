<?php

namespace Mouf\Html\Utils\WebLibraryManager;

use Interop\Container\ServiceProviderInterface;
use PHPUnit\Framework\TestCase;
use Simplex\Container;
use TheCodingMachine\Discovery\Discovery;

class WebLibraryManagerTest extends TestCase
{
    public function testToHtml()
    {
        $serviceProvidersNames = Discovery::getInstance()->get(ServiceProviderInterface::class);
        $serviceProviders = \array_map(function(string $className) {
            return new $className();
        }, $serviceProvidersNames);
        $container = new Container($serviceProviders);
        $container->set('ROOT_URL', '/foo/bar');

        /* @var WebLibraryManager $webLibraryManager */
        $webLibraryManager = $container->get(WebLibraryManager::class);
        \ob_start();
        $webLibraryManager->toHtml();
        $content = \ob_get_clean();

        $this->assertSame('<script type="text/javascript">
window.rootUrl = "\/foo\/bar"</script>
', $content);
    }
}
