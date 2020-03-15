<?php

/**
 * Сервис для взаимодействия с HTTP-транспортом.
 */
class JsonRpcTransportService
{
    /**
     * @var HttpTransport
     */
    protected $httpTransport;

    public function __construct()
    {
        $this->httpTransport = new HttpTransport();
    }

    /**
     * Передает сообщение транспорту на обработку.
     *
     * @param array $data
     *
     * @return array
     */
    public function process(array $data): array
    {
        return $this->httpTransport->send($data);
    }
}
