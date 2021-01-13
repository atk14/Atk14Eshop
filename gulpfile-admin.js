var gulp = require( "gulp" );
var del = require( "del" );
var $ = require( "gulp-load-plugins" )();
var browserSync = require( "browser-sync" ).create();
const { series, parallel } = require( "gulp" );

var vendorStyles = [
	"node_modules/blueimp-file-upload/css/jquery.fileupload.css",
	"node_modules/bootstrap-markdown-editor-4/dist/css/bootstrap-markdown-editor.min.css",
	"node_modules/jquery-ui-bundle/jquery-ui.css",
	"node_modules/@fortawesome/fontawesome-free/css/all.css",
	"node_modules/animate.css/animate.css"
];
var vendorScripts = [
	"node_modules/jquery/dist/jquery.js",
	"node_modules/jquery-ui-bundle/jquery-ui.js",
	"node_modules/blueimp-file-upload/js/jquery.fileupload.js",
	"node_modules/ace-builds/src/ace.js",
	"node_modules/bootstrap-markdown-editor-4/dist/js/bootstrap-markdown-editor.min.js",
	"node_modules/bootstrap/dist/js/bootstrap.bundle.js", // Bootstrap + Popper
	"node_modules/atk14js/src/atk14.js",
	"node_modules/unobfuscatejs/src/jquery.unobfuscate.js",
	"node_modules/popper.js/dist/umd/popper.js",
	"node_modules/bootstrap4-notify/bootstrap-notify.js",
	"node_modules/moment/moment.js",
	"node_modules/moment/locale/cs.js",
	"node_modules/chart.js/dist/Chart.js",
	"node_modules/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.js"
];

var applicationScripts = [
	"public/scripts/utils/utils.js",
	"public/scripts/utils/leaving_unsaved_page_checker.js",
	"public/admin/scripts/utils/dashboard_charts.js",
	"public/scripts/utils/filterable_list.js",
	"public/admin/scripts/application.js",
	"public/admin/scripts/tooltip.js"
];

// CSS
var styles_admin = function() {
	return gulp.src( "public/admin/styles/application.scss" )
		.pipe( $.sourcemaps.init() )
		.pipe( $.sass( {
			includePaths: [
				"public/admin/styles"
			]
		} ) )
		.pipe( $.autoprefixer( { grid: true } ) )
		.pipe( $.cssnano() )
		.pipe( $.rename( { suffix: ".min" } ) )
		.pipe( $.sourcemaps.write( ".", { sourceRoot: null } ) )
		.pipe( gulp.dest( "public/admin/dist/styles" ) )
		.pipe( browserSync.stream( { match: "**/*.css" } ) );
};

var styles_from_frontend = function() {
	return gulp.src( ["public/admin/styles/shared/frontend-styles.scss"] )
		.pipe( $.sourcemaps.init() )
		.pipe( $.sass() )
		.pipe( $.autoprefixer( { grid: true } ) )
		.pipe( $.cssnano() )
		.pipe( $.rename( { suffix: ".min" } ) )
		.pipe( $.sourcemaps.write( ".", { sourceRoot: null } ) )
		.pipe( gulp.dest( "public/admin/dist/styles" ) )
		.pipe( browserSync.stream( { match: "**/*.css" } ) );
};

var styles_vendor_admin = function() {
	return gulp.src( vendorStyles )
		.pipe( $.sourcemaps.init() )
		.pipe( $.concatCss( "vendor.css", { rebaseUrls: false } ) )
		.pipe( $.autoprefixer() )
		.pipe( $.cssnano() )
		.pipe( $.rename( { suffix: ".min" } ) )
		.pipe( $.sourcemaps.write( ".", { sourceRoot: null } ) )
		.pipe( gulp.dest( "public/admin/dist/styles" ) )
		.pipe( browserSync.stream( { match: "**/*.css" } ) );
};

// JS
var scripts_vendor_admin = function() {
	return gulp.src( vendorScripts )
		.pipe( $.sourcemaps.init() )
		.pipe( $.concat( "vendor.js" ) )
		.pipe( $.uglify() )
		.pipe( $.rename( { suffix: ".min" } ) )
		.pipe( $.sourcemaps.write( "." ) )
		.pipe( gulp.dest( "public/admin/dist/scripts" ) );
};

var scripts_admin = function() {

	return gulp.src( applicationScripts )
		.pipe( $.sourcemaps.init() )
		.pipe( $.concat( "application.js" ) )
		.pipe( $.uglify() )
		.pipe( $.rename( { suffix: ".min" } ) )
		.pipe( $.sourcemaps.write( "." ) )
		.pipe( gulp.dest( "public/admin/dist/scripts" ) );
};

// Lint
var lint_admin = function() {
	return gulp.src( [ "public/admin/scripts/**/*.js", "gulpfile-admin.js" ] )
		.pipe( $.eslint() )
		.pipe( $.eslint.format() )
		.pipe( $.eslint.failAfterError() );
};

// Copy
var copy_admin = function( done ) {
	gulp.src( "node_modules/html5shiv/dist/html5shiv.min.js" )
		.pipe( gulp.dest( "public/admin/dist/scripts" ) );
	gulp.src( "node_modules/respond.js/dest/respond.min.js" )
		.pipe( gulp.dest( "public/admin/dist/scripts" ) );
	gulp.src( "node_modules/@fortawesome/fontawesome-free/webfonts/*" )
		.pipe( gulp.dest( "public/admin/dist/webfonts" ) );
	gulp.src( "node_modules/jquery-ui-bundle/images/*" )
		.pipe( gulp.dest( "public/admin/dist/styles/images" ) );
	gulp.src( "public/admin/fonts/*" )
		.pipe( gulp.dest( "public/admin/dist/fonts" ) );
	gulp.src( "public/admin/images/*" )
		.pipe( gulp.dest( "public/admin/dist/images" ) );
	gulp.src( "node_modules/ace-builds/src-min/**" )
		.pipe( gulp.dest( "public/admin/dist/scripts/ace" ) );
	done();
};

// Clean
var clean_admin = function( done ) {
	del.sync( "public/admin/dist" );
	done();
};

// Server
var serve_admin = function() {
	browserSync.init( {
		proxy: "localhost:8000/admin/"
	} );

	// If these files change = reload browser
	gulp.watch( [
		"app/**/*.tpl",
		"public/admin/images/**/*"
	] ).on( "change", browserSync.reload );

	// If javascript files change = run 'scripts' task, then reload browser
	gulp.watch( "public/admin/scripts/**/*.js", scripts_admin )
		.on( "change", browserSync.reload );

	// If styles files change = run 'styles' task with style injection
	gulp.watch( "public/admin/styles/**/*.scss", styles_admin );
};

// Get size after build
var afterbuild_admin = function(){
	return gulp.src( "public/admin/dist/**/*" )
		.pipe( $.size( { title: "build", gzip: true } ) );
}

// Build
var build_admin = series( parallel( lint_admin, styles_admin, styles_vendor_admin, styles_from_frontend, scripts_vendor_admin, scripts_admin, copy_admin ), afterbuild_admin );

// Export public tasks
exports.styles_admin = styles_admin;
exports.styles_vendor_admin = styles_vendor_admin;
exports.styles_from_frontend = styles_from_frontend;
exports.scripts_admin = scripts_admin;
exports.scripts_vendor_admin = scripts_vendor_admin;
exports.lint_admin = lint_admin;
exports.copy_admin = copy_admin;
exports.clean_admin = clean_admin;
exports.serve_admin = series( styles_admin, serve_admin );
exports.build_admin = build_admin;
exports.admin = series( clean_admin, build_admin );
