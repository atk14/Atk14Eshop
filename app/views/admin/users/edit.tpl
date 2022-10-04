{render partial="dropdown_menu" clearfix=false}

<h1>{$page_title}</h1>

{if $user->isAnonymous()}
<p>
	{t}Editujete zástupného uživatele pro nepřihlášeného zákazníka. Nastavení ceníků u tohoto uživatele bude použito při registraci nových zákazníků.{/t}
</p>
{/if}

{render partial="shared/form"}
