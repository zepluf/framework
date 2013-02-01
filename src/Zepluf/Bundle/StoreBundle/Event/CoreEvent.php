<?php
/**
 * Created by RubikIntegration Team.
 *
 * Date: 9/30/12
 * Time: 4:31 PM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF
 */

namespace Zepluf\Bundle\StoreBundle\Event;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * core event class
 */
class CoreEvent extends \Symfony\Component\EventDispatcher\Event
{
    /**
     * @var
     */
    protected $request;

    /**
     * @var
     */
    protected $response;
    /**
     * @var storing the current page content
     */

    private $content;

    /**
     * sets content
     *
     * @param $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    } 

    /**
     * gets content
     *
     * @return mixed
     */
	public function getContent()
    {
        return $this->content;        
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    public function getResponse()
    {
        return $this->response;
    }
}