Files lists
===========

## Digital products download list
List of downloadable files, intended mainly to allow users download purchased digital products. Files already downloaded have download button in secondary color.

[example]
<div class="digital-products">
	
	<div class="digital-products__item">
		
		<div class="item__header">
			<h2 class="item__title">R.U.R., e-kniha</h2>
			<a href="#">Podrobnosti o produktu <span class="fas fa-chevron-right"></span></a>
		</div>
		
		<div class="list list--downloads">
			
			<a href="#" class="list__item">
				<div class="file__thumbnail">
					<img class="img-fluid" src="http://i.pupiq.net/i/6f/6f/952/2e952/1074x1515/JyUsGF_106x150_a6c87ef9df2884e8.jpg" alt="" width="106" height="150">
				</div>
				<div class="file__icon">
					<span class="fileicon fileicon-epub fileicon-color" data-icon-text="epub"></span>
				</div>
				<div class="file__text">
					<div class="file__title">rur.epub<span class="invisible-space"> </span></div>
					<div class="file__meta">soubor EPUB, 747,0 kB</div>
				</div>
				<div class="file__actions">
					<span class="btn btn-secondary"><span class="fas fa-cloud-download-alt"></span> Stáhnout</span>
				</div>
			</a>
			
			<a href="#" class="list__item">
				<div class="file__thumbnail">
					<img class="img-fluid" src="http://i.pupiq.net/i/6f/6f/952/2e952/1074x1515/JyUsGF_106x150_a6c87ef9df2884e8.jpg" alt="" width="106" height="150">
				</div>
				<div class="file__icon">
					<span class="fileicon fileicon-pdf fileicon-color" data-icon-text="pdf"></span>
				</div>
				<div class="file__text">
					<div class="file__title">rur.pdf<span class="invisible-space"> </span></div>
					<div class="file__meta">soubor PDF, 1,2 MB</div>
				</div>
				<div class="file__actions">
					<span class="btn btn-primary"><span class="fas fa-cloud-download-alt"></span> Stáhnout</span>
				</div>
			</a>
			
			<a href="#" class="list__item">
				<div class="file__thumbnail">
					<img class="img-fluid" src="http://i.pupiq.net/i/6f/6f/952/2e952/1074x1515/JyUsGF_106x150_a6c87ef9df2884e8.jpg" alt="" width="106" height="150">
				</div>
				<div class="file__icon">
					<span class="fileicon fileicon-prc fileicon-color" data-icon-text="prc"></span>
				</div>
				<div class="file__text">
					<div class="file__title">rur.prc<span class="invisible-space"> </span></div>
					<div class="file__meta">soubor PRC, 1,0 MB</div>
				</div>
				<div class="file__actions">
					<span class="btn btn-primary"><span class="fas fa-cloud-download-alt"></span> Stáhnout</span>
				</div>
			</a>
			
		</div>

	</div>
	
</div>
[/example]

## General files lists

Standard UL files list. Optional text description may be placed both inside or outside of <code>a</code> link element - outside placement is useful if you want to use links in description text.

[example]
<ul class="list--files">
	<li class="list__item">
		<a href="#" class="file__link">
			<span class="file__icon">
				<span class="fileicon fileicon-folder fileicon-color"></span>
			</span>
			<div class="file__text">
				<div class="file__title">Folder name</div>
				<div class="file__meta">33&nbsp;items</div>
			</div>
		</a>
	</li>
	<li class="list__item">
		<a href="#" class="file__link">
			<span class="file__icon">
				<span class="fileicon fileicon-pdf fileicon-color" data-icon-text="pdf"></span>
			</span>
			<div class="file__text">
				<div class="file__title">file_name.pdf</div>
				<div class="file__meta">soubor PDF, 488&nbsp;kB</div>
			</div>
		</a>
	</li>
	<li class="list__item">
		<a href="#" class="file__link">
			<span class="file__icon">
				<span class="fileicon fileicon-mpg fileicon-color" data-icon-text="mpg"></span>
			</span>
			<div class="file__text">
				<div class="file__title">file_name.mpg</div>
				<div class="file__meta">soubor MPG, 121&nbsp;MB</div>
			</div>
		</a>
	</li>
	<li class="list__item">
		<a href="#" class="file__link">
			<span class="file__icon">
				<span class="fileicon fileicon-zip fileicon-color" data-icon-text="zip"></span>
			</span>
			<div class="file__text">
				<div class="file__title">very_long_file_name_will_wrap.zip</div>
				<div class="file__meta">soubor ZIP, 1,2&nbsp;MB</div>
			</div>
		</a>
	</li>
	<li class="list__item">
		<a href="#" class="file__link">
			<span class="file__icon">
				<span class="fileicon fileicon-zip fileicon-color" data-icon-text="zip"></span>
			</span>
			<div class="file__text">
				<div class="file__title">file_name.zip</div>
				<div class="file__meta">soubor ZIP, 1,2&nbsp;MB</div>
			</div>
		</a>
		<div class="file__description">
			<p>This is optional file description. It is placed outside link element to allow for <a href="#">links.</a> in description text.</p>
			<p>Use very short texts if possible with minimum formatting.</p>
		</div>
	</li>
</ul>
[/example]

You may use file actions icons (they are hidden on mobile and are intended mostly as "decoration"):

[example]
<ul class="list--files">
	<li class="list__item">
		<a href="#" class="file__link">
			<span class="file__icon">
				<span class="fileicon fileicon-folder fileicon-color"></span>
			</span>
			<div class="file__text">
				<div class="file__title">Folder name</div>
				<div class="file__meta">33&nbsp;items</div>
			</div>
			<div class="file__action"><i class="fas fa-chevron-right"></i></div>
		</a>
	</li>
	<li class="list__item">
		<a href="#" class="file__link">
			<span class="file__icon">
				<span class="fileicon fileicon-pdf fileicon-color"></span>
			</span>
			<div class="file__text">
				<div class="file__title">file_name.pdf</div>
				<div class="file__meta">soubor PDF, 488&nbsp;kB</div>
			</div>
			<div class="file__action"><i class="fas fa-download"></i></div>
		</a>
	</li>
	<li class="list__item">
		<a href="#" class="file__link">
			<span class="file__icon">
				<span class="fileicon fileicon-mpg fileicon-color"></span>
			</span>
			<div class="file__text">
				<div class="file__title">file_name.mpg</div>
				<div class="file__meta">soubor MPG, 121&nbsp;MB</div>
			</div>
			<div class="file__action"><i class="fas fa-download"></i></div>
		</a>
	</li>
	<li class="list__item">
		<a href="#" class="file__link">
			<span class="file__icon">
				<span class="fileicon fileicon-zip fileicon-color"></span>
			</span>
			<div class="file__text">
				<div class="file__title">file_name.zip</div>
				<div class="file__meta">soubor ZIP, 1,2&nbsp;MB</div>
			</div>
			<div class="file__action"><i class="fas fa-download"></i></div>
		</a>
		<div class="file__description">
			<p>This is optional file description. It is placed outside link element to allow for <a href="#">links.</a> in description text.</p>
			<p>Use very short texts if possible with minimum formatting.</p>
		</div>
	</li>
</ul>
[/example]

You may happily use list without <code>ul</code> and <code>li</code> elements. In this case <code>a</code> element is <code>a.list__item</code> element.


[example]
<div class="list--files">
	<a href="#" class="list__item file__link">
		<span class="file__icon">
			<span class="fileicon fileicon-pdf fileicon-color"></span>
		</span>
		<div class="file__text">
			<div class="file__title">file_name.pdf</div>
			<div class="file__meta">soubor PDF, 488&nbsp;kB</div>
		</div>
	</a>
	<a href="#" class="list__item file__link" file__link>
		<span class="file__icon">
			<span class="fileicon fileicon-mpg fileicon-color"></span>
		</span>
		<div class="file__text">
			<div class="file__title">file_name.mpg</div>
			<div class="file__meta">soubor MPG, 121&nbsp;MB</div>
		</div>
	</a>
	<a href="#" class="list__item file__link">
		<span class="file__icon">
			<span class="fileicon fileicon-ppt fileicon-color"></span>
		</span>
		<div class="file__text">
			<div class="file__title">file_name.ppt</div>
			<div class="file__meta">soubor PPT, 1,2&nbsp;MB</div>
		</div>
		<div class="file__description">
			<p>This is optional file description.</p>
			<p>Use very short texts if possible with minimum formatting.</p>
		</div>
	</a>
</div>
[/example]
