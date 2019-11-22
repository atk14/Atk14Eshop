{assign var=appname value=$current_region->getApplicationName()}
{assign var=eshop value=Store::FindByCode("eshop")}
{assign var=showroom value=Store::FindByCode("showroom")}
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
						{!"phone"|icon} <a href="tel:{"app.contact.phone"|system_parameter}">{"app.contact.phone"|system_parameter|display_phone}</a><br>
						{!"envelope"|icon} <a href="mailto:{"app.contact.email"|system_parameter}">{"app.contact.email"|system_parameter}</a>
					</p>
					<p>
						{t}IČ{/t}: {"merchant.billing_information.company_number"|system_parameter}<br>
						{t}DIČ{/t}: {"merchant.billing_information.vat_id"|system_parameter}
					</p>
				</address>
			</div>
			<div class="col-12 col-sm-6 col-md-3">
				{if $showroom}
					<h5>{$showroom->getName()}</h5>
					<address>
						{!$showroom->getAddress()|h|nl2br}<br>
					</address>
				{/if}
				<h5>Facebook</h5>
				<a href="{"app.contact.social.facebook"|system_parameter}" class="footer__socialicon">{!"facebook-square"|icon}</a>
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
