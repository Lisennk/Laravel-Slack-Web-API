<?php

namespace Lisennk\Laravel\SlackWebApi;

use Frlnc\Slack\Http\SlackResponseFactory;
use Frlnc\Slack\Http\CurlInteractor;
use Frlnc\Slack\Core\Commander;
use Lisennk\Laravel\SlackWebApi\Exceptions\SlackApiException;

/**
 * Slack Web API Lightweight implementation
 *
 * @see https://api.slack.com/web
 * @package Lisennk\Laravel\SlackWebApi
 */
class SlackApi
{
    /**
     * @var int timestamp
     */
    protected $lastApiCallTime = 0;

    /**
     * Possible API calls per second
     *
     * @var int
     */
    protected $rateLimit = 1;

    /**
     * True if want to ignore slack limitations
     *
     * @var bool
     */
    protected $ignoreLimit = false;

    /**
     * @var Commander
     */
    private $commander;

    /**
     * WebApi constructor.
     * @param $token
     */
    public function __construct($token)
    {
        $interactor = new CurlInteractor;
        $interactor->setResponseFactory(new SlackResponseFactory);

        $this->commander = new Commander($token, $interactor);
    }

    /**
     * Execute query to Slack Web API
     *
     * @param $method
     * @param array $parameters
     * @return array
     * @throws SlackApiException
     */
    public function execute($method, array $parameters = [])
    {
        $this->respectRateLimit();
        $response = $this->commander->execute($method, $parameters)->getBody();

        if ($response['ok']) return (array) $response;
        throw new SlackApiException($response['error']);
    }

    /**
     * Test Slack Api. True if everything is OK and you can execute queries, false if something is wrong
     *
     * @return bool
     */
    public function isOk()
    {
        try {
            $this->execute('api.test', []);
            return true;
        } catch (SlackApiException $e) {
            return false;
        }
    }

    /**
     * Sets token
     *
     * @param $token
     */
    public function setToken($token)
    {
        $this->commander->setToken($token);
    }

    /**
     * Sets the respect mode
     *
     * @param bool $ignore
     */
    public function ignoreLimit($ignore = true)
    {
        $this->ignoreLimit = (boolean) $ignore;
    }

    /**
     * Sleep if needed, to respect Slack Api Rate Limit
     *
     * @see https://api.slack.com/docs/rate-limits
     */
    private function respectRateLimit()
    {
        if ($this->ignoreLimit) return;

        if ((time() - $this->lastApiCallTime) < 1) usleep(1000000 / $this->rateLimit);
        $this->lastApiCallTime = time();
    }
}
