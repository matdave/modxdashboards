<?php

require_once dirname(__FILE__, 3) . '/vendor/autoload.php';

use MatDave\Dashboards\Service;

class Dashboards extends Service
{
    public function __construct(&$modx, array $options = []) {
        $assetsUrl = $modx->getOption('dashboards.assets_url', $options, $modx->getOption('assets_url', null, MODX_ASSETS_URL) . 'components/dashboards/');
        $options = array_merge([
            'connectorUrl' => $assetsUrl . 'connector.php',
        ], $options);
        parent::__construct($modx, $options);
    }
    public function addPackage()
    {
        $this->modx->addPackage('dashboards', $this->config['modelPath']);
    }

    public function getAvailableDashboards(): array
    {
        $dashboards = [];
        if ($this->modx->user->sudo) {
            $c = $this->modx->newQuery('modDashboard');
            $collection = $this->modx->getCollection('modDashboard', $c);
            foreach ($collection as $dashboard) {
                $dashboards[$dashboard->get('id')] = $dashboard;
            }
        } else {
            $userGroups = $this->modx->user->getUserGroups();
            foreach ($userGroups as $group) {
                $group = $this->modx->getObject('modUserGroup', ['name' => $group]);
                if ($group) {
                    $groupDashboard = $group->getOne('Dashboard');
                    if ($groupDashboard) {
                        $dashboards[$groupDashboard->get('id')] = $groupDashboard;
                    }
                }
            }
        }
        return $dashboards;
    }
}