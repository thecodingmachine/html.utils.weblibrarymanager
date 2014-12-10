<?php
namespace Mouf\Html\Utils\WebLibraryManager\Components;

use Mouf\Validator\MoufStaticValidatorInterface;
use Mouf\Composer\ComposerService;
use Mouf\Validator\MoufValidatorResult;
use Mouf\MoufManager;
use Mouf\Mvc\Splash\Controllers\Controller;
use Mouf\Html\Utils\WebLibraryManager\ComponentInstaller\ComponentInstaller;
use Mouf\ClassProxy;

/**
 * This service is in charge of integrating the "components" JS/CSS packages notion
 * with the WebLibraryManager.
 * It offers features for mapping components (as defined in http://github.com/robloach/component-installer)
 * into WebLibraries. 
 * 
 * @author David Négrier
 */
class ComponentsIntegrationService {
	
	public static function fixAllInAppScope() {
		$composerService = new ComposerService();
		$packages = $composerService->getLocalPackagesOrderedByDependencies();
		
		$moufManager = MoufManager::getMoufManager();
		
		foreach ($packages as $package) {
			/* @var $package PackageInterface */
			if ($package->getType() != "component") {
				continue;
			}
				
			ComponentInstaller::installComponent($package, $composerService->getComposerConfig(), $moufManager);
		}
	}
}