<?php
$modx->getService('vidlister','VidLister',$modx->getOption('vidlister.core_path',null,$modx->getOption('core_path').'components/vidlister/').'model/vidlister/',$scriptProperties);

$modx->lexicon->load('vidlister:default');

//settings
$tpl = $modx->getOption('tpl', $scriptProperties, '{"youtube":"vlYoutube","vimeo":"vlVimeo"}');

//template per source set using JSON
$tpls = $modx->fromJSON($tpl);

$where = $modx->getOption('where', $scriptProperties, '');
$where = !empty($where) ? $modx->fromJSON($where) : array();

//getPage setings
$limit = $modx->getOption('limit', $scriptProperties, 10);
$offset = $modx->getOption('offset', $scriptProperties, 0);
$totalVar = $modx->getOption('totalVar', $scriptProperties, 'total');

$output = '';

$c = $modx->newQuery('vlVideo');

//criteria
if (!empty($where)) {
    $c->where($where);
}
$c->andCondition(array('active' => 1));

//set placeholder for getPage
$modx->setPlaceholder($totalVar, $modx->getCount('vlVideo', $c));

$c->limit($limit, $offset);

$videos = $modx->getCollection('vlVideo', $c);
foreach($videos as $video)
{
    $duration = $video->duration();

    $video = $video->toArray();
    $source = $video['source'];
    $video['duration'] = $duration;
    $video['image'] = $modx->getOption('assets_url').'components/vidlister/images/'.$video['id'].'.jpg';

    if(isset($tpls[$source]))
    {
        $output .= $modx->getChunk($tpls[$source], $video);
    }
    else
    {
        $output .= $modx->getChunk($tpl, $video);
    }
}

return $output;