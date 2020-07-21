Grid system
===========

<style>
	.styleguide-example__output .row > * {
		background-color: lightslategray;
		outline: 2px solid white;
		padding-top: 10px;
		padding-bottom: 10px;
		color: white;
		font-size: 0.75rem;
	}
	.styleguide-example__output .row {
		display: flex !important;
		margin: 0 !important;
	}
	.badges {
		//max-width: 100px;
		margin-bottom: 40px;
	}
	.badges .badge {
		padding-top: 10px;
		padding-bottom: 10px;
	}
</style>

Grid system creates layout with 12 columns. Grid classes are used to create columns with width from 1/12 to 1/1 of container width. For full information check Bootstrap documentation. Here you can find simplified explanation.

## Usage:
Columns must be placed in container with <code>row</code> class. Column classes have names with following structure:

<code>col-[number of columns]</code> where or <code>col-[breakpoint]-[number_of_columns]</code> where [breakpoint] is one of breakpoints ( <code>sm</code>, <code>md</code>, <code>lg</code> or <code>xl</code> ) from table below and [number_of_columns] is number of spanned columns. Breakpoints sets minimum width for which class would apply. 

Usually you will want content to span full width on small screens - so you should use <code>col-12</code> which creates full width column on all viewport widths. On larger screen you may wont for example 2 columns - so you will use class like <code>col-sm-6</code> which creates half-width column on screens 540&nbsp;px and up. And on large screens you may want column of 1/4 width - so just add class <code>col-lg-3</code>. In this case resulting class attribute would be <code>class="col-12 col-sm-6 col-lg-3"</code>

Columns in row may have various widths. If their total number exceeds 12, they will break into another row.

See this example and try to resize width of your browser window and see how layout changes.

[example]
<div class="row">
	<div class="col-12 col-sm-6 col-md-4 col-lg-3">col-12 col-sm-6 col-md-4 col-lg-3</div> 
	<div class="col-12 col-sm-6 col-md-4 col-lg-4">col-12 col-sm-6 col-md-4 col-lg-4</div> 
	<div class="col-12 col-md-4 col-lg-5">col-12 col-md-4 col-lg-5</div> 
</div>
[/example]

Current viewport size:

<div class="badges">
<span class="badge badge-danger d-block  d-sm-none">XS (less than 575 px)</span>
<span class="badge badge-warning d-none d-sm-block d-md-none">SM (576 to 767 px)</span>
<span class="badge badge-success d-none d-md-block d-lg-none">MD (768 to 991 px)</span>
<span class="badge badge-info d-none d-lg-block d-xl-none">LG (992 to 1199 px)</span>
<span class="badge badge-secondary d-none d-xl-block">XL (1200 px and up)</span>
</div>

### Breakpoints overview

<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th></th>
      <th class="text-center">
        Extra small<br>
        <small>&lt;576px</small>
      </th>
      <th class="text-center">
        Small<br>
        <small>≥576px</small>
      </th>
      <th class="text-center">
        Medium<br>
        <small>≥768px</small>
      </th>
      <th class="text-center">
        Large<br>
        <small>≥992px</small>
      </th>
      <th class="text-center">
        Extra large<br>
        <small>≥1200px</small>
      </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th class="text-nowrap" scope="row">Max container width</th>
      <td>None (auto)</td>
      <td>540px</td>
      <td>720px</td>
      <td>960px</td>
      <td>1140px</td>
    </tr>
    <tr>
      <th class="text-nowrap" scope="row">Class prefix</th>
      <td><code>.col-</code></td>
      <td><code>.col-sm-</code></td>
      <td><code>.col-md-</code></td>
      <td><code>.col-lg-</code></td>
      <td><code>.col-xl-</code></td>
    </tr>
    <tr>
      <th class="text-nowrap" scope="row"># of columns</th>
      <td colspan="5">12</td>
    </tr>
  </tbody>
</table>

### Usage in Markdown
In ATK14Eshop Markdown editor you may easily create equal-width columns with <code>	&#91;row&#93;</code> and <code>&#91;col&#93;</code> shortcodes like this:
<pre><code>
&#91;row&#93;
	&#91;col]Column content&#91;/col&#93;
	&#91;col]Column content&#91;/col&#93;
&#91;/row&#93;
</code></pre>

which creates
[example]
[row][col]Column content[/col][col]Column content[/col][/row]
[/example]