<?php
/*
 * Copyright (c) 2012-2014 David Negrier
 * 
 * See the file LICENSE.txt for copying permission.
 */

use Mouf\MoufManager;

// Force loading our controller instead of the one provided by Mouf.
require_once __DIR__.'/Mouf/Html/Utils/WebLibraryManager/AssetsIntegrationController.php';

// Controller declaration
$moufManager = MoufManager::getMoufManager();
$moufManager->declareComponent('assetsIntegration', 'Mouf\\Html\\Utils\\WebLibraryManager\\AssetsIntegrationController', true);
$moufManager->bindComponents('assetsIntegration', 'template', 'moufTemplate');
$moufManager->bindComponents('assetsIntegration', 'content', 'block.content');
