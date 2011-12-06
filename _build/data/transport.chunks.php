<?php
$chunks = array();

$chunks[0] = $modx->newObject('modChunk');
$chunks[0]->set('id', 0);
$chunks[0]->set('name', 'vlVideo');
$chunks[0]->set('description', 'Video thumbnail');
$chunks[0]->set('snippet', file_get_contents($sources['source_core'].'/elements/chunks/vlVideo.chunk.tpl'));