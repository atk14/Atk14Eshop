{foreach $items as $item}

	<h3>{$item.creator_role}</h3>

	{render partial="shared/card_list" cards=$item.cards title=""}

{/foreach}
