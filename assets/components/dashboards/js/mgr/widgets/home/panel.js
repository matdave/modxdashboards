dashboards.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        id: 'modx-panel-welcome',
        cls: 'container',
        layout: 'auto',
        defaults: {
            collapsible: false,
            autoHeight: true,
        },
        items: [{
                xtype: 'modx-actionbuttons',
                items: [
                    {
                        xtype: 'dashboards-combo',
                        value: config.dashboard.id,
                        listeners: {
                            select:  function (combo, record) {
                                window.location.href = MODx.config.manager_url + '?a=home&namespace=dashboards&dashboard=' + record.id
                            }
                        }
                    }
                ]
            },
            {
                id: 'modx-dashboard-header'
                ,xtype: 'modx-header'
                ,html: config.dashboard.name
            },
            {
                id: 'modx-dashboard',
                applyTo: 'modx-dashboard',
                sizes: ['quarter', 'one-third', 'half', 'two-thirds', 'three-quarters', 'full', 'double'],
                border: false,
            }
        ],
        listeners: {
            afterrender: function() {
                var obj = this;
                var newsContainer = document.getElementById('modx-news-feed-container');
                if (newsContainer) {
                    obj.loadFeed(newsContainer, 'news');
                }

                var securityContainer = document.getElementById('modx-security-feed-container');
                if (securityContainer) {
                    obj.loadFeed(securityContainer, 'security');
                }
            }
        }
    });
    dashboards.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(dashboards.panel.Home, MODx.Panel, {

    setup: function () {
        if (this.config.dashboard && this.config.dashboard.hide_trees) {
            Ext.getCmp('modx-layout').hideLeftbar(false);
        }

        MODx.fireEvent('ready');
    },

    loadFeed: function (container, feed) {
        MODx.Ajax.request({
                url: MODx.config.connector_url,
                params: {
                    action: 'System/Dashboard/Widget/Feed',
                    feed: feed
                },
                listeners: {
                    success: {
                        fn: function (response) {
                            if (response.success) {
                                container.innerHTML = MODx.util.safeHtml(response.object.html, '<h1><h2><h3><h4><span><div><ul><li><p><ol><dl><dd><dt><img><a><br><i><em><b><strong>');
                            }
                            else if (response.message.length > 0) {
                                container.innerHTML = '<p class="error">' + MODx.util.safeHtml(response.message) + '</p>';
                            }
                        }, scope: this
                    }
                    ,failure: {
                        fn: function(response) {
                            var message = response.message.length > 0 ? response.message : _('error_loading_feed');
                            container.innerHTML = '<p class="error">' + MODx.util.safeHtml(message) + '</p>';
                        }, scope: this
                    }
                }
            }
        );
    },
});
Ext.reg('dashboards-panel-home', dashboards.panel.Home);