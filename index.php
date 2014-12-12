<?php

require_once __DIR__ . '/vendor/autoload.php';

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Guzzle\Http\Client;

$app = new Application();
$app['debug'] = true;

$app->get('/load', function (Request $request) use ($app) {

	$data = verifySignedRequest($request->get('signed_payload'));
	if (empty($data)) {
		return 'Invalid signed_payload.';
	}
	$redis = new Credis_Client('localhost');
	$key = getUserKey($data['store_hash'], $data['user']['email']);
	$user = json_decode($redis->get($key), true);
	if (empty($user)) {
		return 'Invalid user.';
	}
	return 'Welcome ' . json_encode($user);
});

$app->get('/auth/callback', function (Request $request) use ($app) {

	$payload = array(
		'client_id' => clientId(),
		'client_secret' => clientSecret(),
		'redirect_uri' => callbackUrl(),
		'grant_type' => 'authorization_code',
		'code' => $request->get('code'),
		'scope' => $request->get('scope'),
		'context' => $request->get('context'),
	);

	$client = new Client(bcAuthService());
	$req = $client->post('/oauth2/token', array(), $payload, array(
		'exceptions' => false,
	));
	$resp = $req->send();

	if ($resp->getStatusCode() == 200) {
		$data = $resp->json();
		list($context, $storeHash) = explode('/', $data['context'], 2);
		$key = getUserKey($storeHash, $data['user']['email']);

		$redis = new Credis_Client('localhost');
		$redis->set($key, json_encode($data['user'], true));

		return 'Hello ' . json_encode($data);
	} else {
		return 'Something went wrong... [' . $resp->getStatusCode() . '] ' . $resp->getBody();
	}

});

function verifySignedRequest($signedRequest)
{
	list($encodedData, $encodedSignature) = explode('.', $signedRequest, 2);

	// decode the data
	$signature = base64_decode($encodedSignature);
	$jsonStr = base64_decode($encodedData);
	$data = json_decode($jsonStr, true);

	// confirm the signature
	$expectedSignature = hash_hmac('sha256', $jsonStr, clientSecret(), $raw = false);
	if (!hash_equals($expectedSignature, $signature)) {
		error_log('Bad signed request from BigCommerce!');
		return null;
	}
	return $data;
}

function clientId()
{
	$clientId = getenv('BC_CLIENT_ID');
	return $clientId ?: '';
}

function clientSecret()
{
	$clientSecret = getenv('BC_CLIENT_SECRET');
	return $clientSecret ?: '';
}

function callbackUrl()
{
	$callbackUrl = getenv('BC_CALLBACK_URL');
	return $callbackUrl ?: '';
}

function bcAuthService()
{
	$bcAuthService = getenv('BC_AUTH_SERVICE');
	return $bcAuthService ?: '';
}

function getUserKey($storeHash, $email)
{
	return "kitty.php:$storeHash:$email";
}

$app->run();
