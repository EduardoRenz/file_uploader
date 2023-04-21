<?php

require __DIR__ . '/../vendor/autoload.php';


try {

	$appKey = "VYHjjoAHDh0";
	$appSecret = "0XqGYnHCA4RkBrCJC2SxFHrlRbe7";
	$redirect_uri = "REDIRECT_URI";

	$app = new pCloud\Sdk\App();
	$app->setAppKey($appKey);
	$app->setAppSecret($appSecret);

	$app->

	$codeUrl = $app->getAuthorizeCodeUrl();

	echo 'Visit <a target="_blank" href="' . $codeUrl . '">' . $codeUrl . '</a>';

} catch (Exception $e) {
	echo $e->getMessage();
}