<h1>{$page_title}</h1>

{render partial="shared/form"}

<p>
	{capture assign=category_path}/{$category->getPath()}{/capture}
	{t}Product doesn't exist yet?{/t} &rarr; {a action="cards/create_new" category=$category_path}{t}create new one{/t}{/a}
</p>
