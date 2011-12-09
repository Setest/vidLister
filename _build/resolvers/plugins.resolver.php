<?php

$plugins = array(
    'VidLister' => array(
        'OnVidListerImport'
    )
);

$modx->log(xPDO::LOG_LEVEL_INFO, 'Running Plugin Resolver.');
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
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
                        $evt->set('service', 2);
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
        break;
}