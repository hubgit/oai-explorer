<link rel="stylesheet" href="./static/style.css">

<a href="./formats/" rel="formats">Formats</a>

<a href="./sets/" rel="sets">Sets</a>

<h2>Identify</h2>

<form action="<? h($config['oai_server']); ?>">
	<input type="hidden" name="verb" value="Identify">
	<input type="submit" value="GET">
</form>

<h2>List Metadata Formats</h2>

<form action="<? h($config['oai_server']); ?>">
	<input type="hidden" name="verb" value="ListMetadataFormats">
	<input type="submit" value="GET">
</form>

<h2>List Sets</h2>

<form action="<? h($config['oai_server']); ?>">
	<input type="hidden" name="verb" value="ListSets">
	<input type="submit" value="GET">
</form>

<h2>List Identifiers</h2>

<!--<a href="<? h($config['oai_server']); ?>?verb=ListIdentifiers&amp;metadataPrefix=oai_dc">All</a>-->

<form action="<? h($config['oai_server']); ?>">
	<input type="hidden" name="verb" value="ListIdentifiers">
	<label>Sets <select name="set" data-source="./sets/"></select></label>
	<label>Available in format <select name="metadataPrefix" data-source="./formats/"></select></label>
	<label>From (date) <input type="datetime" name="from" placeholder="YYYY-MM-DD" value="1900-01-01"></label>
	<label>To (date) <input type="datetime" name="until" placeholder="YYYY-MM-DD" value="3000-01-01"></label>
	<input type="submit" value="GET">
</form>

<h2>List Records</h2>

<!--<a href="<? h($config['oai_server']); ?>?verb=ListRecords&amp;metadataPrefix=oai_dc">All</a>-->

<form action="<? h($config['oai_server']); ?>">
	<input type="hidden" name="verb" value="ListRecords">
	<label>Sets <select name="set" data-source="./sets/"></select></label>
	<label>Available in format <select name="metadataPrefix" data-source="./formats/"></select></label>
	<label>From (date) <input type="datetime" name="from" placeholder="YYYY-MM-DD" value="1900-01-01"></label>
	<label>To (date) <input type="datetime" name="until" placeholder="YYYY-MM-DD" value="3000-01-01"></label>
	<input type="submit" value="GET">
</form>

<h2>Get a Record</h2>

<form action="<? h($config['oai_server']); ?>">
	<input type="hidden" name="verb" value="GetRecord">
	<label>Identifier <input type="text" name="identifier" size="40" value="<? h($config['oai_sample_identifier']); ?>"></label>
	<label>Format <select name="metadataPrefix" data-source="./formats/"></select></label>
	<input type="submit" value="GET">
</form>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script>
["./sets/", "./formats/"].forEach(function(item) {
	var items = [];

	$.getJSON(item, function(data) {
		$("select[data-source='" + item + "']").each(function() {
			var select = $(this);

			//if (item == "./sets/") $("<option/>", { value: "", text: "All" }).appendTo(select);

			data.forEach(function(item) {
				$("<option/>", { value: item.id, text: item.name }).appendTo(select);
			});
		});
	})
});
</script>