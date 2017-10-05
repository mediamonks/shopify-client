<?php

namespace ShopifyClient;

use ShopifyClient\Resource\Country;
use ShopifyClient\Resource\Customer;
use ShopifyClient\Resource\Order;
use ShopifyClient\Resource\Product;
use ShopifyClient\Resource\Resource;
use ShopifyClient\Resource\Shop;
use ShopifyClient\Resource\Webhook;

/**
 * @property Country $countries
 * @property Order $orders
 * @property Product $products
 * @property Customer $customer
 * @property Shop $shop
 * @property Webhook $webhooks
 */
class Client
{
    const API_URL = 'https://%s:%s@%s';

    /**
     * @var Config
     */
    private $config;

    /**
     * @var ResourceCollection
     */
    private $resources;

    /**
     * Client constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;

        $this->initializeHttpClient();
    }

    private function initializeHttpClient()
    {
        $httpClient = new \GuzzleHttp\Client([
            'base_uri' => sprintf(
                self::API_URL,
                $this->config->getKey(),
                $this->config->getSecret(),
                $this->config->getDomain()
            ),
        ]);

        $this->resources = new ResourceCollection($httpClient, $this->config->getResources());
    }

    /**
     * @param $name
     * @return Resource
     */
    public function getResource(string $name): Resource
    {
        return $this->resources->getResource($name);
    }

    /**
     * @param $name
     * @return Resource
     */
    public function __get(string $name): Resource
    {
        return $this->resources->getResource($name);
    }
}
