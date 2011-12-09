<?php
$plugins = array();

$plugins[0] = $modx->newObject('modPlugin');
$plugins[0]->set('id', 0);
$plugins[0]->set('name', 'vlYoutube');
$plugins[0]->set('description', 'Imports Youtube videos for VidLister');
$plugins[0]->set('plugincode', file_get_contents($sources['source_core'].'/elements/plugins/vlYoutube.plugin.php'));

$plugins[0]->setProperties(array(
    array(
        'name' => 'user',
        'desc' => 'vidlister.properties.youtubeuser',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'vidlister:default',
    ),
));

$plugins[1] = $modx->newObject('modPlugin');
$plugins[1]->set('id', 0);
$plugins[1]->set('name', 'vlVimeo');
$plugins[1]->set('description', 'Imports Vimeo videos for VidLister');
$plugins[1]->set('plugincode', file_get_contents($sources['source_core'].'/elements/plugins/vlVimeo.plugin.php'));

$plugins[1]->setProperties(array(
    array(
        'name' => 'user',
        'desc' => 'vidlister.properties.vimeouser',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'vidlister:default',
    ),
    array(
        'name' => 'consumer_key',
        'desc' => 'vidlister.properties.vimeokey',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'vidlister:default',
    ),
    array(
        'name' => 'consumer_secret',
        'desc' => 'vidlister.properties.vimeosecret',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'vidlister:default',
    ),
));