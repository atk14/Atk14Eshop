{**
	* 'delivery_service_widget' je zamerne mimo form.
	* Obsahuje naseptavac a nechceme odeslat ihned pri stisknuti 'Enter'.
	* Ani ho nechceme videt v php kodu a zpracovavat ho pri validaci.
	* Stisk enter je obslouzen js, ktery prenese id pobocky do formulare nize.
	*}

{render partial="shared/form_field" field=$branch_selector_form->get_field("delivery_service_widget")}

{render partial="shared/form"}

