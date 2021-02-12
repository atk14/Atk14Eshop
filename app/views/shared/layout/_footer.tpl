{assign var=appname value=$current_region->getApplicationName()}
{assign var=eshop value=Store::FindByCode("eshop")}
<footer class="footer">
	<div class="container-fluid">
		<div class="row justify-content-between footer__main">
			{render partial="shared/layout/footer/link_list" link_list=LinkList::GetInstanceByCode("footer_1")}
			{render partial="shared/layout/footer/link_list" link_list=LinkList::GetInstanceByCode("footer_2")}
			{*render partial="shared/layout/footer/link_list" link_list=LinkList::GetInstanceByCode("footer_3")*}
			<div class="col-12 col-sm-6 col-md-3">
				{admin_menu for=$eshop edit_title="{t}Upravit údaje provozovny{/t}" only_edit=1}
				<h5>{t}Kontakt{/t}</h5>
				<address>
					<p>
						{"app.name.official"|system_parameter}<br>
						{!$eshop->getAddress()|h|nl2br}<br>
						{!$eshop->getAddressCountry()|to_country_name}
					</p>
					<p>
						{if "app.contact.phone"|system_parameter}<a href="tel:{"app.contact.phone"|system_parameter}" title="{t}phone number{/t}">{!"phone"|icon} {"app.contact.phone"|system_parameter|display_phone}</a><br>{/if}
						{if "app.contact.email"|system_parameter}<a href="mailto:{"app.contact.email"|system_parameter}" title="{t}email{/t}">{!"envelope"|icon} {"app.contact.email"|system_parameter}</a><br>{/if}
						{if "app.contact.messaging.skype"|system_parameter}<a href="skype:{"app.contact.messaging.skype"|system_parameter}" title="Skype">{!"skype"|icon}&nbsp;&nbsp;{"app.contact.messaging.skype"|system_parameter}</a><br>{/if}
						{if "app.contact.messaging.icq"|system_parameter}<a href="https://icq.im/{"app.contact.messaging.icq"|system_parameter}" title="ICQ"><img src="{$public}images/icq-logo.svg" width="18" height="18" alt="ICQ"> {"app.contact.messaging.icq"|system_parameter}</a><br>{/if}
					</p>
					<p>
						{t}IČ{/t}: {"merchant.billing_information.company_number"|system_parameter}<br>
						{t}DIČ{/t}: {"merchant.billing_information.vat_id"|system_parameter}
					</p>
				</address>
			</div>
			<div class="col-12 col-sm-6 col-md-3">
				{render partial="shared/layout/footer/stores"}
				{render partial="shared/layout/footer/social"}
			</div>
		</div>
	</div>
	<div class="footer__smallprint">
		<div class="container-fluid">
			<p>&copy;&nbsp;2019&nbsp;&ndash;&nbsp;{"Y"|date} {"app.name"|system_parameter}</p>
			<p>Created by <a href="https://www.snapps.eu/"><strong>sna<em>pp</em>s!</strong></a></p>
		</div>
	</div>
	
</footer>
