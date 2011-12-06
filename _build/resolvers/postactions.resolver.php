<?php
if($options[xPDOTransport::PACKAGE_ACTION] == xPDOTransport::ACTION_UPGRADE) {
	$action = 'upgrade';	
} elseif ($options[xPDOTransport::PACKAGE_ACTION] == xPDOTransport::ACTION_INSTALL) {
	$action = 'install';	
}

$success = false;
switch ($action) {  
	case 'upgrade':
        $success = true;
        break;
	case 'install':
		// Create a reference to MODx since this resolver is executed from WITHIN a modCategory
		$modx =& $object->xpdo; 

		if (!isset($modx->vidlister) || $modx->vidlister == null) {
			$modx->addPackage('vidlister', $modx->getOption('core_path').'components/vidlister/model/');
		    $modx->vidlister = $modx->getService('vidlister', 'VidLister', $modx->getOption('core_path').'components/vidlister/model/vidlister/');
		}

		$mgr = $modx->getManager();
        $mgr->createObjectContainer('vlVideo');

		$success = true;
		break;
}