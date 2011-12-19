<?php
/**
 * Default English Lexicon Entries for VidLister
 *
 * @package vidlister
 * @subpackage lexicon
 */
$_lang['vidlister'] = 'VidLister';
$_lang['vidlister.desc'] = 'Show your youtube videos on your site';

$_lang['vidlister.import'] = 'Import videos';
$_lang['vidlister.import.started'] = 'Started [[+source]] import for [[+user]]';
$_lang['vidlister.import.complete'] = 'Imported [[+total]] [[+source]] videos ([[+new]] new) for user [[+user]].';
$_lang['vidlister.import.err'] = 'Import failed.';
$_lang['vidlister.import.err.client'] = 'REST client unavailable.';

$_lang['vidlister.video'] = 'Video';
$_lang['vidlister.videos'] = 'Videos';
$_lang['vidlister.video.new'] = 'New video';
$_lang['vidlister.video.update'] = 'Update video';
$_lang['vidlister.video.remove'] = 'Remove video';
$_lang['vidlister.video.remove.confirm'] = 'Are you sure you want to remove this video?';
$_lang['vidlister.video.error.nf'] = 'Video not found';
$_lang['vidlister.video.active'] = 'Active';
$_lang['vidlister.video.id'] = 'Video ID';
$_lang['vidlister.video.name'] = 'Name';
$_lang['vidlister.video.description'] = 'Description';
$_lang['vidlister.video.keywords'] = 'Keywords';
$_lang['vidlister.video.source'] = 'Source';
$_lang['vidlister.video.author'] = 'Author';
$_lang['vidlister.video.duration'] = 'Duration';
$_lang['vidlister.video.duration.seconds'] = 'Seconds';
$_lang['vidlister.video.advanced'] = 'Advanced';
$_lang['vidlister.video.jsondata'] = 'JSON data';

/* Properties */
$_lang['vidlister.properties.active'] = 'Activate imported videos';
$_lang['vidlister.properties.youtubeuser'] = 'Youtube username';
$_lang['vidlister.properties.vimeouser'] = 'Vimeo username';
$_lang['vidlister.properties.vimeokey'] = 'Vimeo api key (consumer key)';
$_lang['vidlister.properties.vimeosecret'] = 'Vimeo api secret (comsumer secret)';
$_lang['vidlister.properties.tpl'] = 'Video item chunk (template)';
$_lang['vidlister.properties.where'] = 'A JSON-style expression of criteria';
$_lang['vidlister.properties.limit'] = 'Max items per page';
$_lang['vidlister.properties.offset'] = 'First item (0 = first)';
$_lang['vidlister.properties.totalvar'] = 'TotalVar name for getPage';