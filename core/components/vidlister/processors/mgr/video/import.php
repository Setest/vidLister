<?php
$modx->invokeEvent('OnVidListerImport');
$modx->log(modX::LOG_LEVEL_INFO,'COMPLETED');
sleep(3);
return $modx->error->success();