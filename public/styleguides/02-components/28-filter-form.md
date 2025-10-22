Filter Form
===========

[example]

<form action="/obchod/" method="post" id="filter_form" autocomplete="off" class="remote_form" data-remote="true">
	<div id="filter" class="pfilter">
		<div class="pfilter__header">
			<h3 class="pfilter__title">Filtrace produktů</h3>
			<div class="pfilter__alt-filters js--filter_head">
			</div>
		</div>
		<div class="pfilter__body js--filter_fields">
			
			<input type="hidden" name="active_filter_page" value="f_f42">

			<ul class="nav nav-tabs" id="filtertabs" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="f_f42-tab" data-bs-toggle="tab" href="#f_f42" role="tab" rel="nofollow" aria-controls="f_f42" aria-selected="true" data-page="f_f42">Materiál</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="f_f55-tab" data-bs-toggle="tab" href="#f_f55" role="tab" rel="nofollow" aria-controls="f_f55" aria-selected="false" data-page="f_f55">Barva</a>
				</li>
			</ul>

			<div class="tab-content" id="filtertabscontent">
				
				<div class="tab-pane fade show active" id="f_f42" role="tabpanel" aria-labelledby="f_f42-tab">
					<ul class="list list--checkboxes">
						<li class="list__item">
							<div class="custom-control custom-checkbox">
								<input type='checkbox' name='f_f42[]' value=43 class='custom-control-input' id='id_f_f42_0'> <label class='custom-control-label' for='id_f_f42_0'><a class='js-filter-checkbox-label' href='/obchod/?f_f42%5B%5D=43' rel="nofollow">dřevo (1)</a></label>
							</div>
						</li>
						<li class="list__item">
							<div class="custom-control custom-checkbox">
								<input type='checkbox' name='f_f42[]' value=44 class='custom-control-input' id='id_f_f42_1'> <label class='custom-control-label' for='id_f_f42_1'><a class='js-filter-checkbox-label' href='/obchod/?f_f42%5B%5D=44' rel="nofollow">papír (6)</a></label>
							</div>
						</li>
						<li class="list__item">
							<div class="custom-control custom-checkbox">
								<input type='checkbox' name='f_f42[]' value=45 class='custom-control-input' id='id_f_f42_2'> <label class='custom-control-label' for='id_f_f42_2'><a class='js-filter-checkbox-label' href='/obchod/?f_f42%5B%5D=45' rel="nofollow">kov (4)</a></label>
							</div>
						</li>
						<li class="list__item">
							<div class="custom-control custom-checkbox">
								<input type='checkbox' name='f_f42[]' value=64 class='custom-control-input' id='id_f_f42_3'> <label class='custom-control-label' for='id_f_f42_3'><a class='js-filter-checkbox-label' href='/obchod/?f_f42%5B%5D=64' rel="nofollow">plast (8)</a></label>
							</div>
						</li>
					</ul>
				</div>
				
				<div class="tab-pane fade" id="f_f55" role="tabpanel" aria-labelledby="f_f55-tab">
					<ul class="list list--checkboxes">
						<li class="list__item">
							<div class="custom-control custom-checkbox">
								<input type='checkbox' name='f_f55[]' value=56 class='custom-control-input' id='id_f_f55_0'> <label class='custom-control-label' for='id_f_f55_0'><a class='js-filter-checkbox-label' href='/obchod/?f_f55%5B%5D=56' rel="nofollow">Červená (4)</a></label>
							</div>
						</li>
						<li class="list__item">
							<div class="custom-control custom-checkbox">
								<input type='checkbox' name='f_f55[]' value=61 class='custom-control-input' id='id_f_f55_1'> <label class='custom-control-label' for='id_f_f55_1'><a class='js-filter-checkbox-label' href='/obchod/?f_f55%5B%5D=61' rel="nofollow">Zelená (1)</a></label>
							</div>
						</li>
						<li class="list__item">
							<div class="custom-control custom-checkbox">
								<input type='checkbox' name='f_f55[]' value=58 class='custom-control-input' id='id_f_f55_2'> <label class='custom-control-label' for='id_f_f55_2'><a class='js-filter-checkbox-label' href='/obchod/?f_f55%5B%5D=58' rel="nofollow">Žlutá (5)</a></label>
							</div>
						</li>
						<li class="list__item">
							<div class="custom-control custom-checkbox">
								<input type='checkbox' name='f_f55[]' value=59 class='custom-control-input' id='id_f_f55_3'> <label class='custom-control-label' for='id_f_f55_3'><a class='js-filter-checkbox-label' href='/obchod/?f_f55%5B%5D=59' rel="nofollow">Růžová (2)</a></label>
							</div>
						</li>
						<li class="list__item">
							<div class="custom-control custom-checkbox">
								<input type='checkbox' name='f_f55[]' value=60 class='custom-control-input' id='id_f_f55_4'> <label class='custom-control-label' for='id_f_f55_4'><a class='js-filter-checkbox-label' href='/obchod/?f_f55%5B%5D=60' rel="nofollow">Fialová (1)</a></label>
							</div>
						</li>
						<li class="list__item">
							<div class="custom-control custom-checkbox">
								<input type='checkbox' name='f_f55[]' value=62 class='custom-control-input' id='id_f_f55_5'> <label class='custom-control-label' for='id_f_f55_5'><a class='js-filter-checkbox-label' href='/obchod/?f_f55%5B%5D=62' rel="nofollow">Hnědá (1)</a></label>
							</div>
						</li>
						<li class="list__item">
							<div class="custom-control custom-checkbox">
								<input type='checkbox' name='f_f55[]' value=65 class='custom-control-input' id='id_f_f55_6'> <label class='custom-control-label' for='id_f_f55_6'><a class='js-filter-checkbox-label' href='/obchod/?f_f55%5B%5D=65' rel="nofollow">Bílá (2)</a></label>
							</div>
						</li>
						<li class="list__item">
							<div class="custom-control custom-checkbox">
								<input type='checkbox' name='f_f55[]' value=66 class='custom-control-input' id='id_f_f55_7'> <label class='custom-control-label' for='id_f_f55_7'><a class='js-filter-checkbox-label' href='/obchod/?f_f55%5B%5D=66' rel="nofollow">Černá (2)</a></label>
							</div>
						</li>
					</ul>
				</div>
				
			</div>
			
		</div>
		<div class="pfilter__footer">
			<div class="nojs-only">
				<div class="form-group">
					<span class="button-container"><button type="submit" class="btn btn-default nojs-only">Filtrovat</button></span>
				</div>
			</div>

			<div class="active-filters js--active_filters">
				<div class="active-filters__count">
					<div class="catproductcount js--products-count">Výběru odpovídá: <strong>45</strong>&nbsp;<span>produktů</span>
					</div>
				</div>
			</div>

		</div>
	</div>

</form>
[/example]