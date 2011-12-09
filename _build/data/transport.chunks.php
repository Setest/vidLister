<?php
$chunks = array();

$chunks[0] = $modx->newObject('modChunk');
$chunks[0]->set('id', 0);
$chunks[0]->set('name', 'vlVimeo');
$chunks[0]->set('description', 'Vimeo video');
$chunks[0]->set('snippet', file_get_contents($sources['source_core'].'/elements/chunks/vlVimeo.chunk.tpl'));

$chunks[1] = $modx->newObject('modChunk');
$chunks[1]->set('id', 0);
$chunks[1]->set('name', 'vlYoutube');
$chunks[1]->set('description', 'Youtube video');
$chunks[1]->set('snippet', file_get_contents($sources['source_core'].'/elements/chunks/vlYoutube.chunk.tpl'));