var Dashboards = function (config) {
    config = config || {};
    Dashboards.superclass.constructor.call(this, config);
}
Ext.extend(Dashboards, Ext.Component, {
    page: {},
    window: {},
    grid: {},
    tree: {},
    panel: {},
    combo: {},
    field: {},
    config: {},
    button: {},
});
Ext.reg('dashboards', Dashboards);
dashboards = new Dashboards();

Ext.onReady(function() {
    const homelink = document.getElementById('modx-home-dashboard');
    if (homelink) {
        homelink.getElementsByTagName('a')[0].href = MODx.config.manager_url + '?a=home&namespace=dashboards';
    }
})