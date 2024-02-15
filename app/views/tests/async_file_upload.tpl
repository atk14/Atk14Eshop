<h1>{$page_title}</h1>

{if $files}
	<div class="alert alert-success">
		{foreach $files as $file}
		{assign i $file@index+1}
		{if $file}
		<p>File #{$i} was successfully uploaded.</p>
		<ul>
			<li>filename: {$file->getFilename()}</li>
			<li>filesize: {$file->getFilesize()|format_bytes}</li>
			<li>md5 checksum: {md5_file($file->getTmpFilename())}</li>
		</ul>
		{else}
		<p>File #{$i} has not been submitted.</p>
		{/if}
		{/foreach}
	</div>
{/if}

{render partial="shared/form"}
{* render partial="shared/form" *}
