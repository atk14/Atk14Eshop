Color system
============

Color system uses Bootstrap color system with few enhancements. All color values listed here are set as SCSS variables in <code>public/styles/_bootstrap_variables.scss</code> file and most of them are also available as CSS variables a.k.a. CSS custom properties.

In SCSS code, colors should be used as Bootstrap variables for visual consistency and easy maintenance and future development. When color bears some semantic meaning (like red for errors etc.), system colors like <code>$danger</code> should be used. 

## Basic color palette
		
Note: Color values differ from standard HTML named colors.

Also available as CSS variables such as <code>--blue</code>

[literal]

<div class="styleguide-color-swatches">
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--blue);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">Blue</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--indigo);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">Indigo</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--purple);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">Purple</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--pink);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">Pink</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--red);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">Red</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--orange);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">Orange</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--yellow);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">Yellow</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--green);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">Green</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--teal);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">Teal</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--cyan);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">Cyan</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--white);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">White</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--gray);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">Gray</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--gray-dark);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">Gray-dark</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
</div>

[/literal]

## System color palette

Due to their semantic naming it is highly recommended to use this palette whenever possible. Bootstrap color palette was extended with <code>brand</code> color. Note that these colors are mostly selection of basic color palette above.
		
Also available as CSS variables such as <code>--primary</code>

[literal]

<div class="styleguide-color-swatches">
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--brand);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">brand</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--primary);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">primary</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--secondary);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">secondary</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--success);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">success</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--info);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">info</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--warning);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">warning</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--danger);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">danger</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--light);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">light</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--dark);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">dark</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
</div>

[/literal]

### Usage:
- *primary* for primary controls, links and emphasis, active states etc.
- *secondary* for secondary controls like Cancel buttons etc.
- *success, info, warning, danger* for components status, status alerts, errors etc.
- *dark* and *light* for light and dark backgrounds, component colors etc.
- *brand* is main brand color



These colors may also be used as Bootstrap color utility classes such as <code>.bg-primary</code>, <code>.text-primary</code>, <code>.bg-gradient-primary</code>, <code>.border border-primary</code>
		
## Grays

Unlike Bootstrap, gray palette is also available as CSS variables such as <code>--gray-100</code>

[literal]
		
<div class="styleguide-color-swatches">
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--gray-100);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">gray-100</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--gray-200);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">gray-200</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--gray-300);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">gray-300</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--gray-400);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">gray-400</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--gray-500);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">gray-500</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--gray-600);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">gray-600</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--gray-700);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">gray-700</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--gray-800);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">gray-800</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--gray-900);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">gray-900</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
</div>

[/literal]

## Some other important colors

Some other colors used across various elements across the site. Note that these colors are mostly selection of palettes above.

[literal]
		
<div class="styleguide-color-swatches">
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--body-color);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">body-color</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--body-bg);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">body-bg</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--link-color);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">link-color</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--link-hover-color);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">link-hover-color</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>
	<div class="color-swatch">
		<div class="color-swatch__patch" style="background-color: var(--border-color);"></div>
		<div class="color-swatch__text">
			<div class="color-swatch__name">border-color</div>
			<div class="color-swatch__value"></div>
		</div>
	</div>

</div>

[/literal]