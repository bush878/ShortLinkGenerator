<?php

use Datto\JsonRpc\Client as JsonRpcClient;
use GuzzleHttp\Client as HttpClient;

/**
 * HTTP транспорт.
 */
class HttpTransport
{
    protected const GENERATOR_SERVER_URL = 'http://localhost:7000/';

    /**
     * HTTP клиент.
     *
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * Конструктор.
     */
    public function __construct()
    {
        $this->httpClient = new HttpClient();
    }

    /**
     * Отправляет запрос.
     *
     * @param array|null $data данные для тела запроса.
     *
     * @return array
     */
    public function send(?array $data): array
    {
        $params = $data['params'] ?? null;
        $method = $data['method'] ?? null;

        $jsonRpcClient = (new JsonRpcClient())->query(1, $method, $params);
        $options = ['body' => json_encode($jsonRpcClient->preEncode())];

        $response = $this->httpClient->request('POST', static::GENERATOR_SERVER_URL, $options);

        return json_decode($response->getBody());
    }
}
