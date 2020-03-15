<?php
//declare(strict_types=1);

use Datto\JsonRpc\Responses\ErrorResponse;

class IndexController extends ControllerBase
{
    public function indexAction()
    {
    }

    public function redirectAction()
    {
        $data = [
            'method' => 'getUrl',
            'params' => [
                'code' => substr($_SERVER['REQUEST_URI'], 1) ?? null,
            ],
        ];

        /** @var JsonRpcTransportService $transportService */
        $transportService = $this->di->get(JsonRpcTransportService::class);
        $responseData = $transportService->process($data);


        $this->view->error = $responseData['error'] ? 'Адрес не найден.' : null;
        $url = $responseData['result'] ?? null;
        header("Location:$url");
    }

    public function postAction()
    {
        $data['params'] = $this->request->getPost();
        $data['method'] = 'generateShortUrl';

        /** @var JsonRpcTransportService $transportService */
        $transportService = $this->di->get(JsonRpcTransportService::class);
        $responseData = $transportService->process($data);

        $this->view->error = $responseData['error'] ? 'Не корректная ссылка.' : null;
        $this->view->longUrl = $data['url'] ?? null;
        $this->view->shortUrl = 'http://localhost:8000/' . $responseData['result'];
    }
}
