<?php
if($modx->event->name == 'OnVidListerImport') {

    $modx->log(modx::LOG_LEVEL_INFO,'Inside youtube import.');

    $modx->getService('vidlister','VidLister',$modx->getOption('vidlister.core_path',null,$modx->getOption('core_path').'components/vidlister/').'model/vidlister/',$scriptProperties);

    if (empty($modx->rest)) {
        $modx->getService('rest','rest.modRestClient');
        $loaded = $modx->rest->getConnection();
        if (!$loaded) return 'geen client beschikbaar';
    }

    $user = $modx->getOption('user', $scriptProperties, 'unknown');

    @$response = $modx->rest->request('http://gdata.youtube.com','/feeds/api/users/'.$user.'/uploads','GET', array(), array())->response;
    if(empty($response)) {
        $modx->log(MODX_LOG_LEVEL_ERROR, '[VidLister] Import failed. Youtube returned empty response.');
        exit;
    }

    $xmlvideos = simplexml_load_string($response);

    $ids = array();

    foreach($xmlvideos->entry as $xmlvideo)
    {
        $media = $xmlvideo->children('http://search.yahoo.com/mrss/');
        $yt = $media->children('http://gdata.youtube.com/schemas/2007');

        $video = $modx->getObject('vlVideo', array('videoId' => str_replace('http://gdata.youtube.com/feeds/api/videos/', '', $xmlvideo->id)));
        if(!is_object($video))
        {
            $video = $modx->newObject('vlVideo');
            $video->fromArray(array(
                'source' => 'youtube',
                'videoId' =>  str_replace('http://gdata.youtube.com/feeds/api/videos/', '', $xmlvideo->id),
                'name' => $xmlvideo->title,
                'description' => $xmlvideo->content,
                'author' => $xmlvideo->author->name,
                'keywords' => $media->group->keywords,
                'duration' => $yt->duration->attributes()->seconds,
                'jsondata' => ''
            ));
        }
        else
        {
            $video->fromArray(array(
                'author' => $xmlvideo->author->name,
                'duration' => $yt->duration->attributes()->seconds
            ));
        }
        $video->save();
        $ids[] = $video->get('id');
    }

    $modx->removeCollection('vlVideo', array('source' => 'youtube', 'author' => $user, 'id NOT IN('.implode(',', $ids).')'));
}
else {
    return false;
}