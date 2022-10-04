{if !isset($clearfix)}{assign clearfix true}{/if}

{dropdown_menu clearfix=$clearfix}
			{if $action!="edit"}
				{a action=edit id=$user}{!"user-edit"|icon} {t}Edit{/t}{/a}
			{/if}
			{if $action!="detail"}
				{a action=detail id=$user _class="btn btn-default"}{!"user"|icon} {t}Detail{/t}{/a}
			{/if}
			{a action=edit_password id=$user}{!"key"|icon} {t}Set new password{/t}{/a}
			{a action=login_as_user id=$user _method=post}{!"sign-in-alt"|icon} {t}Sign in as this user{/t}{/a}

			{if $action=="index" && $user->isDeletable()}
				{capture assign="confirm"}{t login=$user->getLogin()|h escape=no}You are about to permanently delete user %1
	Are you sure about that?{/t}{/capture}
				{a_destroy id=$user _confirm=$confirm}{!"trash-alt"|icon} {t}Delete user{/t}{/a_destroy}
			{/if}
{/dropdown_menu}
