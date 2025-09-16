dashboards.combo.Dashboards = function (config)
{
    config = config || {};
    Ext.applyIf(config, {
        url: dashboards.config.connectorUrl,
        baseParams: {
            action: 'MatDave\\Dashboards\\Processors\\Combos\\Dashboards',
        },
        fields: ['id', 'name'],
        pageSize: 10,
        valueField: 'id',
        displayField: 'name',
        mode: 'remote',
        triggerAction: 'all',
        editable:true,
    });

    dashboards.combo.Dashboards.superclass.constructor.call(this, config);
}

Ext.extend(dashboards.combo.Dashboards, MODx.combo.ComboBox);

Ext.reg('dashboards-combo', dashboards.combo.Dashboards);