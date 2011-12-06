<?php
if($modx->removeObject('vlVideo', array('id' => $_REQUEST['id']))) {
    return $modx->error->success('');
}
else {
	return $modx->error->failure($modx->lexicon('vidlister.video.error.nf'));
}