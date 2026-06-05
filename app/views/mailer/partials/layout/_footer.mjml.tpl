		
		{assign eshop Store::FindByCode("eshop")}
		{if 'app.contact.social.facebook'|system_parameter}{assign show_fb true}{/if}
		{if 'app.contact.social.instagram'|system_parameter}{assign show_ig true}{/if}
		{if 'app.contact.social.linkedin'|system_parameter}{assign show_li true}{/if}
		{if 'app.contact.social.pinterest'|system_parameter}{assign show_pi true}{/if}
		{if 'app.contact.social.snapchat'|system_parameter}{assign show_sn true}{/if}
		{if 'app.contact.social.twitter'|system_parameter}{assign show_tw true}{/if}
		{if 'app.contact.social.vimeo'|system_parameter}{assign show_vm true}{/if}
		{if 'app.contact.social.youtube'|system_parameter}{assign show_yt true}{/if}
		{if 'app.contact.social.soundcloud'|system_parameter}{assign show_sc true}{/if}
		{assign stores Store::FindAll("visible AND (code IS NULL OR code!='eshop')",[])}
		{assign phone_number "app.contact.phone"|system_parameter|replace:' ':''|replace:".":""}
		
		{* icon color variants: "dark" | "light" | "color" *}
		{if !$social_icons_theme}
			{assign social_icons_theme "dark"}
		{/if}
		
		<mj-section>
			<mj-column>
				<mj-spacer></mj-spacer>
			</mj-column>
		</mj-section>

		<mj-section mj-class="footer" css-class="footer">
			<mj-column>
				<mj-text mj-class="footertext">
					<p class="footertext">
						<a href="{!$region->getDefaultUrl()}">{"app.name.official"|system_parameter}</a><br/>
						{if $eshop}
						{$eshop->getAddressStreet()}<br/>
						{if $eshop->getAddressStreet2()}
						{$eshop->getAddressStreet2()}<br/>
						{/if}
						{$eshop->getAddressZip()} {$eshop->getAddressCity()}<br/>
						{/if}
					</p>
					<p class="footertext">Tel: <a href="tel:{$phone_number}">{"app.contact.phone"|system_parameter|display_phone}</a></p>
				</mj-text>
			</mj-column>
			<mj-column>
				<mj-social font-size="15px" icon-size="20px" mode="vertical" align="left" icon-padding="5px" text-padding="0">
					<mj-raw><!-- htmlonly --></mj-raw>
					{if $show_fb}
					<mj-social-element name="facebook-noshare" href="{'app.contact.social.facebook'|system_parameter}" src="{$site_url}public/dist/images/socialicons--mailing/{$social_icons_theme}/png/facebook.png">
						Facebook
					</mj-social-element>
					{/if}

					{if $show_ig}
					<mj-social-element name="instagram-noshare" href="{'app.contact.social.instagram'|system_parameter}" src="{$site_url}public/dist/images/socialicons--mailing/{$social_icons_theme}/png/instagram.png">
						Instagram
					</mj-social-element>
					{/if}

					{if $show_li}
					<mj-social-element name="linkedin-noshare" href="{'app.contact.social.linkedin'|system_parameter}" src="{$site_url}public/dist/images/socialicons--mailing/{$social_icons_theme}/png/linkedin.png">
						LinkedIn
					</mj-social-element>
					{/if}

					{if $show_pi}
					<mj-social-element name="pinterest-noshare" href="{'app.contact.social.pinterest'|system_parameter}" src="{$site_url}public/dist/images/socialicons--mailing/{$social_icons_theme}/png/pinterest.png">
						Pinterest
					</mj-social-element>
					{/if}

					{if $show_sn}
					<mj-social-element name="snapchat-noshare" href="{'app.contact.social.snapchat'|system_parameter}" src="{$site_url}public/dist/images/socialicons--mailing/{$social_icons_theme}/png/snapchat.png">
						Snapchat
					</mj-social-element>
					{/if}

					{if $show_tw || $show_x}
					<mj-social-element name="x-noshare" href="{'app.contact.social.twitter'|system_parameter}" src="{$site_url}public/dist/images/socialicons--mailing/{$social_icons_theme}/png/x.png">
						X
					</mj-social-element>
					{/if}

					{if $show_vm}
					<mj-social-element name="vimeo-noshare" href="{'app.contact.social.vimeo'|system_parameter}" src="{$site_url}public/dist/images/socialicons--mailing/{$social_icons_theme}/png/vimeo.png">
						Vimeo
					</mj-social-element>
					{/if}

					{if $show_yt}
					<mj-social-element name="youtube-noshare" href="{'app.contact.social.youtube'|system_parameter}" src="{$site_url}public/dist/images/socialicons--mailing/{$social_icons_theme}/png/youtube.png">
						YouTube
					</mj-social-element>
					{/if}

					{if $show_sc}
					<mj-social-element name="soundcloud-noshare" href="{'app.contact.social.soundcloud'|system_parameter}" src="{$site_url}public/dist/images/socialicons--mailing/{$social_icons_theme}/png/soundcloud.png">
						SoundCloud
					</mj-social-element>
					{/if}
					<mj-raw><!-- /htmlonly --></mj-raw>
				</mj-social>
			</mj-column>
		</mj-section>

		<mj-section mj-class="footer-bottom">
			<mj-column>
				<mj-divider padding-bottom="0"></mj-divider>
				<mj-navbar mj-class="footer-navbar">
				{foreach [
					"terms_and_conditions",
					"privacy_policy"
				] as $code}
					{assign page Page::GetInstanceByCode($code)}
					{if $page && $page->isVisible()}
						<mj-navbar-link href="{$page|link_to_page:"with_hostname"}" mj-class="footer-navbar-link">{$page->getTitle()}</mj-navbar-link>
					{/if}
				{/foreach}
				</mj-navbar>
			</mj-column>
		</mj-section>