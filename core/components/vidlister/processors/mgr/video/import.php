<?php
$modx->invokeEvent('OnVidListerImport');
$modx->log(modX::LOG_LEVEL_WARN, $modx->lexicon('vidlister.import.complete'));

$modx->log(modX::LOG_LEVEL_INFO,'COMPLETED');
