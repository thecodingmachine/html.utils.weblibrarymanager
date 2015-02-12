<?php
namespace Mouf\Html\Utils\WebLibraryManager;

use Mouf\Mvc\Splash\Controllers\Controller;
use Mouf\ClassProxy;

/**
 * This controller is called by the validator in order to fix all components packages if needed.
 * 
 * @author David Négrier
 */
class AssetsIntegrationController extends Controller {
	
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
		$componentsIntegrationController = new ClassProxy("Mouf\\Html\\Utils\\WebLibraryManager\\Components\\ComponentsIntegrationService");
		$componentsIntegrationController->fixAllInAppScope();
		
		header('Location: '.MOUF_URL);
	}
}
