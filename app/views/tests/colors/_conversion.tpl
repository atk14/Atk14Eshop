
<div class="tests-colors__conversion">
	<div class="tests-colors__patch" style="background-color: {$color}"></div>
	<div class="tests-colors__name">Original<br>{$color}</div>
	<div class="tests-colors__patch" style="background-color: {$color|color_to_rgba:0.8}"></div>
	<div class="tests-colors__name">Result<br>{$color|color_to_rgba:0.8}</div>
</div>