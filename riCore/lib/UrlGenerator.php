<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Vu Hung
 * Date: 9/25/12
 * Time: 3:10 PM
 * To change this template use File | Settings | File Templates.
 */

namespace plugins\riCore;

class UrlGenerator extends \Symfony\Component\Routing\Generator\UrlGenerator{

    public function getBaseUrl(){
        return $this->context->getBaseUrl();
    }
    /**
     * {@inheritDoc}
     */
    public function customGenerate($name, $parameters = array(), $absolute = false)
    {
        if (null === $route = $this->routes->get($name)) {
            throw new RouteNotFoundException(sprintf('Route "%s" does not exist.', $name));
        }

        // the Route has a cache of its own and is not recompiled as long as it does not get modified
        $compiledRoute = $route->compile();

        return $this->customDoGenerate($compiledRoute->getVariables(), $route->getDefaults(), $route->getRequirements(), $compiledRoute->getTokens(), $parameters, $name, $absolute);
    }

    /**
     * @throws MissingMandatoryParametersException When route has some missing mandatory parameters
     * @throws InvalidParameterException When a parameter value is not correct
     */
    protected function customDoGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $absolute)
    {
        $variables = array_flip($variables);

        $originParameters = $parameters;
        $parameters = array_replace($this->context->getParameters(), $parameters);
        $tparams = array_replace($defaults, $parameters);

        // all params must be given
        if ($diff = array_diff_key($variables, $tparams)) {
            throw new MissingMandatoryParametersException(sprintf('The "%s" route has some missing mandatory parameters ("%s").', $name, implode('", "', array_keys($diff))));
        }

        $url = '';
        $optional = true;
        foreach ($tokens as $token) {
            if ('variable' === $token[0]) {
                if (false === $optional || !array_key_exists($token[3], $defaults) || (isset($parameters[$token[3]]) && (string) $parameters[$token[3]] != (string) $defaults[$token[3]])) {
                    if (!$isEmpty = in_array($tparams[$token[3]], array(null, '', false), true)) {
                        // check requirement
                        if ($tparams[$token[3]] && !preg_match('#^'.$token[2].'$#', $tparams[$token[3]])) {
                            $message = sprintf('Parameter "%s" for route "%s" must match "%s" ("%s" given).', $token[3], $name, $token[2], $tparams[$token[3]]);
                            if ($this->strictRequirements) {
                                throw new InvalidParameterException($message);
                            }

                            if ($this->logger) {
                                $this->logger->err($message);
                            }

                            return null;
                        }
                    }

                    if (!$isEmpty || !$optional) {
                        $url = $token[1].$tparams[$token[3]].$url;
                    }

                    $optional = false;
                }
            } elseif ('text' === $token[0]) {
                $url = $token[1].$url;
                $optional = false;
            }
        }

        if ('' === $url) {
            $url = '/';
        }

        // do not encode the contexts base url as it is already encoded (see Symfony\Component\HttpFoundation\Request)
        // $url = $this->context->getBaseUrl().strtr(rawurlencode($url), $this->decodedChars);
        // do not append baseUrl here
        $url = strtr(rawurlencode($url), $this->decodedChars);

        // the path segments "." and ".." are interpreted as relative reference when resolving a URI; see http://tools.ietf.org/html/rfc3986#section-3.3
        // so we need to encode them as they are not used for this purpose here
        // otherwise we would generate a URI that, when followed by a user agent (e.g. browser), does not match this route
//        $url = strtr($url, array('/../' => '/%2E%2E/', '/./' => '/%2E/'));
//        if ('/..' === substr($url, -3)) {
//            $url = substr($url, 0, -2) . '%2E%2E';
//        } elseif ('/.' === substr($url, -2)) {
//            $url = substr($url, 0, -1) . '%2E';
//        }

        // add a query string if needed
        $extra = array_diff_key($originParameters, $variables, $defaults);
        if ($extra && $query = http_build_query($extra, '', '&')) {
            $url .= '?'.$query;
        }

//        if ($this->context->getHost()) {
//            $scheme = $this->context->getScheme();
//            if (isset($requirements['_scheme']) && ($req = strtolower($requirements['_scheme'])) && $scheme != $req) {
//                $absolute = true;
//                $scheme = $req;
//            }
//
//            if ($absolute) {
//                $port = '';
//                if ('http' === $scheme && 80 != $this->context->getHttpPort()) {
//                    $port = ':'.$this->context->getHttpPort();
//                } elseif ('https' === $scheme && 443 != $this->context->getHttpsPort()) {
//                    $port = ':'.$this->context->getHttpsPort();
//                }
//
//                $url = $scheme.'://'.$this->context->getHost().$port.$url;
//            }
//        }

        return $url;
    }
}