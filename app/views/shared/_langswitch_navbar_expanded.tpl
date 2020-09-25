{* Langswitch for use in navbars. For standalone use in navbar, see _langswitch 
	* show_language_names - if true, language names are shown
*}
{if $all_languages}

{foreach $all_languages as $l}
	<li class="nav-item langswitch">
		<a href="{$l.switch_url}" class="nav-link{if $current_language==$l} active{/if}">
		<img src="{$public}/dist/images/languages/{$l.lang}.svg" class="langswitch__flag" alt="{$l.name|capitalize}" width="24" height="15">
		<span class="langswitch__lang-name--small{if !$show_language_names} sr-only{/if}">{$l.name|capitalize}</span>
		</a>
	</li>
{/foreach}

{/if}
