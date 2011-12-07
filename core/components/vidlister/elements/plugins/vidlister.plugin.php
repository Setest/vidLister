<?php
if($modx->event->name == 'OnVidListerImport') {

    $modx->getService('vidlister','VidLister',$modx->getOption('vidlister.core_path',null,$modx->getOption('core_path').'components/vidlister/').'model/vidlister/',$scriptProperties);
    $modx->lexicon->load('vidlister:default');

    if (empty($modx->rest)) {
        $modx->getService('rest','rest.modRestClient');
        $loaded = $modx->rest->getConnection();
        if (!$loaded) return $modx->lexicon('vidlister.import.err.client');
    }

    $user = $modx->getOption('user', $scriptProperties, 'unknown');

    $users = explode(',', $user);

    foreach($users as $user)
    {
        $modx->log(modx::LOG_LEVEL_WARN, $modx->lexicon('vidlister.import.started', array('source' => 'Youtube', 'user' => $user)));

        @$response = $modx->rest->request('http://gdata.youtube.com','/feeds/api/users/'.$user.'/uploads','GET', array(), array())->response;
        //@ to prevent PHP notice about $xml being empty (???)
        if(empty($response)) {
            $modx->log(MODX_LOG_LEVEL_ERROR,  $modx->lexicon('vidlister.import.err'));
            continue; //next user
        }

        $xmlvideos = simplexml_load_string($response);

        //every movie not in this array will be deleted after import (no longer on Youtube)
        $ids = array();

        $newVids = 0;
        $totalVids = 0;

        foreach($xmlvideos->entry as $xmlvideo)
        {
            $media = $xmlvideo->children('http://search.yahoo.com/mrss/');
            $yt = $media->children('http://gdata.youtube.com/schemas/2007');

            $video = $modx->getObject('vlVideo', array('videoId' => str_replace('http://gdata.youtube.com/feeds/api/videos/', '', $xmlvideo->id)));
            if(!is_object($video))
            {
                //new video so set all fields
                $video = $modx->newObject('vlVideo');
                $video->fromArray(array(
                    'source' => 'youtube',
                    'videoId' =>  str_replace('http://gdata.youtube.com/feeds/api/videos/', '', $xmlvideo->id),
                    'name' => $xmlvideo->title,
                    'description' => $xmlvideo->content,
                    'author' => $xmlvideo->author->name,
                    'keywords' => $media->group->keywords,
                    'duration' => $yt->duration->attributes()->seconds,
                    'jsondata' => $modx->toJSON(array(
                        'flashUrl' => $media->group->content[0]->attributes()->url,
                        '3gppUrl' => $media->group->content[1]->attributes()->url
                    ))
                ));
                $newVids++;
            }
            else
            {
                //existing video, so don't overwrite name/description/keywords/jsondata
                $video->fromArray(array(
                    'author' => $xmlvideo->author->name,
                    'duration' => $yt->duration->attributes()->seconds
                ));
            }
            $video->save();
            $ids[] = $video->get('id');
            $totalVids++;
        }

        $modx->log(modx::LOG_LEVEL_INFO,'Imported '.$totalVids.' youtube videos. ('.$newVids.' new)');

        $modx->removeCollection('vlVideo', array('source' => 'youtube', 'author' => $user, 'id NOT IN('.implode(',', $ids).')'));
    }
}