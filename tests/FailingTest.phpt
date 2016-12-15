<?php

namespace Test;

use Nette\Application\IPresenterFactory;
use Nette\Application\Request;
use Nette\DI\Container;
use Tester\Assert;
use Tester\TestCase;

$container = require __DIR__ . '/bootstrap.php';

class FailingTest extends TestCase
{

	private $container;

	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	public function testEvents()
	{
		$responseText = $this->getResponseText('Homepage', 'GET', [
			'action' => 'default',
		]);

		Assert::contains('postLoad called', $responseText);
	}

	private function getResponseText($name, $method, $params = [])
	{
		/** @var IPresenterFactory $presenterFactory */
		$presenterFactory = $this->container->getByType(IPresenterFactory::class);

		/** @var \Nette\Application\IPresenter $presenter */
		$presenter = $presenterFactory->createPresenter($name);
		$presenter->autoCanonicalize = false;

		$request = new Request($name, $method, $params);

		/** @var \Nette\Application\Responses\TextResponse $response */
		$response = $presenter->run($request);

		return (string) $response->getSource();
	}

}

$test = new FailingTest($container);
$test->run();
