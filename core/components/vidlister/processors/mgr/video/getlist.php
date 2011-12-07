<?php
/**
 * Get a list of videos
 *
 * @package vidlister
 * @subpackage processors
 */
/* setup default properties */
$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,20);
$sort = $modx->getOption('sort',$scriptProperties,'id');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$query = $modx->getOption('query',$scriptProperties,'');

/* build query */
$c = $modx->newQuery('vlVideo');

if (!empty($query)) {
    $c->where(array(
        'name:LIKE' => '%'.$query.'%'
    ));
}

$count = $modx->getCount('vlVideo',$c);
$c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);
$videos = $modx->getIterator('vlVideo', $c);

/* iterate */
$list = array();
foreach ($videos as $video) {
    $video = $video->toArray();
    $video['jsondata'] = $modx->toJSON($video['jsondata']);
    $list[]= $video;
}
return $this->outputArray($list,$count);