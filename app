#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;

$application = new Application();

# add our commands
$application->add(new App\Command\FakerGenerateCommand());
$application->add(new App\Command\FakerCleanCommand());

$application->run();
