<?php

$params = array(
	'verb' => 'GetRecord',
	'metadataPrefix' => 'oai_dc',
	'identifier' => $_GET['id'],
);

$url = $config['oai_server'] . '?' . http_build_query($params);

$dom = new DOMDocument;
$dom->load($url);

$xpath = new DOMXPath($dom);
$xpath->registerNamespace('oai', 'http://www.openarchives.org/OAI/2.0/');
$xpath->registerNamespace('oai_dc', 'http://www.openarchives.org/OAI/2.0/oai_dc/');
$xpath->registerNamespace('dc', 'http://purl.org/dc/elements/1.1/');

$root = $xpath->query('oai:' . $params['verb'])->item(0);

$items = array();
foreach ($xpath->query('oai:record/oai:metadata/oai_dc:dc/*', $root) as $node) {
	$items[] = array(
		'field' => $node->localName,
		'value' => $node->textContent,
	);
}

if (strpos($_SERVER['HTTP_ACCEPT'], 'json')) {
	header('Content-Type: application/json; charset=UTF-8');
	print json_encode($items);
	exit();
}

?>

<table>
<?foreach ($items as $item): ?>
	<tr>
		<th><? h($item['field']); ?></th>
		<td><? h($item['value']); ?></td>
	</tr>
<? endforeach; ?>
</table>

<ul id="formats"></ul>
<link rel="alternate" type="<? h($format['id']); ?>" href="./?<? h(http_build_query(array('id' => $_GET['id']))); ?>">
</ul>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script>
$.getJSON("../formats/", function(data) {
	data.forEach(function(item) {
		var link = $("<a/>", { href: "#" + item.id, text: item.name });
		$("<li/>").append(link).appendTo("#formats");
	});
});
</script>
