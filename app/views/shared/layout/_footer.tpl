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
						{if "app.contact.phone"|system_parameter}{!"phone"|icon} <a href="tel:{"app.contact.phone"|system_parameter}">{"app.contact.phone"|system_parameter|display_phone}</a><br>{/if}
						{if "app.contact.email"|system_parameter}{!"envelope"|icon} <a href="mailto:{"app.contact.email"|system_parameter}">{"app.contact.email"|system_parameter}</a>{/if}
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
			<p>&copy;&nbsp;2019 {"app.name"|system_parameter}</p>
			<p>Created by NTV AGE</p>
		</div>
	</div>
	
</footer>
