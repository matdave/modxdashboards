<?php

namespace MatDave\Dashboards;

use MODX\Revolution\modDashboard;
use MODX\Revolution\modUserGroup;

class Service extends \MatDave\MODXPackage\Service
{
    public const VERSION = '0.0.1';
    public $namespace = 'dashboards';

    public function getAvailableDashboards(): array
    {
        $dashboards = [];
        if ($this->modx->user->sudo) {
            $c = $this->modx->newQuery(modDashboard::class);
            $collection = $this->modx->getCollection(modDashboard::class, $c);
            foreach ($collection as $dashboard) {
                $dashboards[$dashboard->get('id')] = $dashboard;
            }
        } else {
            $userGroups = $this->modx->user->getUserGroups();
            foreach ($userGroups as $group) {
                $group = $this->modx->getObject(modUserGroup::class, ['name' => $group]);
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