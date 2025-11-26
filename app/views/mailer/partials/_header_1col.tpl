{*
	Full width header with centered logo.
	Colors and logo url are set in application_mailer.php controller.
	{render partial="partials/header_1col"}
*}
	<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" class="header" style="width:100%;">
		<tbody>
			<tr>
				<td>
					<!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="{$brand_color}" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
					<div style="margin:0px auto;max-width:600px;">
						<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
							<tbody>
								<tr>
									<td style="direction:ltr;font-size:0px;padding:0;padding-bottom:0;padding-top:0;text-align:left;">
										<!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]-->
										<div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
											<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
												<tbody>
													<tr>
														<td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
															<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;border-spacing:0px;">
																<tbody>
																	<tr>
																		<td style="width:103px;">
																			<a href="{!$region->getDefaultUrl()}" target="_blank" style="color: {$link_color};">
																				<img alt="{$region->getApplicationName()}" src="{$logo_src}"  class="header__logo" style="border:0;display:block;outline:none;text-decoration:none;height:{$logo_height};width:100%;font-size:16px;" width="{$logo_width}" height="{$logo_height}">
																			</a>
																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										<!--[if mso | IE]></td></tr></table><![endif]-->
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<!--[if mso | IE]></td></tr></table><![endif]-->
				</td>
			</tr>
		</tbody>
	</table>
