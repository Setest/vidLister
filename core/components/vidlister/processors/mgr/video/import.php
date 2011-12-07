<?php
$modx->log(modX::LOG_LEVEL_INFO,'Triggering OnVidListerImport event.');
$modx->invokeEvent('OnVidListerImport');
$modx->log(modX::LOG_LEVEL_INFO,'Import completed.');

$modx->log(modX::LOG_LEVEL_INFO,'COMPLETED');
