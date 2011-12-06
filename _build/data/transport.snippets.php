<?php
$snippets = array();

$snippets[0] = $modx->newObject('modSnippet');
$snippets[0]->set('id', 0);
$snippets[0]->set('name', 'VidLister');
$snippets[0]->set('description', 'Show video list like gallery');
$snippets[0]->set('snippet', file_get_contents($sources['source_core'].'/elements/snippets/vidlister.snippet.php'));
