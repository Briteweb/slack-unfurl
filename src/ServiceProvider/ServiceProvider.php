<?php

namespace Eventum\SlackUnfurl\ServiceProvider;

use Eventum\SlackUnfurl\SlackClient;
use Eventum_RPC;
use Nexy\Slack\Client;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * @inheritdoc
     */
    public function register(Container $app)
    {
        $app['eventum.rpc_url'] = getenv('EVENTUM_RPC_URL');
        $app['eventum.username'] = getenv('EVENTUM_USERNAME');
        $app['eventum.access_token'] = getenv('EVENTUM_ACCESS_TOKEN');

        $app[Eventum_RPC::class] = function ($app) {
            $client = new Eventum_RPC($app['eventum.rpc_url']);
            $client->setCredentials($app['eventum.username'], $app['eventum.access_token']);

            return $client;
        };

        $app[SlackClient::class] = function ($app) {
            $apiToken = getenv('SLACK_API_TOKEN');

            return new SlackClient($apiToken);
        };
    }
}