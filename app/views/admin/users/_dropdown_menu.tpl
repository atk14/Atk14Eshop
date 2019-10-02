{dropdown_menu}
			{if $action!="detail"}
			{a action=detail id=$user _class="btn btn-default"}<i class="glyphicon glyphicon-user"></i> {t}Detail{/t}{/a}
			{/if}
			{if $action!="edit"}
			{a action=edit id=$user}<i class="glyphicon glyphicon-edit"></i> {t}Edit{/t}{/a}
			{/if}
			{a action=edit_password id=$user}<i class="glyphicon glyphicon-exclamation-sign"></i> {t}Set new password{/t}{/a}
			{a action=login_as_user id=$user _method=post}<i class="glyphicon glyphicon-user"></i> {t}Sign in as this user{/t}{/a}
			{if $user->isActive()}
				{capture assign="confirm"}{t login=$user->getLogin()|h escape=no}Uživatel %1 se nebude moci přihlásit ke svému účtu. Přejete si zablokovat uživatele?{/t}{/capture}
				{a_remote action=disable id=$user _method=post _confirm=$confirm}<i class="glyphicon glyphicon-stop"></i> {t}Blokovat uživatele{/t}{/a_remote}
			{else}
				{capture assign="confirm"}{t login=$user->getLogin()|h escape=no}Přejete si povolit uživateli přihlášení k účtu?{/t}{/capture}
				{a_remote action=enable id=$user _method=post _confirm=$confirm}<i class="glyphicon glyphicon-play"></i> {t}Odblokovat uživatele{/t}{/a_remote}
			{/if}
			{if !$user->isAdmin()}
			{a controller=administrators action=edit id=$user}<i class="glyphicon glyphicon-star-empty"></i> {t}Přidej administrátorskou roli{/t}{/a}
			{else}
			{a controller=administrators action=edit id=$user}<i class="glyphicon glyphicon-star-empty"></i> {t}Uprav administrátorskou roli{/t}{/a}
			{/if}


			{* TODO: mazani moc nefunguje
			{if $user->isDeletable()}
				{capture assign="confirm"}{t login=$user->getLogin()|h escape=no}You are about to permanently delete user %1
Are you sure about that?{/t}{/capture}
				{a_remote action=destroy id=$user _method=post _confirm=$confirm}<i class="glyphicon glyphicon-remove"></i> {t}Smazat uživatele{/t}{/a_remote}
			{/if}
			*}
{/dropdown_menu}
