<?php

namespace Graze\Gigya\Test\Unit\Model;

use DateTimeImmutable;
use Graze\Gigya\Model\ModelCollectionInterface;
use Graze\Gigya\Model\ModelFactory;
use Graze\Gigya\Test\TestCase;
use Graze\Gigya\Test\TestFixtures;
use Mockery as m;

class ModelFactoryTest extends TestCase
{
    /**
     * @var ModelFactory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new ModelFactory();
    }

    public function testAccountModel()
    {
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->andReturn(TestFixtures::getFixture('accounts.getAccountInfo'));

        $model = $this->factory->getModel($response);

        static::assertInstanceOf('Graze\Gigya\Model\Model', $model);
        static::assertEquals(200, $model->getStatusCode());
        static::assertEquals(0, $model->getErrorCode());
        static::assertEquals("OK", $model->getStatusReason());
        static::assertEquals("e6f891ac17f24810bee6eb533524a152", $model->getCallId());
        static::assertEquals(new DateTimeImmutable("2015-03-22T11:42:25.943Z"), $model->getTime());
        $data = $model->getData();
        static::assertEquals("_gid_30A3XVJciH95WEEnoRmfZS7ee3MY+lUAtpVxvUWNseU=", $data->get('UID'));
    }

    public function testCollectionModel()
    {
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->andReturn(TestFixtures::getFixture('accounts.search_simple'));

        /** @var ModelCollectionInterface $model */
        $model = $this->factory->getModel($response);

        static::assertInstanceOf('Graze\Gigya\Model\ModelCollection', $model);
        static::assertEquals(200, $model->getStatusCode());
        static::assertEquals(1840, $model->getTotal());
        static::assertEquals(5, $model->getCount());
        static::assertNull($model->getNextCursor());

        $results = $model->getData();

        static::assertEquals(5, $results->count());
        static::assertEquals('g1@gmail.com', $results[0]->profile->email);
    }

    public function testError403()
    {
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->andReturn(TestFixtures::getFixture('failure_403'));

        $model = $this->factory->getModel($response);

        static::assertInstanceOf('Graze\Gigya\Model\Model', $model);
        static::assertEquals(403, $model->getStatusCode());
        static::assertEquals(403005, $model->getErrorCode());
        static::assertEquals("Forbidden", $model->getStatusReason());
        static::assertEquals("Unauthorized user", $model->getErrorMessage());
    }

    public function testNoBody()
    {
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->andReturn('');

        static::setExpectedException(
            'Graze\Gigya\Exceptions\UnknownResponseException',
            'The contents of the response could not be determined'
        );

        $this->factory->getModel($response);
    }

    public function testInvalidBody()
    {
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->andReturn(TestFixtures::getFixture('invalid_json'));

        static::setExpectedException(
            'Graze\Gigya\Exceptions\UnknownResponseException',
            'The contents of the response could not be determined'
        );

        $this->factory->getModel($response);
    }
}
