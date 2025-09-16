<?php

namespace MatDave\Dashboards\Controllers;

class Home extends Base
{
    private $dashboard = null;
    public function getPageTitle(): string
    {
        return $this->modx->lexicon('dashboards.home.page_title');
    }

    public function loadCustomCssJs(): void
    {
        $this->addJavascript($this->modx->getOption('manager_url') . 'assets/modext/widgets/system/modx.panel.dashboard.js');
        $this->addJavascript($this->modx->getOption('manager_url') . 'assets/modext/widgets/system/modx.panel.dashboard.widget.js');
        $this->addJavascript($this->dashboards->getOption('jsUrl') . 'mgr/widgets/home/panel.js');
        $this->addJavascript($this->dashboards->getOption('jsUrl') . 'mgr/sections/home.js');

        $selected = [];

        if ($this->dashboard) {
            $selected = $this->dashboard->toArray();
        }

        $this->addHtml(
            '
            <script type="text/javascript">
                Ext.onReady(function() {
                    MODx.load({ xtype: "dashboards-page-home", dashboard: ' . json_encode($selected) . '});
                });
            </script>
        '
        );
    }

    public function getTemplateFile(): string
    {
        return $this->dashboards->getOption('templatesPath') . 'ext.tpl';
    }

    public function process(array $scriptProperties = [])
    {
        $this->checkDashboardRequest();
        if (empty($this->dashboard)) $this->dashboard = $this->modx->user->getDashboard();
        $placeholders = $this->dashboard->toArray();
        $placeholders['dashboard'] = $this->dashboard->render($this, $this->modx->user);

        return $placeholders;
    }

    private function checkDashboardRequest()
    {
        if (!empty($_GET['dashboard'])) {
            $userDashboards = $this->dashboards->getAvailableDashboards();
            if ($userDashboards[(int)$_GET['dashboard']]) {
                $this->dashboard = $userDashboards[(int)$_GET['dashboard']];
            }
        }
    }
}