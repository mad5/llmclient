<?php

$config = include_once 'config.php';
include_once 'ai/AiHelper.php';
include_once 'ai/AiClient.php';

$client = initAiAgent($config);

var_dump($client->generate("Hello?")["response"]);
