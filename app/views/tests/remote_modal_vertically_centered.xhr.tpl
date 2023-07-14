$("#remote_modal_id").remove();
$(".modal-backdrop").remove();

var $modal = $({jstring}{modal id=remote_modal_id vertically_centered=1 title="Remote modal"}
	<p>Toto je remote modal vertikálně centrovaný.</p>
	<p>Datum a čas na serveru: {"Y-m-d H:i:s"|date}.</p>
{/modal}{/jstring});

$modal.appendTo("body");

$("#remote_modal_id").modal("show");
