<?php

namespace MatDave\Dashboards\Controllers;

class Base extends \modExtraManagerController
{
    public $dashboards;

    public int $lit = 0;

    public function initialize(): void
    {
        $this->modx->getVersionData();
        if ($this->modx->version['major'] < 2) {
            $this->dashboards = $this->modx->getService(
                'dashboards',
                'Dashboards',
                $this->modx->getOption('dashboards.core_path', null, $this->modx->getOption('core_path') . 'components/dashboards/') . 'model/dashboards/',
            );
        } else {
            $this->dashboards = $this->modx->services->get('dashboards');
        }

        $this->addCss($this->dashboards->getOption('cssUrl') . 'mgr.css');
        $this->addJavascript($this->dashboards->getOption('jsUrl') . 'mgr/dashboards.js');
        $this->addJavascript($this->dashboards->getOption('jsUrl') . 'mgr/utils/combos.js');

        $this->addHtml('
            <script type="text/javascript">
                Ext.onReady(function() {
                    dashboards.config = '.$this->modx->toJSON($this->dashboards->config).';
                });
            </script>
        ');

        parent::initialize();

    }

    public function getLanguageTopics(): array
    {
        return array('dashboards:default');
    }

    public function checkPermissions(): bool
    {
        return true;
    }

    /**
     * Add an external Javascript file to the head of the
     * page with cache clearing flag
     *
     * @param string $script
     *
     * @return void
     */
    public function addJavascript($script)
    {
        $this->head['js'][] = $script . "?lit=" . $this->lit;
    }

    /**
     * Add an external CSS file to the head of the
     *  page with cache clearing flag
     *
     * @param string $script
     *
     * @return void
     */
    public function addCss($script)
    {
        $this->head['css'][] = $script. "?lit=" . $this->lit;
    }

    /**
     * Add an external Javascript file to the head of the
     *  page with cache clearing flag
     *
     * @param string $script
     *
     * @return void
     */
    public function addLastJavascript($script)
    {
        $this->head['lastjs'][] = $script . "?lit=" . $this->lit;
    }
}