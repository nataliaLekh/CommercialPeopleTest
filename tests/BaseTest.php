<?php
namespace  App\Tests;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;
use stdClass;

/**
 * Class BaseTest
 */
abstract class BaseTest extends WebTestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $anonymousApiToken;

    /**
     * Setup client
     */
    public function setUp()
    {
        self::bootKernel();
        $this->client = self::$kernel;
    }

    /**
     * Inject service mock
     *
     * @param $serviceName
     * @param $mockData
     */
    protected function injectServiceMock($serviceName, $mockData = null)
    {
        $service = $this->getServiceMockBuilder($serviceName);
        $mock = $service
            ->disableOriginalConstructor()
            ->getMock();

        if ($mockData != null) {
            $this->matchMockData($mockData, $mock);
        }

        $this->client->getContainer()->set($serviceName, $mock);
    }

    /**
     * Match mock data with mock methods
     *
     * @param array $mockData
     * @param $mock
     */
    private function matchMockData(array $mockData, &$mock)
    {
        $closure = function ($data, $arrayToObject) {
            $data = $data ?? [];

            return $arrayToObject ? $this->arrayToObject($data) : $data;
        };
        $closure->bindTo($mock, $mock);

        foreach ($mockData as $method => $params) {
            $mock
                ->expects($this->any())
                ->method($method)
                ->will($this->returnValue($closure($params['data'], $params['arrayToObject'] ?? false)));
        }
    }

    /**
     * Convert array to object
     *
     * @param $array
     *
     * @return stdClass
     */
    public function arrayToObject($array): stdClass
    {
        $obj = new stdClass();
        foreach ($array as $key => $value) {
            if (\strlen($key)) {
                $obj->$key = \is_array($value) ? $this->arrayToObject($value) : $value;
            }
        }

        return $obj;
    }

    /**
     * Get service
     *
     * @param $serviceId
     *
     * @return mixed
     */
    public function getService($serviceId)
    {
        return $this->client->getContainer()->get($serviceId);
    }
}
