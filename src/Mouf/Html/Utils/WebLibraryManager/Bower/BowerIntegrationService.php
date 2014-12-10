<?php
namespace Mouf\Html\Utils\WebLibraryManager\Bower;

use Mouf\Validator\MoufStaticValidatorInterface;
use Mouf\Composer\ComposerService;
use Mouf\Validator\MoufValidatorResult;
use Mouf\MoufManager;
use Mouf\Mvc\Splash\Controllers\Controller;
use Mouf\Html\Utils\WebLibraryManager\BowerInstaller\BowerInstaller;
use Mouf\ClassProxy;

/**
 * This controller is in charge of integrating Bower packages with the WebLibraryManager.
 * It offers features for mapping Bower packages (as defined in http://github.com/francoispluchino/composer-asset-plugin)
 * into WebLibraries. 
 * 
 * @author David Négrier
 */
class BowerIntegrationService {
	
	public static function fixAllInAppScope() {
		$composerService = new ComposerService();
		$packages = $composerService->getLocalPackagesOrderedByDependencies();
		
		$moufManager = MoufManager::getMoufManager();
		
		$rootPackage = $composerService->getComposer()->getPackage();
		
		foreach ($packages as $package) {
			/* @var $package PackageInterface */
			if ($package->getType() != "bower-asset-library") {
				continue;
			}
				
			BowerInstaller::installBowerPackage($package, $composerService->getComposerConfig(), $moufManager, $rootPackage);
		}
	}
	
}