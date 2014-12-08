<?php
/*
 * Copyright (c) 2012-2014 David Negrier
 * 
 * See the file LICENSE.txt for copying permission.
 */

use Mouf\MoufManager;

// Force loading our controller instead of the one provided by Mouf.
require_once __DIR__.'/Mouf/Html/Utils/WebLibraryManager/Components/ComponentsIntegrationController.php';

// Controller declaration
$moufManager = MoufManager::getMoufManager();
$moufManager->declareComponent('componentsIntegration', 'Mouf\\Html\\Utils\\WebLibraryManager\\Components\\ComponentsIntegrationController', true);
$moufManager->bindComponents('componentsIntegration', 'template', 'moufTemplate');
$moufManager->bindComponents('componentsIntegration', 'content', 'block.content');
