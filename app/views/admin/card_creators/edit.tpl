{dropdown_menu clearfix=false}
	{a action="creators/edit" id=$card_creator->getCreator()}{icon glyph="user"} {t creator=$card_creator->getCreator()}Edit creator %1{/t}{/a}
{/dropdown_menu}

<h1>{$page_title}</h1>

{render partial="shared/form"}
