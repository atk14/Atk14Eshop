<li class="list-group-item">
	{dropdown_menu clearfix=0}
		{a action="edit" id=$system_parameter}{t}Upravit{/t}{/a}
	{/dropdown_menu}

	#{$system_parameter->getId()} {$system_parameter->getCode()}<br>
	{$system_parameter->getDescription()}<br>
	{dump var=$system_parameter->getContent()}
</li>
