<?php
$snippets = array();

$snippets[0] = $modx->newObject('modSnippet');
$snippets[0]->set('id', 0);
$snippets[0]->set('name', 'VidLister');
$snippets[0]->set('description', 'Show video list like gallery');
$snippets[0]->set('snippet', file_get_contents($sources['source_core'].'/elements/snippets/vidlister.snippet.php'));
$snippets[0]->setProperties(
    array(
        array(
            'name' => 'tpl',
            'desc' => 'vidlister.properties.tpl',
            'type' => 'textfield',
            'options' => '',
            'value' => 'vlVideo',
            'lexicon' => 'vidlister:default',
        ),
        array(
            'name' => 'source',
            'desc' => 'vidlister.properties.source',
            'type' => 'textfield',
            'options' => '',
            'value' => '',
            'lexicon' => 'vidlister:default',
        ),
        array(
            'name' => 'limit',
            'desc' => 'vidlister.properties.limit',
            'type' => 'numberfield',
            'options' => '',
            'value' => '10',
            'lexicon' => 'vidlister:default',
        ),
        array(
            'name' => 'offset',
            'desc' => 'vidlister.properties.offset',
            'type' => 'numberfield',
            'options' => '',
            'value' => '0',
            'lexicon' => 'vidlister:default',
        ),
        array(
            'name' => 'totalVar',
            'desc' => 'vidlister.properties.totalvar',
            'type' => 'textfield',
            'options' => '',
            'value' => 'total',
            'lexicon' => 'vidlister:default',
        ),
    )
);