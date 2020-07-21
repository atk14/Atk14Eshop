<style scoped="true">
	.tests-colors__conversion {
		display: flex;
		align-items: center;
		flex-wrap: wrap;
	} 
	.tests-colors__patch {
		display: block;
		width: 40px;
		height: 40px;
		border: 1px solid #ccc;
	}
	.tests-colors__name {
		align-self: center;
		padding: 1em;
		min-width: 200px;
		font-size: 0.8rem;
	}
	.tests-colors__textpatch {
		width: 150px;
		height: 150px;
		margin: 10px;
		padding: 10px;
		border: 1px solid #ccc;
		font-size: 0.8rem;
		font-weight: bold;
	}
</style>

<h2>Color Formats Conversion and Color Manipulation</h2>

<p>https://github.com/aristath/ariColor</p>
<p>Uses modifier color_to_rgba and sets alpha to 0.8</p>

{render partial="colors/conversion" color="#f40563"}
{render partial="colors/conversion" color="#C06"}
{render partial="colors/conversion" color="rgb(44,87,128)"}
{render partial="colors/conversion" color="rgba(44,87,128)"}
{render partial="colors/conversion" color="rgba(44,87,128,0.25)"}
{render partial="colors/conversion" color="hsla(120,60%,70%,0.3)"}
{render partial="colors/conversion" color="hsl( 120, 60%, 70% )"}
{render partial="colors/conversion" color="pink"}
{render partial="colors/conversion" color="violet"}
{render partial="colors/conversion" color="red"}

<h2 class="mt-4">Text contrast colors</h2>

<p>Uses modifier contrast_text_color</p>
<p>Does not consider aplha</p>

<div style="display: flex; flex-wrap: wrap; margin: 0 -10px;">
{render partial="colors/text_contrast" color="#000000"}
{render partial="colors/text_contrast" color="#ffffff"}
{render partial="colors/text_contrast" color="#f40563"}
{render partial="colors/text_contrast" color="#C06"}
{render partial="colors/text_contrast" color="rgb(44,87,128)"}
{render partial="colors/text_contrast" color="darkblue"}
{render partial="colors/text_contrast" color="pink"}
{render partial="colors/text_contrast" color="coral"}
{render partial="colors/text_contrast" color="navy"}
{render partial="colors/text_contrast" color="chartreuse"}
{render partial="colors/text_contrast" color="darkslateblue"}
{render partial="colors/text_contrast" color="cornflowerblue"}
{render partial="colors/text_contrast" color="blanchedalmond"}
{render partial="colors/text_contrast" color="darkred"}
{render partial="colors/text_contrast" color="darkcyan"}
{render partial="colors/text_contrast" color="darkgrey"}
{render partial="colors/text_contrast" color="darkorange"}
{render partial="colors/text_contrast" color="gold"}
{render partial="colors/text_contrast" color="greenyellow"}
{render partial="colors/text_contrast" color="lawngreen"}
{render partial="colors/text_contrast" color="lightcoral"}
{render partial="colors/text_contrast" color="linen"}
{render partial="colors/text_contrast" color="indianred"}
{render partial="colors/text_contrast" color="lightskyblue"}
{render partial="colors/text_contrast" color="mediumorchid"}
{render partial="colors/text_contrast" color="mediumvioletred"}
{render partial="colors/text_contrast" color="limegreen"}
{render partial="colors/text_contrast" color="lightyellow"}
{render partial="colors/text_contrast" color="paleturquoise"}
{render partial="colors/text_contrast" color="mistyrose"}
{render partial="colors/text_contrast" color="orchid"}
{render partial="colors/text_contrast" color="peachpuff"}
{render partial="colors/text_contrast" color="snow"}
{render partial="colors/text_contrast" color="turquoise"}
{render partial="colors/text_contrast" color="thistle"}
{render partial="colors/text_contrast" color="violet"}
{render partial="colors/text_contrast" color="red"}
{render partial="colors/text_contrast" color="tomato"}

</div>

