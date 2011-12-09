<?php
$success = false;

// Create a reference to MODx since this resolver is executed from WITHIN a modCategory
$modx =& $object->xpdo;

switch ($options[xPDOTransport::PACKAGE_ACTION]) {

    case xPDOTransport::ACTION_INSTALL:
        $plugins = array(
            'vlYoutube' => array(
                'OnVidListerImport'
            ),
            'vlVimeo' => array(
                'OnVidListerImport'
            ),
        );

        $modx->log(xPDO::LOG_LEVEL_INFO, 'Running Plugin Resolver.');
        foreach ($plugins as $plugin => $pluginEvents) {
            $pluginObj = $modx->getObject('modPlugin', array('name' => $plugin));
            if (!$pluginObj) $modx->log(xPDO::LOG_LEVEL_INFO, 'Cannot get object: ' . $plugin);
            if (empty($pluginEvents)) $modx->log(xPDO::LOG_LEVEL_INFO, 'Cannot get System Events');
            if (!empty($pluginEvents) && $pluginObj) {

                $modx->log(xPDO::LOG_LEVEL_INFO, 'Assigning Events to Plugin ' . $plugin);

                foreach ($pluginEvents as $event) {

                    $evtcount = $modx->getCount('modEvent', array('name' => $event));
                    if ($evtcount != 1) {
                        $evt = $modx->newObject('modEvent');
                        $evt->set('name', $event);
                        $evt->set('service', 6);
                        $evt->set('groupname', 'VidLister');
                        $evt->save();
                    }

                    $intersect = $modx->newObject('modPluginEvent');
                    $intersect->set('event', $event);
                    $intersect->set('pluginid', $pluginObj->get('id'));
                    $intersect->save();
                }
            }
        }
        $success = true;
        break;
    case xPDOTransport::ACTION_UNINSTALL:
        $modx->log(xPDO::LOG_LEVEL_INFO,'Uninstalling . . .');
        $success = true;
        break;
}

return $success;