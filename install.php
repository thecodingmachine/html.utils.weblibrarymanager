<?php
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
	$moufManager->declareComponent("defaultWebLibraryManager", "Mouf\\Html\\Utils\\WebLibraryManager\\WebLibraryManager");
}

// Let's rewrite the MoufComponents.php file to save the component
$moufManager->rewriteMouf();

// Finally, let's continue the install
InstallUtils::continueInstall();
?>