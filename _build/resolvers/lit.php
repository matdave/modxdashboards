<?php

if ($object->xpdo) {
    /** @var modX $modx */
    $modx =& $object->xpdo;

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $setting = $modx->getObject('modSystemSetting', ['key' => 'dashboards.lit']);
            if (!$setting) {
                $setting = $modx->newObject('modSystemSetting');
                $setting->fromArray([
                    'key' => 'dashboards.lit',
                    'namespace' => 'dashboards',
                    'xtype' => 'textfield',
                    'area' => 'dashboards',
                    'editedon' => time(),
                    'editedby' => 0,
                ]);
            }
            $setting->set('value', time());
            $setting->save();
            break;
    }
}
