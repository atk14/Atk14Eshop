{*
	Spacer to create empty vertical space in emails. Height is in px.
	{render partial="partials/spacer" height=100}
*}
<!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
	<div style="margin:0px auto;max-width:600px;">
		<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
			<tbody>
				<tr>
					<td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0;padding-top:0;text-align:center;">
						<!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]-->
						<div class="mj-column-per-100 mj-outlook-group-fix" style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
							<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;" width="100%">
								<tbody>
									<tr>
										<td style="font-size:0px;word-break:break-word;">
											<div style="height:{$height}px;line-height:{$height}px;">&#8202;</div>
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