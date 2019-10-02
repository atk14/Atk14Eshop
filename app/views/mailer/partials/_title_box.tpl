{*
	Boxed title
	{render partial="partials/title_box" content="Title text"}
	{render partial="partials/title_box" content="Title text" titlecolor="#f00" titlebg="#ff0" space_before="16" space_after="16"}
*}
{render partial="partials/spacer" height=$space_before|default:40}
<table style="width:100%">
	<tbody>
		<tr>
			<td style="background-color: {$titlebg|default:$titlebox_bgcolor}; color: {$titlecolor|default:$titlebox_color}; font-size: 14px; font-weight: bold; padding: 0.5em; font-family:{$font_stack}; width:100%;" align="left">{!$content}</td>
		</tr>
	</tbody>
</table>
{render partial="partials/spacer" height=$space_after|default:16}
