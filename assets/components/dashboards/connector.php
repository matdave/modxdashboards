<?php

/*
 * This file is part of the Dashboards package.
 *
 * Copyright (c) MODX, LLC
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Dashboards Connector
 *
 * @package dashboards
 */

require_once dirname(__FILE__, 4) . '/config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

$corePath = $modx->getOption('dashboards.core_path', null, $modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/dashboards/');
/** @var Dashboards $dashboards */
$dashboards = $modx->getService(
    'dashboards',
    'Dashboards',
    $corePath . 'model/dashboards/',
    [
        'core_path' => $corePath
    ]
);

$action = $_REQUEST['action'] ?? null;
// replace namespace action with processor e.g. Dashboards\Processors\ElementCategories\GetList => mgr/element_categories/getlist
if ($action) {
    $action = str_replace('\\', '/', strtolower(str_replace('MatDave\\Dashboards\\Processors\\', '', $action)));
    $action = preg_replace('/([a-z])([A-Z])/', '$1_$2', $action);
    $action = preg_replace('/([A-Z])([A-Z])([a-z])/', '$1_$2$3', $action);
    $actionArray = explode('/', $action);
    $last = array_pop($actionArray);
    $actionArray[] = str_replace('_', '', $last);
    $action = implode('/', $actionArray);
}

$modx->request->handleRequest(
    [
        'processors_path' => $dashboards->getOption('processorsPath', [], $corePath . 'processors/'),
        'location' => '',
        'action' => $action
    ]
);
