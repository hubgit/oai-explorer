<?php

$params = array('verb' => 'ListMetadataFormats');

if ($_GET['resumptionToken']) {
	$params =  array(
		'verb' => $params['verb'],
		'resumptionToken' => $_GET['resumptionToken'],
	);
}

$dom = new DOMDocument;
$dom->load($config['oai_server'] . '?' . http_build_query($params));

$xpath = new DOMXPath($dom);
$xpath->registerNamespace('oai', 'http://www.openarchives.org/OAI/2.0/');
$xpath->registerNamespace('oai_dc', 'http://www.openarchives.org/OAI/2.0/oai_dc/');
$xpath->registerNamespace('dc', 'http://purl.org/dc/elements/1.1/');

$root = $xpath->query('oai:' . $params['verb'])->item(0);

$items = array();
foreach ($xpath->query('oai:metadataFormat', $root) as $set) {
	$items[] = array(
	  'id' => $xpath->query('oai:metadataPrefix', $set)->item(0)->textContent,
	  'name' => $xpath->query('oai:schema', $set)->item(0)->textContent,
	  );
}

$links = array();

$token = $xpath->query('oai:resumptionToken', $root);
if ($token->length) {
	$links['next'] = './?' . http_build_query(array('resumptionToken' => $token->item(0)->textContent));
}

foreach ($links as $relation => $url) {
	header(sprintf('Link: <%s>; rel="%s"', $url, $relation));
}

if (strpos($_SERVER['HTTP_ACCEPT'], 'json')) {
	header('Content-Type: application/json; charset=UTF-8');
	print json_encode($items);
	exit();
}

?>

<dl>
<?foreach ($items as $item): ?>
	<dt><? h($item['id']); ?></dt><dd><? h($item['name']); ?></dd>
<? endforeach; ?>
</dl>
