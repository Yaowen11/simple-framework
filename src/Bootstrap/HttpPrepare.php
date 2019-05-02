<?php

namespace Simple\Bootstrap;

use Simpale\Tool\Config;

class HttpPrepare implements Prepare
{
    private $callQueue;

    private $requestMethod;

    private $url;

    private $urlCallObjects;

    const HTTP_ROUTE_KEY = 'httpRoute';

    public function __construct($requestMethod, $url)
    {
        $this->requestMethod = $requestMethod;
        $this->url = strpos($url, '?') === false ? $url : substr($url, 0, strpos($url, '?'));
        $this->callQueue = new \SplQueue();
    }

    public function verifyRoute(): bool
    {
        $httpRouteFile = Config::
        HttpRouteFactory::load($httpRouteFile);
        return true;
    }

    /**
     * 验证当前请求url是否定义
     * @return bool
     * @throws HttpRequestException
     */
    public function verifyRequest(): bool
    {
        $routes = HttpRouteFactory::getRoutes();
        if (isset($routes[$this->requestMethod][$this->url])) {
            $this->urlCallObjects = $routes[$this->requestMethod][$this->url];
            return true;
        }
        throw new HttpRequestException('指定url不存在');
    }


    public function prepare(): \SplQueue
    {
        if ($this->verifyRoute() && $this->verifyRequest()) {
            // 生成运行容器
            if (!empty($this->urlCallObjects[HttpRoute::ROUTES_URL_BEFORE_MIDDLEWARE_PREFIX])) {
                foreach ($this->urlCallObjects[HttpRoute::ROUTES_URL_BEFORE_MIDDLEWARE_PREFIX] as $beforeMiddleware) {
                    $this->callQueue->enqueue(BeforeMiddlewareFactory::createBeforeMiddleware($beforeMiddleware));
                }
            }
            $this->callQueue->enqueue(RouteContainerFactory::createHttpRouteContainer($this->urlCallObjects[HttpRoute::ROUTES_URL_ACTION_PREFIX]));
            if (!empty($this->urlCallObjects[HttpRoute::ROUTES_URL_AFTER_MIDDLEWARE_PREFIX])) {
                foreach ($this->urlCallObjects[HttpRoute::ROUTES_URL_AFTER_MIDDLEWARE_PREFIX] as $afterMiddleware) {
                    $this->callQueue->enqueue(AfterMiddlewareFactory::createAfterMiddleware($afterMiddleware));
                }
            }
            return $this->callQueue;
        }
        throw new RuntimeException();
    }

}