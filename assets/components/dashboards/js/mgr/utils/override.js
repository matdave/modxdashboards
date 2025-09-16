Ext.onReady(function() {
    const homelink = document.getElementById('modx-home-dashboard');
    if (homelink) {
        homelink.getElementsByTagName('a')[0].href = MODx.config.manager_url + '?a=home&namespace=dashboards';
    }

    const welcomepanel = Ext.getCmp('modx-panel-welcome');
    if (welcomepanel) {
        const actionbuttons = welcomepanel.items.items.find((item) => item.xtype === 'modx-actionbuttons');
        if (actionbuttons) {
            welcomepanel.remove(actionbuttons);
        }
        welcomepanel.insert(0, {
            xtype: 'modx-actionbuttons',
            items: {
                xtype: 'dashboards-combo',
                value: dashboards.config.defaultDashboard.id ?? null,
                listeners: {
                    select:  function (combo, record) {
                        window.location.href = MODx.config.manager_url + '?a=home&namespace=dashboards&dashboard=' + record.id
                    }
                }
            }
        });
    }
})