<?php

namespace Zepluf\Bundle\StoreBundle;

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

    public function copyToZen()
    {
        global $messageStack;
        foreach ($this->logs as $log) {
            if ($log->session) {
                if ($this->environment->getSubEnvironment() == "backend") {
                    $messageStack->add_session($log->message, $log->type);
                } else {
                    $messageStack->add_session($log->scope, $log->message, $log->type);
                }
            } else {
                if ($this->environment->getSubEnvironment() == "backend") {
                    $messageStack->add($log->message, $log->type);
                } else {
                    $messageStack->add($log->scope, $log->message, $log->type);
                }
            }
        }

        return $this;
    }

    public function copyFromZen()
    {
        global $messageStack;
        if ($this->environment->getSubEnvironment() == "frontend") {
            foreach ($messageStack->messages as $message) {
                $this->add(array(
                    'message' => $message['text'],
                    'scope' => $message['class'],
                    'type' => $this->getZenMessageType($message['class'])
                ));
            }
        } else {
            foreach ($messageStack->errors as $message) {
                $this->add(array(
                    'message' => $message['text'],
                    'scope' => 'global',
                    'type' => $this->getZenMessageType($message['params'])
                ));
            }
        }
    }

    private function getZenMessageType($class)
    {
        $types = array(
            'messageStackError' => 'error',
            'messageStackWarning' => 'warning',
            'messageStackSuccess' => 'success',
            'messageStackCaution' => 'caution',
        );

        foreach ($types as $identified => $type) {
            if (strpos($class, $identified) !== false) {
                return $type;
            }
        }
        return 'error';
    }

    public function getAsArray()
    {
        $logs = array();
        foreach ($this->logs as $log) {
            $logs[] = $log->getArray();
        }
        return $logs;
    }

    public function clear()
    {
        $this->logs = array();
    }

    public function __call($name, $args)
    {
        $args[1]["zencart"] = true;
        call_user_func_array(array($this->logger, $name), $args);
    }
}