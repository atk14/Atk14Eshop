<h1>{$page_title}</h1>

<p>Po načtení této stránky by se měl automaticky zobrazit modální dialog.</p>

<button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#opened_on_load_modal">
	Otevřít modal automaticky otevřený po načtení stránky
</button>

<hr>

<button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#open_by_click_modal">
	Otevřít modal
</button>

<button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#open_by_click_modal_no_close_button">
	Otevřít modal bez zavíracího tlačítka
</button>

<button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#open_by_click_modal_no_title_no_close_button">
	Otevřít modal bez titulku i zavíracího tlačítka
</button>

<button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#modal_vertically_centered">
	Otevřít modal verikálně centrovaný
</button>

<hr>

{a_remote action="remote_modal" _class="btn btn-default"}Remote modal{/a_remote}

{a_remote action="remote_modal_vertically_centered" _class="btn btn-default"}Remote modal verikálně centrovaný{/a_remote}

{a_remote action="remote_bootbox_modal" _class="btn btn-default"}Remote bootbox modal{/a_remote}

{modal id="open_by_click_modal" title="Modal otevřený na klik!"}
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vestibulum cursus suscipit. Donec in est urna. Aliquam erat volutpat. Quisque semper feugiat leo, sit amet laoreet risus dictum quis. Ut vel erat et urna venenatis scelerisque vitae eget risus. Vestibulum rhoncus pretium ligula. Etiam dictum venenatis nisl eget placerat. Curabitur suscipit aliquet lorem, vel fermentum nulla facilisis eget. Nulla mauris eros, pulvinar ut euismod at, tincidunt sit amet nulla. Sed quis mauris luctus nulla gravida molestie eget luctus nisl.</p>
	<p>Nullam nec est tincidunt, rhoncus quam non, dignissim nisl. Integer pulvinar pulvinar facilisis. Curabitur aliquam blandit justo, et laoreet erat aliquam ac. Sed vulputate convallis felis et convallis. Donec velit arcu, condimentum et fermentum nec, blandit sit amet enim. Etiam eu odio commodo nulla vulputate hendrerit. Suspendisse potenti. Fusce in iaculis eros. Fusce sed consectetur quam. Maecenas dui sapien, sollicitudin ac facilisis sit amet, posuere in est. Donec sit amet tellus in nulla bibendum ornare. Etiam sit amet ipsum ac orci placerat maximus non vel risus. Praesent a mi eget nisi consectetur tristique id in ligula. Curabitur vitae tellus ac nibh vestibulum cursus.</p>
	<p>Fusce sed tempor mauris. Vivamus scelerisque arcu id nibh feugiat tempor. In aliquet, sem at dictum elementum, nisl nunc vulputate ligula, id ullamcorper nisl turpis ac enim. Quisque imperdiet mauris at lacus egestas, eu porta leo luctus. Donec interdum mi sit amet est molestie, ut euismod odio dapibus. Nullam vel ligula augue. Nam a libero eu urna varius iaculis et id est.</p>
	<footer>
		Patička nemůže chybět...
	</footer>
{/modal}

{modal id="open_by_click_modal_no_close_button" title="Modal bez zavíracího tlačítka!" close_button=false}
	<p>Hit Esc to close the modal.</p>
{/modal}

{modal id="open_by_click_modal_no_title_no_close_button" title="" close_button=false}
	<p>Hit Esc to close the modal.</p>
{/modal}

{modal id="modal_vertically_centered" title="Modal #2!" vertically_centered=1}
	<p>Toto je modal bez patičky.</p>
{/modal}

{modal id="opened_on_load_modal" open_on_load=1 title="Modal otevřený po načtení stránky"}
	<p>Toto je modal otevřený po načtení stránky.</p>
	<p>Stačí nastavit parametr open_on_load=1.</p>
	<footer>
		Patička nemůže chybět...
	</footer>
{/modal}
