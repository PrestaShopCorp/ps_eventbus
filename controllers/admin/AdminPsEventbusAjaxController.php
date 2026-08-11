<?php

use PrestaShop\Module\PsEventbus\Service\ApiHealthCheckService;
use PrestaShop\Module\PsEventbus\Service\ConnectionsService;

class AdminPsEventbusAjaxController extends ModuleAdminController
{
    /** @var Ps_eventbus */
    public $module;

    /**
     * AJAX actions allowed to be dispatched.
     *
     * @var string[]
     */
    private static $allowedActions = [
        'getHealthCheck',
        'getConnections',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->ajax = true;
    }

    /**
     * Single AJAX dispatcher.
     *
     * Expected POST body (JSON): {"action": "getHealthCheck", ...}
     * Called automatically by PrestaShop when the request has ajax=1&action=dispatch.
     *
     * @return void
     */
    public function ajaxProcessDispatch()
    {
        if (!$this->access('view')) {
            $this->jsonResponse(['error' => true, 'message' => 'Access denied'], 403);
        }

        $input = file_get_contents('php://input');
        $data = $input ? json_decode($input, true) : [];
        $action = isset($data['action']) ? $data['action'] : null;

        if (!$action) {
            $this->jsonResponse(['error' => true, 'message' => 'Missing action parameter'], 400);
        }

        if (!in_array($action, self::$allowedActions, true)) {
            $this->jsonResponse(['error' => true, 'message' => 'Unknown action: ' . $action], 400);
        }

        try {
            $reflection = new ReflectionMethod($this, $action);
            $parameters = $reflection->getParameters();

            if (!empty($parameters)) {
                $response = $this->$action($data);
            } else {
                $response = $this->$action();
            }

            $this->jsonResponse($response);
        } catch (Exception $e) {
            $this->jsonResponse([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function getHealthCheck()
    {
        /** @var ApiHealthCheckService $healthCheckService */
        $healthCheckService = $this->module->getService(ApiHealthCheckService::class);

        return $healthCheckService->getDashboardHealthCheck();
    }

    /**
     * @return array<string, mixed>
     */
    private function getConnections()
    {
        /** @var ConnectionsService $connectionsService */
        $connectionsService = $this->module->getService(ConnectionsService::class);

        return ['services' => $connectionsService->getConnections()];
    }

    /**
     * Send a JSON response and terminate.
     *
     * @param array<string, mixed> $data
     * @param int $statusCode
     *
     * @return void
     */
    private function jsonResponse(array $data, $statusCode = 200)
    {
        if (!headers_sent()) {
            if ($statusCode !== 200) {
                http_response_code($statusCode);
            }
            header('Content-Type: application/json');
            header('Cache-Control: no-store, no-cache, must-revalidate');
        }

        echo json_encode($data);

        exit;
    }
}
