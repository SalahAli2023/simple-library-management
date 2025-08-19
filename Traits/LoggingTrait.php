<?php
trait LoggingTrait {
    protected function logAction($action, $details = '') {
        $logMessage = sprintf(
            "[%s] %s: %s\n",
            date('Y-m-d H:i:s'),
            $action,
            $details
        );
        
        file_put_contents(__DIR__ . '/../../logs/app.log', $logMessage, FILE_APPEND);
    }
}