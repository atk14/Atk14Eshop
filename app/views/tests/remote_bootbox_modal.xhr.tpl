window.bootbox.dialog({
	title: {jstring}Remote bootbox modal{/jstring},
	message:{jstring}
		<p>Toto je remote modal otevřený pomocí bootbox.js</p>
		<p>Verze bootboxu: {/jstring} + window.bootbox.VERSION + {jstring}</p>
		<p>Po kliku na tlačítko by se měl objevit alert.</p>
	{/jstring},
	// className: "...",
	// size: "large",
	backdrop: true,
	onEscape: true,
	buttons: {
		cancel: {
			label: {jstring}{icon glyph=remove} Zrušit{/jstring},
			callback: function() {
				alert("Kliknuto na cancel");
			}
		},
		confirm: {
			label: {jstring}{icon glyph=check} Uložit{/jstring},
			callback: function() {
				alert("Kliknuto na confirm");
			}
		}
	}
});
