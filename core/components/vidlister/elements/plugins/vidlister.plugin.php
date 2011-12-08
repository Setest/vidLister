<?php
if($modx->event->name == 'OnVidListerImport')
{
    $modx->getService('vidlister','VidLister',$modx->getOption('vidlister.core_path',null,$modx->getOption('core_path').'components/vidlister/').'model/vidlister/',$scriptProperties);
    $modx->lexicon->load('vidlister:default');

    if (empty($modx->rest))
    {
        $modx->getService('rest','rest.modRestClient');
        $loaded = $modx->rest->getConnection();
        if (!$loaded) return $modx->lexicon('vidlister.import.err.client');
    }

    $user = $modx->getOption('user', $scriptProperties, 'unknown'); //get user name(s)

    $users = explode(',', $user); //user names are comma separated

    foreach($users as $user)
    {
        $modx->log(modx::LOG_LEVEL_WARN, $modx->lexicon('vidlister.import.started', array('source' => 'Youtube', 'user' => $user)));

        @$response = $modx->rest->request('http://gdata.youtube.com','/feeds/api/users/'.$user.'/uploads','GET', array(), array())->response;
        //@ to prevent PHP notice about $xml being empty (???)
        if(empty($response)) {
            $modx->log(MODX_LOG_LEVEL_ERROR,  $modx->lexicon('vidlister.import.err'));
            continue; //response was empty, so go to next user
        }

        //create SimpleXmlElement
        $xmlvideos = simplexml_load_string($response);

        //every movie not in this array will be deleted after import (no longer on Youtube)
        $ids = array();

        //new/total counter for current user
        $newVids = 0;
        $totalVids = 0;

        //loop through video entries
        foreach($xmlvideos->entry as $xmlvideo)
        {
            //next 2 lines allow to get namespace data in media: and yt: namespace
            $media = $xmlvideo->children('http://search.yahoo.com/mrss/');
            $yt = $media->children('http://gdata.youtube.com/schemas/2007');

            //get existing video
            $video = $modx->getObject('vlVideo', array('source' => 'youtube', 'videoId' => str_replace('http://gdata.youtube.com/feeds/api/videos/', '', $xmlvideo->id)));
            if(!is_object($video))
            {
                //not found, so create new video and set all fields
                $video = $modx->newObject('vlVideo');
                $video->fromArray(array(
                    'source' => 'youtube',
                    'videoId' =>  str_replace('http://gdata.youtube.com/feeds/api/videos/', '', $xmlvideo->id),
                    'name' => $xmlvideo->title,
                    'description' => $xmlvideo->content,
                    'author' => $xmlvideo->author->name,
                    'keywords' => $media->group->keywords,
                    'duration' => $yt->duration->attributes()->seconds,
                    'jsondata' => array(
                        'flashUrl' => (string)$media->group->content[0]->attributes()->url,
                        '3gppUrl' => (string)$media->group->content[1]->attributes()->url
                    )
                ));
                $newVids++;
            }
            else
            {
                //existing video, so don't overwrite name/description/keywords
                $video->fromArray(array(
                    'author' => $xmlvideo->author->name,
                    'duration' => $yt->duration->attributes()->seconds,
                    'jsondata' => array_merge(
                        $video->get('jsondata'),
                        array(
                            'flashUrl' => (string)$media->group->content[0]->attributes()->url,
                            '3gppUrl' => (string)$media->group->content[1]->attributes()->url
                        )
                    )
                ));
            }
            $video->save();

            //get image
            file_put_contents(
                $modx->getOption('assets_path').'components/vidlister/images/'.$video->get('id').'.jpg',
                file_get_contents($media->group->thumbnail[0]->attributes()->url)
            );

            $ids[] = $video->get('id'); //add to found/created ID's array
            $totalVids++;
        }

        $modx->log(modx::LOG_LEVEL_INFO, $modx->lexicon('vidlister.import.complete', array('user' => $user, 'source' => 'Youtube', 'total' => $totalVids, 'new' => $newVids)));

        //remove all videos not found in XML
        $modx->removeCollection('vlVideo', array('source' => 'youtube', 'author' => $user, 'id NOT IN('.implode(',', $ids).')'));
    }
}