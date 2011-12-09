#############################################################
#            VidLister: show videos on your site            #
#                                                           #
# Version: 1.0.0 alpha                                      #
# Released: 2011-12-09                                      #
#                                                           #
# Author: Jeroen Kenters Web Development / www.kenters.com  #
#                                                           #
# License: GNU GENERAL PUBLIC LICENSE, Version 2            #
#############################################################

==========================================
 Description
==========================================
VidLister shows your (Youtube + Vimeo) videos on your site.
Thumbs are shown like a gallery and videos open inside a
lightbox.

==========================================
 Features
==========================================
* reads your Youtube/Vimeo feed and imports the video data
* shows all video thumbs (paginated) with link to video
* Languages (backend):
  - english

==========================================
 Requirements
==========================================
* MODX Revolution (tested with 2.1 and 2.2)
* getPage
* jQuery for the lightbox

==========================================
 Installation
==========================================
* Install through Package Management

==========================================
 Usage
==========================================

Import:
- Go to one of the 2 (or both) provided plugins (vlYouTube or vlVimeo)
- go to properies
- create a new property set
- fill in the details
- save the property set
- go to the events tab
- select the created property set for the VidListerImport event
- save
- clear cache
- go to components -> VidLister en press 'Import'
- your videos should be listed after import

Snippet:
- Add [[!getPage? &element=`VidLister`]] [[+page.nav]] to your page
- add <script type="text/javascript" src="assets/components/vidlister/js/web/prettyPhoto/js/jquery.prettyPhoto.js"></script>
  and <link rel="stylesheet" type="text/css" href="/assets/components/vidlister/js/web/prettyPhoto/css/prettyPhoto.css" />
  to your template <head>