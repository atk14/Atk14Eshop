<h1>{$page_title}</h1>

{if !class_exists("ExtendedPasswordField")}
	<p class="alert alert-warning">Package atk14/extended-password-field is not installed.</p>
{/if}

{render partial="shared/form"}
