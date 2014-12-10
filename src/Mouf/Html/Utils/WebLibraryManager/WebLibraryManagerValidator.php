<?php
namespace Mouf\Html\Utils\WebLibraryManager;

use Mouf\Validator\MoufStaticValidatorInterface;
use Mouf\Composer\ComposerService;
use Mouf\Validator\MoufValidatorResult;
use Mouf\MoufManager;
use Mouf\Mvc\Splash\Controllers\Controller;
use Mouf\Html\Utils\WebLibraryManager\ComponentInstaller\ComponentInstaller;
use Mouf\ClassProxy;

/**
 * This validator is in charge of checking that "component" and "bower" packages have matching weblibraries 
 * declared in Mouf.
 * 
 * @author David Négrier
 */
class WebLibraryManagerValidator implements MoufStaticValidatorInterface {
	
	/**
	 * Runs the validation of the class.
	 * Returns a MoufValidatorResult explaining the result.
	 *
	 * @return MoufValidatorResult
	 */
	static function validateClass() {
		$composerService = new ComposerService();
		$packages = $composerService->getLocalPackagesOrderedByDependencies();
		
		$componentViolations = array();
		$bowerViolations = array();
		$moufManager = MoufManager::getMoufManager();
		
		foreach ($packages as $package) {
			/* @var $package PackageInterface */
			if ($package->getType() == "component") {
				$extra = $package->getExtra();
				 
				if (isset($extra['component']['name'])) {
					$packageName = $extra['component']['name'];
				} else {
					$packageName = explode('/', $package->getName())[1];
				}
	
				if (!$moufManager->has("component.".$packageName)) {
					$componentViolations[] = $packageName;
				}
			} elseif ($package->getType() == "bower-asset-library") {
				$packageName = explode('/', $package->getName())[1];
				
				if (!$moufManager->has("bower.".$packageName)) {
					$bowerViolations[] = $packageName;
				}
			}
		}

		if (!$componentViolations && !$bowerViolations) {
			return new MoufValidatorResult(MoufValidatorResult::SUCCESS, "<b>WebLibraryManager: </b>No missing WebLibrary for Bower or Components packages.");
		} else {
			return new MoufValidatorResult(MoufValidatorResult::ERROR, "<b>WebLibraryManager: </b>Missing matching WebLibrary for package(s) ".implode(', ', array_merge($componentViolations, $bowerViolations)).
				"<div><a href='".MOUF_URL."assetsIntegration/fixAll' class='btn btn-success'>Click here to create all web-libraries matching these packages</a></div>");
		}
	}
}