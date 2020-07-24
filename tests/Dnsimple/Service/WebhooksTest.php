<?php

namespace Dnsimple\Service;

use Dnsimple\Response;
use Dnsimple\Struct\Webhook;

class WebhooksTest extends ServiceTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new Webhooks($this->client);
    }

    public function testListWebhooks()
    {
        $this->mockResponseWith("listWebhooks/success");

        $response = $this->service->listWebhooks(1010);
        self::assertInstanceOf(Response::class, $response);
        self::assertEquals(200, $response->getStatusCode());

        $data = $response->getData();
        self::assertCount(2, $data);

        $webhook = $data[0];
        self::assertInstanceOf(Webhook::class, $webhook);
    }

    public function testListWebhooksSupportsSorting()
    {
        $this->mockResponseWith("listWebhooks/success");

        $this->service->listWebhooks(1010, ["sort" => "id:asc"]);

        self::assertEquals("sort=id%3Aasc", $this->queryContent());
    }

    public function testCreateWebhook()
    {
        $this->mockResponseWith("createWebhook/created");

        $response = $this->service->createWebhook(1010, ["url" => "https://webhook.test"]);
        self::assertEquals(201, $response->getStatusCode());
        self::assertInstanceOf(Webhook::class, $response->getData());
    }

    public function testGetWebhook()
    {
        $this->mockResponseWith("getWebhook/success");

        $webhook = $this->service->getWebhook(1010, 1)->getData();

        self::assertEquals(1, $webhook->id);
        self::assertEquals("https://webhook.test", $webhook->url);
    }

    public function testDeleteWebhook()
    {
        $this->mockResponseWith("deleteWebhook/success");

        $response = $this->service->deleteWebhook(1010, 1);
        self::assertEquals(204, $response->getStatusCode());
    }
}
