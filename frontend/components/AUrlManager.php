<?php

namespace frontend\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\caching\Cache;
use yii\web\UrlManager;


class AUrlManager extends UrlManager
{
    private $_baseUrl;
    private $_scriptUrl;
    private $_hostInfo;
    private $_ruleCache;

    /**
     * Creates a URL using the given route and query parameters.
     *
     * You may specify the route as a string, e.g., `site/index`. You may also use an array
     * if you want to specify additional query parameters for the URL being created. The
     * array format must be:
     *
     * ```php
     * // generates: /index.php?r=site/index&param1=value1&param2=value2
     * ['site/index', 'param1' => 'value1', 'param2' => 'value2']
     * ```
     *
     * If you want to create a URL with an anchor, you can use the array format with a `#` parameter.
     * For example,
     *
     * ```php
     * // generates: /index.php?r=site/index&param1=value1#name
     * ['site/index', 'param1' => 'value1', '#' => 'name']
     * ```
     *
     * The URL created is a relative one. Use [[createAbsoluteUrl()]] to create an absolute URL.
     *
     * Note that unlike [[\yii\helpers\Url::toRoute()]], this method always treats the given route
     * as an absolute route.
     *
     * @param string|array $params use a string to represent a route (e.g. `site/index`),
     * or an array to represent a route with query parameters (e.g. `['site/index', 'param1' => 'value1']`).
     * @return string the created URL
     */
    public function createUrl($params)
    {
        $params = (array) $params;
        $anchor = isset($params['#']) ? '#' . $params['#'] : '';
        unset($params['#'], $params[$this->routeParam]);
        $route = trim($params[0], '/');
        unset($params[0]);
        $baseUrl = $this->showScriptName || !$this->enablePrettyUrl ? $this->getScriptUrl() : $this->getBaseUrl();
		
        if ($this->enablePrettyUrl) {
            $cacheKey = $route . '?' . implode('&', array_keys($params));
            /* @var $rule UrlRule */
            $url = false;
            if (isset($this->_ruleCache[$cacheKey])) {
                foreach ($this->_ruleCache[$cacheKey] as $rule) {
                    if (($url = $rule->createUrl($this, $route, $params)) !== false) {
                        break;
                    }
                }
            } else {
                $this->_ruleCache[$cacheKey] = [];
            }
            if ($url === false) {
                foreach ($this->rules as $rule) {
                    if (($url = $rule->createUrl($this, $route, $params)) !== false) {
                        $this->_ruleCache[$cacheKey][] = $rule;
                        break;
                    }
                }
            }
            if ($url !== false) {
				$url = urldecode($url);
                if (strpos($url, '://') !== false) {
                    if ($baseUrl !== '' && ($pos = strpos($url, '/', 8)) !== false) {
                        return substr($url, 0, $pos) . $baseUrl . substr($url, $pos);
                    } else {
                        return $url . $baseUrl . $anchor;
                    }
                } else {
                    return "$baseUrl/{$url}{$anchor}";
                }
            }
            if ($this->suffix !== null) {
                $route .= $this->suffix;
            }
            if (!empty($params) && ($query = http_build_query($params)) !== '') {
                $route .= '?' . $query;
            }
            return "$baseUrl/{$route}{$anchor}";
        } else {
            $url = "$baseUrl?{$this->routeParam}=" . urlencode($route);
            if (!empty($params) && ($query = http_build_query($params)) !== '') {
                $url .= '&' . $query;
            }
            return $url . $anchor;
        }
    }	
}
?>