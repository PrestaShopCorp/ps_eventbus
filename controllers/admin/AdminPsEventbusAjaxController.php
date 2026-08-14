<?php

use PrestaShop\Module\PsEventbus\Service\ApiHealthCheckService;
use PrestaShop\Module\PsEventbus\Service\ConnectionsService;
use PrestaShop\Module\PsEventbus\Service\SystemDiagnosticService;

class AdminPsEventbusAjaxController extends ModuleAdminController
{
    /** @var Ps_eventbus */
    public $module;

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
        if (method_exists($this, 'access') && !$this->access('view')) {
            $this->jsonResponse(['error' => true, 'message' => 'Access denied'], 403);
        }

        $input = file_get_contents('php://input');
        $data = $input ? json_decode($input, true) : [];
        $action = isset($data['action']) ? $data['action'] : null;

        if (!$action) {
            $this->jsonResponse(['error' => true, 'message' => 'Missing action parameter'], 400);
        }

        try {
            switch ($action) {
                case 'getHealthCheck':
                    $response = $this->getHealthCheck();
                    break;
                case 'getConnections':
                    $response = $this->getConnections();
                    break;
                case 'getSystemDiagnostic':
                    $response = $this->getSystemDiagnostic();
                    break;
                default:
                    $this->jsonResponse(['error' => true, 'message' => 'Unknown action: ' . $action], 400);

                    return;
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
     * @return array<string, mixed>
     */
    private function getSystemDiagnostic()
    {
        /** @var SystemDiagnosticService $systemDiagnosticService */
        $systemDiagnosticService = $this->module->getService(SystemDiagnosticService::class);

        return $systemDiagnosticService->getDiagnostic();
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
