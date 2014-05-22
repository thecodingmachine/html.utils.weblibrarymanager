<?php
namespace Mouf\Html\Utils\WebLibraryManager\Components;

use Mouf\Validator\MoufStaticValidatorInterface;
use Mouf\Composer\ComposerService;
use Mouf\Validator\MoufValidatorResult;
use Mouf\MoufManager;
use Mouf\Mvc\Splash\Controllers\Controller;
use Mouf\Html\Utils\WebLibraryManager\WebLibraryInstaller;

/**
 * This controller is in charge of integrating the "components" JS/CSS packages notion
 * with the WebLibraryManager.
 * It offers features for mapping components (as defined in http://github.com/robloach/component-installer)
 * into WebLibraries. 
 * 
 * @author David Négrier
 */
class ComponentsIntegrationController extends Controller implements MoufStaticValidatorInterface {
	
	/**
	 *
	 * @var HtmlBlock
	 */
	public $content;
	
	/**
	 * The template used by the main page for mouf.
	 *
	 * @Property
	 * @Compulsory
	 * @var TemplateInterface
	 */
	public $template;
	
	/**
	 * @Action
	 */
	public function fixAll() {

		$composerService = new ComposerService();
		$packages = $composerService->getLocalPackagesOrderedByDependencies();
		
		$violations = array();
		$moufManager = MoufManager::getMoufManager();
		
		foreach ($packages as $package) {
			/* @var $package PackageInterface */
			if ($package->getType() != "component") {
				continue;
			}
		
			$packageName = explode('/', $package->getName())[1];
			
			if (!$moufManager->has("component.".$package->getName())) {
				$extra = $package->getExtra();
				
				// FIXME: 'components' directory can be changed in config
				// FIXME: check CSS and deps
				$scripts = [];
				if (isset($extra['component']['scripts'])) {
					$scripts = array_map(function($script) use ($packageName) {
						return 'components/'.$packageName.'/'.$script;
					}, $extra['component']['scripts']);
				}

				$css = [];
				if (isset($extra['component']['css'])) {
					$css = array_map(function($script) use ($packageName) {
						return 'components/'.$packageName.'/'.$script;
					}, $extra['component']['css']);
				}
				
				$deps = [];
				if (isset($extra['component']['deps'])) {
					$deps = array_map(function($script) {
						return "component.".$script;
					}, $extra['component']['css']);
				}

				WebLibraryInstaller::installLibrary("component.".$packageName, $scripts, $css, $deps);
			}
			$moufManager->rewriteMouf();
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
			if ($package->getType() != "component") {
				continue;
			}

			$packageName = explode('/', $package->getName())[1];
			
			if (!$moufManager->has("component.".$packageName)) {
				$violations[] = $packageName;
			}
		}

		if (!$violations) {
			return new MoufValidatorResult(MoufValidatorResult::SUCCESS, "<b>WebLibraryManager: </b>No missing WebLibrary for components.");
		} else {
			return new MoufValidatorResult(MoufValidatorResult::ERROR, "<b>WebLibraryManager: </b>Missing matching WebLibrary for package(s) ".implode(', ', $violations).
				"<div><a href='".MOUF_URL."componentsIntegration/fixAll' class='btn btn-success'>Click here to create all web-libraries matching these packages</a></div>");
		}
	}
}