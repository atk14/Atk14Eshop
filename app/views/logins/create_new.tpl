{render partial="shared/layout/content_header" title=$page_title}
<section>
	{render partial="shared/form"}
	
	<p>{a action="password_recoveries/create_new"}{t}Have you forgotten password?{/t}{/a}</p>
	<p>{a action="users/create_new"}{t}Don't have an account yet? Register now.{/t}{/a}</p>
</section>