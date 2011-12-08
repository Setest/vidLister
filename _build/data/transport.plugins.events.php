<?php
/**
 * @package vidlister
 * @subpackage build
 */
$events = array();

$events['OnVidListerImport']= $modx->newObject('modPluginEvent');
$events['OnVidListerImport']->fromArray(array(
    'event' => 'OnVidListerImport',
    'priority' => 0,
    'propertyset' => 0,
),'',true,true);

return $events;