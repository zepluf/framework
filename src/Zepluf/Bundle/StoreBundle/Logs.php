<?php

namespace Zepluf\Bundle\StoreBundle;

use Monolog\Logger;

class Logs
{

    private $logs = array();

    private $logger;

    private $environment;

    public function __construct($logger, $environment)
    {
        $this->environment = $environment;
        $this->logger = $logger;
    }

    function count()
    {
        return count($this->logs);
    }

    public function copyFromZen()
    {
        global $messageStack;
        if ($this->environment->getSubEnvironment() == "frontend") {
            foreach ($messageStack->messages as $message) {
                $this->logger->addRecord($this->getZenMessageType($message['class']), $message['text']);
                $this->addLog($this->getZenMessageType($message['class']), $message['text']);
            }
        } else {
            foreach ($messageStack->errors as $message) {
                $this->logger->addRecord($this->getZenMessageType($message['params']), $message['text']);
                $this->addLog($this->getZenMessageType($message['params']), $message['text']);
            }
        }
    }

    public function getZenMessageType($class)
    {
        $types = array(
            'messageStackError' => Logger::ERROR,
            'messageStackWarning' => Logger::WARNING,
            'messageStackSuccess' => Logger::INFO,
            'messageStackCaution' => Logger::NOTICE,
        );

        foreach ($types as $identified => $type) {
            if (strpos($class, $identified) !== false) {
                return $type;
            }
        }
        return Logger::ERROR;
    }

    public function clear()
    {
        $this->logs = array();
    }

    public function __call($name, $args)
    {
        $args[1]["zencart"] = true;
        if (method_exists($this->logger, $name)) {
            call_user_func_array(array($this->logger, $name), $args);

            $this->addLog($name, $args[0]);
        }
    }

    public function getLogs()
    {
        return $this->logs;
    }

    private function addLog($type, $message)
    {
        $this->logs[] = array("type" => $type, "message" => $message);
    }
}