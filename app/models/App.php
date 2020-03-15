<?php

use Phalcon\Config;
use Phalcon\Mvc\Application as BaseApplication;

class App extends BaseApplication
{
    protected const REDIRECT_ACTION = '/index/redirect';

    public function handle(string $uri)
    {
        /** @var Config $config */
        $config = $this->di->get('config');
        $controllerMap = $config->toArray()['controller-map'];

        if (array_key_exists($uri, $controllerMap)) {
            return parent::handle($uri);
        }

        return parent::handle(static::REDIRECT_ACTION);
    }
}