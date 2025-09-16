<?php

if (!$modx->version) {
    $modx->getVersionData();
}
$version = (int) $modx->version['version'];

// fix bug if MODX version can't be detected
if (!$version) return;

if ($version > 2) {
    $dashboards = $modx->services->get('dashboards');
} else {
    $corePath = $modx->getOption('dashboards.core_path', null, $modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/dashboards/');
    $dashboards = $modx->getService(
        'dashboards',
        'Dashboards',
        $corePath . 'model/dashboards/',
        [
            'core_path' => $corePath
        ]
    );
}

$controller = $controller ?? $scriptProperties['controller'];

if (empty($controller)) {
    return;
}

if ($controller->config['controller'] == 'home' && $controller->config['namespace'] == 'dashboards') {
    return;
}

$defaultDashboard = ['id' => 0];

if ($controller->config['controller'] == 'welcome') {
    $defaultDashboard = $modx->user->getDashboard();
}

$lit = $dashboards->getOption('lit', 0);

$controller->addJavascript($dashboards->getOption('jsUrl') . 'mgr/dashboards.js?lit=' . $lit);
$controller->addJavascript($dashboards->getOption('jsUrl') . 'mgr/utils/combos.js?lit=' . $lit);
$controller->addLastJavascript($dashboards->getOption('jsUrl') . 'mgr/utils/override.js?lit=' . $lit);
$controller->addHtml('
    <script type="text/javascript">
        Ext.onReady(function() {
            dashboards.config = '.$modx->toJSON($dashboards->config).';
            dashboards.config.defaultDashboard = '. json_encode($defaultDashboard) .';
        });
    </script>
');