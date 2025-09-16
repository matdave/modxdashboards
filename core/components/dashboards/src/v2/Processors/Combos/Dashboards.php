<?php

namespace MatDave\Dashboards\v2\Processors\Combos;
class Dashboards extends \modProcessor
{
    private $dashboards = null;
    public function process()
    {
        $start = $this->getProperty('start', 0);
        $limit = $this->getProperty('limit', 0);
        if (!$this->dashboards) {
            $this->dashboards = $this->modx->getService(
                'dashboards',
                'Dashboards',
                $this->modx->getOption('dashboards.core_path', null, $this->modx->getOption('core_path') . 'components/dashboards/') . 'model/dashboards/',
            );
        }
        $availableDashboards = $this->dashboards->getAvailableDashboards();
        $dashboards = [];
        foreach ($availableDashboards as $dashboard) {
            $dashboards[] = [
                'id' => $dashboard->id,
                'name' => $dashboard->name,
            ];
        }
        if (!empty($query)) {
            $dashboards = array_filter($dashboards, function ($dashboard) use ($query) {
                return stripos($dashboard['name'], $query) !== false;
            });
        }
        $total = count($dashboards);
        if ($limit > 0) {
            $dashboards = array_slice($dashboards, $start, $limit);
        }
        return $this->outputArray($dashboards, $total);
    }
}