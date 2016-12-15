<?php

require __DIR__ . '/../vendor/autoload.php';

Tester\Environment::setup();

$configurator = new Nette\Configurator;

$configurator->enableDebugger(__DIR__ . '/../log');

$configurator->setTimeZone('Europe/Prague');
$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
	->addDirectory(__DIR__ . '/../app')
	->register();

$configurator->addConfig(__DIR__ . '/../app/config/config.neon');

$container = $configurator->createContainer();

return $container;
