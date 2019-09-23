<footer class="footer">
	<hr>

	<div class="row justify-content-between">
		{render partial="shared/layout/footer/link_list" link_list=LinkList::GetInstanceByCode("footer_1")}
		{render partial="shared/layout/footer/link_list" link_list=LinkList::GetInstanceByCode("footer_2")}
		{render partial="shared/layout/footer/link_list" link_list=LinkList::GetInstanceByCode("footer_3")}
	</div>

	<p>{t escape=no}This site runs on <a href="http://www.atk14.net/">ATK14 Framework</a>, for now and ever after{/t}</p>

	{render partial="shared/layout/footer/menu" menu=$lazy_loader.footer_1_menu}
	{render partial="shared/layout/footer/menu" menu=$lazy_loader.footer_2_menu}
</footer>
