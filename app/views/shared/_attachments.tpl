{*
 * {render partial="shared/attachments" object=$card_section}
 *}

{assign var=attachments value=Attachment::GetAttachments($object)}
{if $attachments}
	<section class="section--product-info section--attachments">
		<h4 class="section__title">{t}Attachments{/t}</h4>
		<div class="section__body">
			<ul class="list-unstyled">
				{foreach $attachments as $attachment}
					<li>	
						<a href="{$attachment->getUrl()}">
							<span>
								<span class="fileicon fileicon-{$attachment->getSuffix()} fileicon-color"></span>
								<span class="file-name">{$attachment->getName()}</span>
							</span>
							<span class="iobject--file__meta">[{$attachment->getMimeType()}, {$attachment->getFilesize()|format_bytes}] </span></a>
					</li>
				{/foreach}
			</ul>
		</div>
	</section>
{/if}