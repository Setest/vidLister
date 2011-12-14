<?php
$modx->getService('vidlister','VidLister',$modx->getOption('vidlister.core_path',null,$modx->getOption('core_path').'components/vidlister/').'model/vidlister/',$scriptProperties);

$modx->lexicon->load('vidlister:default');

//settings
$tpl = $modx->getOption('tpl', $scriptProperties, '{"youtube":"vlYoutube","vimeo":"vlVimeo"}');
$scripts = $modx->getOption('scripts', $scriptProperties, '1');
$sortby = $modx->getOption('sortby', $scriptProperties, 'id');
$sortdir = $modx->getOption('sortdir', $scriptProperties, 'ASC');

//template per source set using JSON
$tpls = $modx->fromJSON($tpl);

$where = $modx->getOption('where', $scriptProperties, '');
$where = !empty($where) ? $modx->fromJSON($where) : array();

//getPage setings
$limit = $modx->getOption('limit', $scriptProperties, 10);
$offset = $modx->getOption('offset', $scriptProperties, 0);
$totalVar = $modx->getOption('totalVar', $scriptProperties, 'total');

if($scripts)
{
    $modx->regClientStartupHTMLBlock('<link rel="stylesheet" type="text/css" href="assets/components/vidlister/js/web/prettyphoto/css/prettyPhoto.css" />');
    $modx->regClientStartupScript('assets/components/vidlister/js/web/prettyPhoto/js/jquery.prettyphoto.js');
    $modx->regClientStartupHTMLBlock('<script type="text/javascript">
        $(document).ready(function(){
        	$("a[rel^=\'prettyPhoto\']").prettyPhoto();
        });
      </script>');
}

$output = '';

$c = $modx->newQuery('vlVideo');

//criteria
if (!empty($where)) {
    $c->where($where);
}
$c->andCondition(array('active' => 1));

//set placeholder for getPage
$modx->setPlaceholder($totalVar, $modx->getCount('vlVideo', $c));

$c->sortby($sortby, $sortdir);
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