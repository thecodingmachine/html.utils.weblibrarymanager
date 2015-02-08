<?php
/*
 * Copyright (c) 2013-2014 David Negrier
 * 
 * See the file LICENSE.txt for copying permission.
 */

namespace Mouf\Html\Utils\WebLibraryManager;

use Mouf\Html\Utils\WebLibraryManager\Components\ComponentsIntegrationService;
use Mouf\Installer\PackageInstallerInterface;
use Mouf\MoufManager;
use Mouf\Html\Renderer\RendererUtils;

/**
 * An installer class for the WebLibraryManager library.
 */
class WebLibraryManagerInstaller implements PackageInstallerInterface {

	/**
	 * (non-PHPdoc)
	 * @see \Mouf\Installer\PackageInstallerInterface::install()
	 */
	public static function install(MoufManager $moufManager) {
		// Let's create the instances
		if (!$moufManager->instanceExists("defaultWebLibraryManager")) {
			$defaultWebLibraryManager = $moufManager->createInstance("Mouf\\Html\\Utils\\WebLibraryManager\\WebLibraryManager");
			$defaultWebLibraryManager->setName("defaultWebLibraryManager");
			
			if (!$moufManager->instanceExists("rootUrlInlineWebLibrary")) {
				if (!$moufManager->instanceExists("rootUrlJsFile")) {
					$rootUrlJsFile = $moufManager->createInstance("Mouf\\Html\\HtmlElement\\HtmlFromFile");
					$rootUrlJsFile->setName("rootUrlJsFile");
					$rootUrlJsFile->getProperty("fileName")->setValue("vendor/mouf/html.utils.weblibrarymanager/javascript/rootUrl.php");
				} else {
					$rootUrlJsFile = $moufManager->getInstanceDescriptor("rootUrlJsFile");
				}
			
				$rootUrl = $moufManager->createInstance("Mouf\\Html\\Utils\\WebLibraryManager\\InlineWebLibrary");
				$rootUrl->setName("rootUrlInlineWebLibrary");
				$rootUrl->getProperty("jsElement")->setValue($rootUrlJsFile);
			
				$defaultWebLibraryManager->getProperty("webLibraries")->setValue(array($rootUrl));
			}
		} else {
			$defaultWebLibraryManager = $moufManager->getInstanceDescriptor('defaultWebLibraryManager');
		}

		if ($moufManager->has("defaultRenderer") && $defaultWebLibraryManager->getConstructorArgumentProperty("renderer")->getValue() === null) {
			$defaultWebLibraryManager->getConstructorArgumentProperty("renderer")->setValue($moufManager->getInstanceDescriptor('defaultRenderer'));
		}
		
		
		RendererUtils::createPackageRenderer($moufManager, "mouf/html.utils.weblibrarymanager");

		// Let's register all "components" based libraries that have not been registered so far:
		ComponentsIntegrationService::fixAllInAppScope();

		// Let's rewrite the MoufComponents.php file to save the component
		$moufManager->rewriteMouf();
	}
}
