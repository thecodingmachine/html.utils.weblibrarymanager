<?php
namespace Mouf\Html\Utils\WebLibraryManager\Components;

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
class BowerIntegrationController extends Controller implements MoufStaticValidatorInterface {
	
	/**
	 *
	 * @var HtmlBlock
	 */
	public $content;
	
	/**
	 * The template used by the main page for mouf.
	 *
	 * @var TemplateInterface
	 */
	public $template;
	
	/**
	 * @Action
	 */
	public function fixAll() {
		$componentsIntegrationController = new ClassProxy("Mouf\\Html\\Utils\\WebLibraryManager\\Bower\\BowerIntegrationController");
		$componentsIntegrationController->fixAllInAppScope();
		
		header('Location: '.MOUF_URL);
	}
	
	public static function fixAllInAppScope() {
		$composerService = new ComposerService();
		$packages = $composerService->getLocalPackagesOrderedByDependencies();
		
		$moufManager = MoufManager::getMoufManager();
		
		foreach ($packages as $package) {
			/* @var $package PackageInterface */
			if ($package->getType() != "bower-asset") {
				continue;
			}
				
			BowerInstaller::installComponent($package, $composerService->getComposerConfig(), $moufManager);
		}
	}
	
	/**
	 * Runs the validation of the class.
	 * Returns a MoufValidatorResult explaining the result.
	 *
	 * @return MoufValidatorResult
	 */
	static function validateClass() {
		$composerService = new ComposerService();
		$packages = $composerService->getLocalPackagesOrderedByDependencies();
		
		$violations = array();
		$moufManager = MoufManager::getMoufManager();
		
		foreach ($packages as $package) {
			/* @var $package PackageInterface */
			if ($package->getType() != "bower-asset") {
				continue;
			}
			
			$packageName = explode('/', $package->getName())[1];

			if (!$moufManager->has("bower.".$packageName)) {
				$violations[] = $packageName;
			}
		}

		if (!$violations) {
			return new MoufValidatorResult(MoufValidatorResult::SUCCESS, "<b>WebLibraryManager: </b>No missing WebLibrary for Bower packages.");
		} else {
			return new MoufValidatorResult(MoufValidatorResult::ERROR, "<b>WebLibraryManager: </b>Missing matching WebLibrary for package(s) ".implode(', ', $violations).
				"<div><a href='".MOUF_URL."bowerIntegration/fixAll' class='btn btn-success'>Click here to create all web-libraries matching these packages</a></div>");
		}
	}
}