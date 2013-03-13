<?php
/**
 * Created by RubikIntegration Team.
 * Date: 12/26/12
 * Time: 1:59 PM
 * Question? Come to our website at http://rubikintegration.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Logger\Handler;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

class ZencartHandler extends AbstractProcessingHandler
{
    protected $environment;

    /**
     * @param int $environment
     * @param bool|int $level
     * @param bool $bubble
     */
    public function __construct($environment, $level = Logger::DEBUG, $bubble = true)
    {
        $this->environment = $environment;
        parent::__construct($level, $bubble);
    }

    /**
     * @param array $record
     */
    protected function write(array $record)
    {
        if (isset($record["context"]["zencart"]) && $record["context"]["zencart"]) {
            switch ($record["level"]) {
                case Logger::INFO:
                    $this->add($record, "success");
                    break;
                case Logger::NOTICE:
                    $this->add($record, "notice");
                    break;
                case Logger::WARNING:
                    $this->add($record, "warning");
                    break;
                case Logger::ERROR:
                    $this->add($record, "error");
                    break;
            }
        }
    }

    /**
     * @param $record
     * @param $type
     */
//    protected function add($record, $type)
    protected function add($record, $type)
    {
        global $messageStack;
        if(is_object($messageStack)) {
            if ($this->environment->getSubEnvironment() == "backend") {
                if (isset($record["context"]["session"]) && $record["context"]["session"]) {
                    $messageStack->add_session($record["message"], $type);
                } else {
                    $messageStack->add($record["message"], $type);
                }
            } else {
                if (isset($record["context"]["session"]) && $record["context"]["session"]) {
                    $messageStack->add_session($record["context"]["class"], $record["message"], $type);
                } else {
                    $messageStack->add(isset($record["context"]["class"]) ? $record["context"]["class"] : "header", $record["message"], $type);
                }
            }
        }
    }
}