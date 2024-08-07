{*
 * {render partial="shared/iobjects" object=$article}
 *}

{assign var=iobjects value=Iobject::GetIobjects($object)}

<h3>{t}Objects inserted into text{/t}</h3>

{if $iobjects}

	<p>{t}Copy the desired object's marker ([# ...]) into the text.{/t}</p>

	<ul class="list-group list-sortable list-group--iobjects" data-sortable-url="{link_to action="iobject_links/set_rank"}">
		{foreach $iobjects as $iobject}
			{assign var=preview_image_url value=$iobject->getPreviewImageUrl()}
			{capture assign=confirm}{t}Do you really want to delete this object?{/t}{/capture}

			<li class="list-group-item" data-id="{$iobject->getIobjectLinkId($object)}">
				{dropdown_menu clearfix=false}
					{a controller=$iobject->getReferredTable() action=edit id=$iobject}{!"pencil-alt"|icon} {t}Edit{/t}{/a}
					{a_destroy controller="iobjects" id=$iobject}{!"trash-alt"|icon} {t}Delete{/t}{/a_destroy}
				{/dropdown_menu}

				{if $preview_image_url}
					{!$preview_image_url|pupiq_img:40x40xcrop:"class='list-group-item__thumbnail'"}
				{else}
					<img src="{$public}images/camera.svg" width="40" height="40" class="list-group-item__thumbnail">
				{/if}
				<span class="list-group-item__title">
				{!$iobject|iobject_type}
				{a controller=$iobject->getReferredTable() action=detail id=$iobject}
					{if $iobject->getTitle()}
						{$iobject->getTitle()}
					{else}
						<em>{t}bez názvu{/t}</em>
					{/if}
				{/a}
				</span>
				<div class="iobject-code-wrap">
					<span class="iobject-code" title="{t}copy this line to the text{/t}">{$iobject->getInsertMark()}</span> <a href="#" class="iobject-copy-code btn btn-sm btn-outline-default" role="button" {if USING_BOOTSTRAP5}data-bs-toggle="popover" data-bs-trigger="focus" data-bs-content="{t}Copied!{/t}" data-placement="top"{else}data-toggle="popover" data-trigger="focus" data-content="{t}Copied!{/t}" data-placement="top"{/if} tabindex="0"><span title="{t}Copy the line{/t}">{!"copy"|icon:"regular"}</span></a>
				</div>
			</li>

		{/foreach}
	</ul>
	<br>

{else}

	<p>{t}Currently there are no objects{/t}</p>

{/if}

<p>
	{a action="pictures/create_new" table_name=$object->getTableName() record_id=$object _class="btn btn-outline-primary"}{!"camera"|icon} {t}Add image{/t}{/a}
	{a action="galleries/create_new" table_name=$object->getTableName() record_id=$object return_uri=$request->getUri() _class="btn btn-outline-primary"}{!"images"|icon} {t}Add photogallery{/t}{/a}
	{a action="files/create_new" table_name=$object->getTableName() record_id=$object _class="btn btn-outline-primary"}{!"file"|icon} {t}Add attachment{/t}{/a}
	{a action="videos/create_new" table_name=$object->getTableName() record_id=$object _class="btn btn-outline-primary"}{!"video"|icon} {t}Add video{/t}{/a}
	{a action="card_promotions/create_new" table_name=$object->getTableName() record_id=$object _class="btn btn-outline-primary"}{!"ad"|icon} {t}Add product promotion{/t}{/a}
</p>

