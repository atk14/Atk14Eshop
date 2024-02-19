<h3 id="campaigns">{button_create_new action="order_campaigns/create_new" order_id=$order return_to_anchor="campaigns"}{/button_create_new} {t}Kampaně{/t}</h3>

{assign order_campaigns $order->getCampaigns()}
{assign currency $order->getCurrency()}

{capture assign=return_uri}{$request->getUri()}#campaigns{/capture}

{if !$order_campaigns}

	<p>{t}Žádná kampaň{/t}</p>

{else}

	<table class="table">
		<thead>
			<tr>
				<th>{t}Kampaň{/t}</th>
				<th>{t}Sleva{/t}</th>
				<th>{t}Poznámka{/t}</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			{foreach $order_campaigns as $order_campaign}
				<tr>
					<td>{$order_campaign->getName()} ({render partial="shared/region_list" regions=$order_campaign->getCampaign()->getRegions()})</td>
					<td>{!$order_campaign->getDiscountAmount()|display_price:"$currency"}</td>
					<td>
						{if $order_campaign->createdAdministratively()}
							<em>{t date=$order_campaign->getCreatedAt()|format_date time=$order_campaign->getCreatedAt()|format_date:"H:i" name=$order_campaign->getCreatedByUser()}Záznam přidal dne %1 v %2 administrátor %3{/t}</em><br>
						{/if}
						{!$order_campaign->getInternalNote()|h|nl2br}
					</td>
					<td>
						{dropdown_menu}
							{a action="order_campaigns/edit" id=$order_campaign return_uri=$return_uri}{!"edit"|icon} {t}Upravit{/t}{/a}

							{* Tady zamerne nepouzivame XHR mazani, aby se na strance viditelne zmenily ceny *}
							{capture assign=return_uri}{$request->getRequestUri()}#campaigns{/capture}
							{a_destroy action="order_campaigns/destroy" id=$order_campaign return_uri=$return_uri _xhr=false _confirm="{t}Opravdu chcete smazat tuto kampaň?{/t}"}{!"remove"|icon} {t}Smazat{/t}{/a_destroy}
						{/dropdown_menu}
					</td>
				</tr>
			{/foreach}
		</tbody>
	</table>

{/if}
