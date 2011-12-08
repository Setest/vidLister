<?php
$modx->invokeEvent('OnVidListerImport');
$modx->log(modX::LOG_LEVEL_INFO,'COMPLETED');
return $modx->error->success();