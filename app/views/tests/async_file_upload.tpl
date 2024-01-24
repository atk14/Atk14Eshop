<h1>{$page_title}</h1>

{if $uploaded}
	<div class="alert alert-success">
		<p>File was successfully uploaded.</p>
		<ul>
			<li>filename: {$file->getFilename()}</li>
			<li>filesize: {$file->getFilesize()|format_bytes}</li>
			<li>md5 checksum: {$file_md5_checksum}</li>
		</ul>
	</div>
{/if}

{render partial="shared/form"}
{render partial="shared/form"}
