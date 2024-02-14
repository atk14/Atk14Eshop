<h1>{$page_title}</h1>

{if $uploaded}
	<div class="alert alert-success">
		<p>File #1 was successfully uploaded.</p>
		<ul>
			<li>filename: {$file->getFilename()}</li>
			<li>filesize: {$file->getFilesize()|format_bytes}</li>
			<li>md5 checksum: {$file_md5_checksum}</li>
		</ul>
		{if $file2}
		<p>File #2 was successfully uploaded.</p>
		<ul>
			<li>filename: {$file2->getFilename()}</li>
			<li>filesize: {$file2->getFilesize()|format_bytes}</li>
			<li>md5 checksum: {$file2_md5_checksum}</li>
		</ul>
		{else}
		<p>File #2 has not been submitted.</p>
		{/if}
	</div>
{/if}

{render partial="shared/form"}
{* render partial="shared/form" *}
