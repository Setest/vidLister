<?php
$modx->getService('vidlister','VidLister',$modx->getOption('vidlister.core_path',null,$modx->getOption('core_path').'components/vidlister/').'model/vidlister/',$scriptProperties);

//settings
$tpl = $modx->getOption('tpl', $scriptProperties, 'vlVideo');
$navTpl = $modx->getOption('navTpl', $scriptProperties, 'vlNav');
$source = $modx->getOption('source', $scriptProperties, '');

//getPage setings
$limit = $modx->getOption('limit', $scriptProperties, 10);
$offset = $modx->getOption('offset', $scriptProperties, 0);
$totalVar = $modx->getOption('totalVar', $scriptProperties, 'total');

$output = '';

$c = $modx->newQuery('vlVideo');
$conditions = array();
if( !empty($source))
{
    $conditions['source'] = $source;
}
$c->andCondition($conditions);

//set placeholder for getPage
$modx->setPlaceholder($totalVar, $modx->getCount('vlVideo', $c));

$c->limit($limit, $offset);

$videos = $modx->getCollection('vlVideo', $c);
foreach($videos as $video)
{
    $output .= $modx->getChunk($tpl, $video->toArray());
}

return $output;