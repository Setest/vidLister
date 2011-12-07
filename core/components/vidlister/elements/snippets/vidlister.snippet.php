<?php
$modx->log(modX::LOG_LEVEL_INFO, 'Starting import by triggering VidListerImport event');
$modx->invokeEvent('OnVidListerImport');
$modx->log(modX::LOG_LEVEL_INFO, 'COMPLETED');