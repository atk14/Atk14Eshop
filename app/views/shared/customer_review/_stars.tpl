{*
 * Hodnoceni produktu (prip. neceho jineho) vyjadreno pomoci hvezdicek
 *
 *	{render partial="shared/stars" rating=2.5}
 *}
{strip}


{if $rating}

{assign rating_max CustomerReview::MAX_RATING}
{assign rating_percent value=($rating / ($rating_max / 100.0))|string_format:'%.2f%%'}

<span class="starrating" title="{t}rating:{/t} {$rating}/{$rating_max}">
	<span class="starrating__rating"><span class="starrating__text sr-only">{t}rating:{/t} {$rating}/{$rating_max}</span>
		<span class="starrating__stars">
			<span>{for $i=1 to $rating_max}{!"star"|icon:"regular"}{/for}</span>
			<span style="clip-path: rect(0 {$rating_percent} 100% 0);">{for $i=1 to $rating_max}{!"star"|icon}{/for}</span>
		</span>
	</span>
</span>

{else}

<span class="starrating">
	<span class="starrating__rating">
		<span class="starrating__stars">
			<span style="opacity: 30%; color: grey;">{for $i=1 to CustomerReview::MAX_RATING}{!"star"|icon:"regular"}{/for}</span>
		</span>
	</span>
</span>

{/if}

{/strip}
