<?php 
namespace Mouf\Html\Utils\WebLibraryManager;


/**
 * This class is a helper class used to easily develop install process for libraries using WebLibraryManager.
 * <p>It provides a single static method: installLibrary, that can be used in a Mouf install process
 * to install the library and bind it to the default webLibraryManager.</p>
 * 
 * @author David Négrier
 * @Component
 */
use Mouf\MoufManager;

class WebLibraryInstaller {
	
	/**
	 * 
	 * @param string $instanceName The instance name to create
	 * @param array<string> $jsFiles The list of js files to add (relative to root directory)
	 * @param array<string> $cssFiles The list of css files to add (relative to root directory)
	 * @param array<string> $dependencies The list of dependencies (the name of the instances)
	 * @param MoufManager $moufManager The moufManager to be used for installation (defaults to default mouf manager)
	 */
	public static function installLibrary($instanceName, array $jsFiles, array $cssFiles = array(), array $dependencies = array(), $moufManager = null) {
		if ($moufManager == null) {
			$moufManager = MoufManager::getMoufManager();
		}
		
		if ($moufManager->instanceExists($instanceName)) {
			$library = $moufManager->getInstanceDescriptor($instanceName);
		} else {
			$library = $moufManager->createInstance("\\Mouf\\Html\\Utils\\WebLibraryManager\\WebLibrary");
			$library->setName($instanceName);
		}
		$library->getProperty("jsFiles")->setValue($jsFiles);
		$library->getProperty("cssFiles")->setValue($cssFiles);
		
		$renderer = $moufManager->getInstanceDescriptor('defaultWebLibraryRenderer');
		$library->getProperty("renderer")->setValue($renderer);
		
		$dependenciesInstances = array();
		foreach ($dependencies as $dependencyName) {
			$dependenciesInstances[] = $moufManager->getInstanceDescriptor($dependencyName);
		}
		
		$library->getProperty("dependencies")->setValue($dependenciesInstances);
		
		$webLibraryManager = $moufManager->getInstanceDescriptor('defaultWebLibraryManager');
		if ($webLibraryManager) {
			$libraries = $webLibraryManager->getProperty("webLibraries")->getValue();
			$libraries[] = $library;
			$webLibraryManager->getProperty("webLibraries")->setValue($libraries);
		}
		
	}
}
?>