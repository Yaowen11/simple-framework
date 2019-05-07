<?php

namespace Simple\Exception;

trait ExceptionToString
{
    public function __toString()
    {
        $this->recordException();
        return json_encode([
            'message' => $this->getMessage(),
            'file' => $this->getFile(),
            'line' => $this->getLine(),
            'trace' => $this->getTrace(),
            'date' => date('Y-m-d H:i:s'),
        ], JSON_UNESCAPED_UNICODE);
    }

    private function recordExceptionToLog()
    {
        $exceptionLogFile = FileFactory::createLogFile(App::logPath() . App::config('log')['exception']);
        Logger::recordingLog($exceptionLogFile, json_encode([
            'message' => $this->getMessage(),
            'file' => $this->getFile(),
            'line' => $this->getLine(),
            'trace' => $this->getTrace(),
            'date' => date('Y-m-d H:i:s'),
        ], JSON_UNESCAPED_UNICODE));
    }
}