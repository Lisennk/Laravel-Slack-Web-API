<?php

use PHPUnit\Framework\TestCase;
use Lisennk\Laravel\SlackWebApi\SlackApi;
use Lisennk\Laravel\SlackWebApi\Exceptions\SlackApiException;

class SlackApiTest extends TestCase
{
    public function testApiIsOk()
    {
        $api = new SlackApi('');
        $this->assertTrue($api->isOk());
    }

    public function testApiError()
    {
        $this->expectException(SlackApiException::class);

        $api = new SlackApi('');
        $api->execute('groups.list', []);
    }
}
