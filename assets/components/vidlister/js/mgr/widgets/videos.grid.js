VidLister.grid.Videos = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'vidlister-grid-videos'
        ,url: VidLister.config.connectorUrl
        ,baseParams: {
            action: 'mgr/video/getlist'
        }
        ,fields: ['id', 'active', 'name']
        ,paging: true
        ,border: false
        ,frame: false
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'name'
        ,columns: [{
            header: _('id')
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 1
        },{
            header: _('vidlister.video.active')
            ,dataIndex: 'active'
            ,width: 1
            ,renderer: function(value) {
                return "<input disabled='disabled' type='checkbox'" + (value ? "checked='checked'" : "") + " />";
            }
        },{
            header: _('vidlister.video.name')
            ,dataIndex: 'name'
            ,sortable: true
            ,width: 10
        }]
        /*
        ,tbar: [{
            text: _('vidlister.import')
            ,handler: this.doImport
        }]
        */
    });
    VidLister.grid.Videos.superclass.constructor.call(this,config)
};
Ext.extend(VidLister.grid.Videos,MODx.grid.Grid,{
    getMenu: function() {
        var m = [{
                text: _('vidlister.video.update')
                ,handler: this.updateVideo
            },{
                text: _('vidlister.video.remove')
                ,handler: this.removeVideo
            }
        ];
        this.addContextMenuItem(m);
        return true;
    }
    ,doImport: function(btn,e) {

    }
    ,updateVideo: function(btn,e) {
        this.VideoWindow = MODx.load({
            xtype: 'vidlister-window-video'
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
        this.VideoWindow.show(e.target);
        this.VideoWindow.setTitle(_('vidlister.video.update'));
        this.VideoWindow.setValues(this.menu.record);
    }
    ,removeVideo: function() {
        MODx.msg.confirm({
            title: _('vidlister.video.remove')
            ,text: _('vidlister.video.remove.confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/video/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
});
Ext.reg('vidlister-grid-videos',VidLister.grid.Videos);

VidLister.window.Video = function(config) {
    config = config || {};
    this.ident = config.ident || Ext.id();
    Ext.applyIf(config,{
        title: _('vidlister.video.update')
        ,url: VidLister.config.connectorUrl
        ,autoHeight: true
        ,baseParams: {
            action: 'mgr/video/update'
        }
        ,width: 750
        ,closeAction: 'close'
        ,fields: [{
            xtype: 'modx-tabs'
            ,listeners: {
                'tabchange': function() {
                    this.syncSize();
                },
                scope: this
            }
            ,autoHeight: true
            ,deferredRender: false
            ,forceLayout: true
            ,width: '98%'
            ,borderStyle: 'padding: 10px 10px 10px 10px;'
            ,border: true
            ,defaults: {
                border: false
                ,labelWidth: 100
                ,autoHeight: true
                ,bodyStyle: 'padding: 5px 8px 5px 5px;'
                ,layout: 'form'
                ,deferredRender: false
                ,forceLayout: true
            }
            ,items: [{
                title: _('vidlister.video')
                ,items: [{
                        xtype: 'hidden'
                        ,name: 'id'
                    },{
                        xtype: 'xcheckbox'
                        ,fieldLabel: _('vidlister.video.active')
                        ,name: 'active'
                        ,inputValue: 1
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('vidlister.video.name')
                        ,name: 'name'
                        ,width: 300
                        ,allowBlank: false
                    }
                ]
            }]
        }]
    });
    VidLister.window.Video.superclass.constructor.call(this,config);
};
Ext.extend(VidLister.window.Video,MODx.Window);
Ext.reg('vidlister-window-video',VidLister.window.Video);