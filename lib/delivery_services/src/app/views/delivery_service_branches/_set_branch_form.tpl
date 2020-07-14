{**
	* 'delivery_service_widget' je zamerne mimo form.
	* Obsahuje naseptavac a nechceme odeslat ihned pri stisknuti 'Enter'.
	* Ani ho nechceme videt v php kodu a zpracovavat ho pri validaci.
	* Stisk enter je obslouzen js, ktery prenese id pobocky do formulare nize.
	*}
{!$branch_selector_form|label:"delivery_service_widget"}
{!$branch_selector_form|form_field:"delivery_service_widget"}

{render partial="shared/form"}

