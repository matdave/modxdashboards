dashboards.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [
            {
                xtype: 'dashboards-panel-home',
                dashboard: config.dashboard || {},
                renderTo: 'custom-ext-panel-div'
            }
        ]
    });
    dashboards.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(dashboards.page.Home, MODx.Component, {
});
Ext.reg('dashboards-page-home', dashboards.page.Home);
