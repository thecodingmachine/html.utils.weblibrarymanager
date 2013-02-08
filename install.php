<?php
use Mouf\MoufUtils;

require_once __DIR__."/../../autoload.php";

use Mouf\Actions\InstallUtils;
use Mouf\MoufManager;

// Let's init Mouf
InstallUtils::init(InstallUtils::$INIT_APP);

// Let's create the instances
$moufManager = MoufManager::getMoufManager();
if (!$moufManager->instanceExists("defaultWebLibraryRenderer")) {
	$moufManager->declareComponent("defaultWebLibraryRenderer", "Mouf\\Html\\Utils\\WebLibraryManager\\DefaultWebLibraryRenderer");
}
if (!$moufManager->instanceExists("defaultWebLibraryManager")) {
	$defaultWebLibraryManager = $moufManager->createInstance("Mouf\\Html\\Utils\\WebLibraryManager\\WebLibraryManager");
	$defaultWebLibraryManager->setName("defaultWebLibraryManager");
	
	if (!$moufManager->instanceExists("rootUrlInlineWebLibrary")) {
		if (!$moufManager->instanceExists("rootUrlJsFile")) {
			$rootUrlJsFile = $moufManager->createInstance("Mouf\\Html\\HtmlElement\\HtmlFromFile");
			$rootUrlJsFile->setName("rootUrlJsFile");
			//$rootUrlJsFile->getProperty("fileName")->setValue(MoufUtils::getUrlPathFromFilePath(__DIR__."/javascript/rootUrl.php"), true);
			$rootUrlJsFile->getProperty("fileName")->setValue("vendor/mouf/html.utils.weblibrarymanager/javascript/rootUrl.php");
		} else {
			$rootUrlJsFile = $moufManager->getInstanceDescriptor("rootUrlJsFile");
		}
	
		$rootUrl = $moufManager->createInstance("Mouf\\Html\\Utils\\WebLibraryManager\\InlineWebLibrary");
		$rootUrl->setName("rootUrlInlineWebLibrary");
		$rootUrl->getProperty("jsElement")->setValue($rootUrlJsFile);
	
		$defaultWebLibraryManager->getProperty("webLibraries")->setValue(array($rootUrl));
	}
}

// Let's rewrite the MoufComponents.php file to save the component
$moufManager->rewriteMouf();

// Finally, let's continue the install
InstallUtils::continueInstall();
?>