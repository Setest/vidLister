<?php
$plugins = array();

$plugins[0] = $modx->newObject('modPlugin');
$plugins[0]->set('id', 0);
$plugins[0]->set('name', 'VidLister');
$plugins[0]->set('description', 'Imports Youtube videos for VidLister');
$plugins[0]->set('plugincode', file_get_contents($sources['source_core'].'/elements/plugins/vidlister.plugin.php'));

$plugins[0]->setProperties(array(
    array(
        'name' => 'user',
        'desc' => 'vidlister.properties.youtubeuser',
        'type' => 'textfield',
        'options' => '',
        'value' => 'youtube-username',
        'lexicon' => 'vidlister:default',
    ),
));