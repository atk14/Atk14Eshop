Maps
====

Maps are displayed using Leaflet.js library. It supports various tile providers including Mapy.cz or OpenStreetMap.org. Note that most tile providers require map attribution with link and some have additional requirements such as displaying their logo etc.

## Simple map

Simple map with single marker. Marker position and map zoom are set by <code>data-lat</code>, <code>data-lng</code> and <code>data-zoom</code> attributes.

After loading API map is initialized with <code>UTILS.initSimpleMap</code> like this:   <code>UTILS.initSimpleMap( "store-map" );</code>

[example]
<div class="store-detail__map" id="store-map" data-lat="50.3864386" data-lng="14.2895042" data-zoom="16"></div>
[/example]

## Store Locator map

Store Locator Map displays multiple markers defined by <code>storeLocatorData</code> array. Optional clustering is enabled by <code>data-enable_clusters</code> attribute and distance between points for clustering is set by <code>data-cluster_distance</code> attribute. When marker is clicked, card with store information is displayed. Maps is automtically scaled and centered to display all markers.

[example]
<script>
//<![CDATA[
	var storeLocatorData = [
			{
		id: 1,
		image: "//i.pupiq.net/i/6f/6f/ac2/2dac2/4454x2969/E6ifOg_140x140xc_2b938a06ee365ab4.jpg",
		title: "Elegantní lékárna",
		address: "Vinohradsk%C3%A1%20222%3Cbr%3E%0D%0A120%2000%20Praha%202%3Cbr%3E%0D%0A%C4%8Cesk%C3%A1%20republika",
		detailURL: "/prodejny/elegantni-lekarna/",
		lat: 50.0770708,
		lng: 14.4862577,
		isOpen: "Otevřeno",
	},
				{
		id: 3,
		image: "//i.pupiq.net/i/6f/6f/ac3/2dac3/5472x3648/lcMqx7_140x140xc_0c529b8188c3a32a.jpg",
		title: "Showroom Praha",
		address: "Korunn%C3%AD%20970%2F72%3Cbr%3E%0D%0A101%2000%20%20Praha%2010%20%E2%80%93%20Vinohrady",
		detailURL: "/prodejny/showroom-praha/",
		lat: 50.0753692,
		lng: 14.4510819,
		isOpen: "Otevřeno",
	},
				{
		id: 4,
		image: "//i.pupiq.net/i/6f/6f/91e/2e91e/2000x2000/n6xqeH_140x140xc_31ad088525dd9323.jpg",
		title: "Říp",
		address: "Rovn%C3%A9%3Cbr%3E%0D%0AKrab%C4%8Dice",
		detailURL: "/prodejny/rip/",
		lat: 50.3864386,
		lng: 14.2895042,
		isOpen: "Otevřeno",
	},
				{
		id: 5,
		image: "//i.pupiq.net/i/6f/6f/91f/2e91f/2000x1285/apURGF_140x140xc_83e788667c8dea6c.jpg",
		title: "Ostrava!!!",
		address: "Masarykovo%20n%C3%A1m%C4%9Bst%C3%AD%2037%2F20%3Cbr%3E%0D%0AOstrava",
		detailURL: "/prodejny/ostrava/",
		lat: 49.8361483,
		lng: 18.2920475,
		isOpen: "Otevřeno",
	},
				{
		id: 6,
		image: "//i.pupiq.net/i/6f/6f/920/2e920/2000x1333/gWlhbr_140x140xc_5158317050b8a8f1.jpg",
		title: "Sněžka",
		address: "Sn%C4%9B%C5%BEka%3Cbr%3E%0D%0APec%20pod%20Sn%C4%9B%C5%BEkou",
		detailURL: "/prodejny/snezka/",
		lat: 50.7357619,
		lng: 15.7398722,
		isOpen: "Otevřeno",
	},
				{
		id: 7,
		image: "//i.pupiq.net/i/6f/6f/921/2e921/2000x1333/9U7vlt_140x140xc_77bb70fe5a19947e.jpg",
		title: "Brno",
		address: "n%C3%A1m%C4%9Bst%C3%AD%20Svobody%2074%2F10%3Cbr%3E%0D%0A602%2000%20%20Brno-m%C4%9Bsto",
		detailURL: "/prodejny/brno/",
		lat: 49.1946639,
		lng: 16.6089039,
		isOpen: "Otevřeno",
	},
	];

			
//]]>
</script>
<div class="stores-index__map" id="allstores_map" data-enable_clusters="true" data-cluster_distance="30"></div>
[/example]

### Store Card
Card displayed on map inside <code>.smap</code> container after clicking on marker
[example]
<div class="smap">
	
	<div class="card" style="width: 355px; visibility: visible; position: static">
		<div class="card-header">
			<img src="http://i.pupiq.net/i/6f/6f/ac3/2dac3/5472x3648/lcMqx7_140x140xc_0c529b8188c3a32a.jpg" alt="Showroom Praha">
			<div class="flags">
				<span class="badge badge-success">Otevřeno</span>
			</div>
		</div>
		<div class="card-body" style="height: 2px;">
			<div>
				<p class="card-title">Showroom Praha</p>
				<address>
					Korunní 970/72<br>
					101 00  Praha 10 – Vinohrady
				</address>
			</div>
			<a href="#" class="btn btn-sm btn-primary">Prodejna <span class="fas fa-arrow-right"></span></a>
		</div>
		<div class="card-footer"></div>
		<div class="close"></div>
		<div class="tail"></div>
	</div>
	
</div>
[/example]
