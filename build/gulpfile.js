var gulp = require('gulp');
var util = require('gulp-util');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var uglify = require('gulp-uglifyjs');
var rename = require('gulp-rename');
var fs = require("fs");
var merge = require('merge-stream');
var concat = require('gulp-concat');

/*
 * core task to provide help on available tasks
 */
gulp.task('core', function() {
    console.log('Welcome to the ARK 2 build system!');
    console.log('Available tasks via "npm run <task>"');
    console.log('  "create" - Create a new Frontend');
    console.log('  "build" - Build all Frontend assets');
    console.log('  "web" - Build just web directory');
    console.log('  "config" - Build just config');
    console.log('  "fonts" - Build just fonts');
    console.log('  "images" - Build just images');
    console.log('  "js" - Build just javascript');
    console.log('  "css" - Build just css');
    console.log('  "xliff" - Build just xliff');
    console.log('  "bin" - Build just bin directory');
});

var config = {
    frontendsDir: './frontends',
    srcDir: '../src',
    vendorDir: './vendor',
    bootstrapDir: './vendor/bootstrap-sass/assets',
};

/*
 * Task to create new frontend
 */
gulp.task('create', function() {
    var frontend = (util.env.frontend || 'core');
    var src = [config.frontendsDir + '/core/**/*', config.frontendsDir + '/core/**/.*'];
    var dest = config.frontendsDir + '/' + frontend;
    try {
        fs.statSync(dest);
        util.log('Frontend already exists!');
        return util.noop();
    } catch(e) {
        return gulp.src(src)
                   .pipe(gulp.dest(dest));
    }
});

/*
 * Task to install required web files into the frontend
 */
gulp.task('web', function() {
    var frontend = (util.env.frontend || 'core');
    var namespace = (util.env.namespace || 'ARK');
    var src = [config.frontendsDir + '/' + frontend + '/web/**/*', config.frontendsDir + '/' + frontend + '/web/**/.*'];
    var dest = config.srcDir + '/' + namespace + '/frontend/' + frontend + '/web';
    return gulp.src(src)
               .pipe(gulp.dest(dest));
});

/*
 * Task to install required config files into the frontend
 */
gulp.task('config', function() {
    var frontend = (util.env.frontend || 'core');
    var namespace = (util.env.namespace || 'ARK');
    var src = config.frontendsDir + '/' + frontend + '/config/**/*';
    var dest = config.srcDir + '/' + namespace + '/frontend/' + frontend + '/config';
    return gulp.src([src])
               .pipe(gulp.dest(dest));
});

/*
 * Task to install required config files into the frontend
 */
gulp.task('bin', function() {
    var frontend = (util.env.frontend || 'core');
    var namespace = (util.env.namespace || 'ARK');
    var src = config.frontendsDir + '/' + frontend + '/bin/**/*';
    var dest = config.srcDir + '/' + namespace + '/frontend/' + frontend + '/bin';
    return gulp.src([src])
               .pipe(gulp.dest(dest));
});

/*
 * Task to install required xliff files into the frontend
 */
gulp.task('xliff', function() {
    var frontend = (util.env.frontend || 'core');
    var namespace = (util.env.namespace || 'ARK');
    var src = config.frontendsDir + '/' + frontend + '/xliff/**/*';
    var dest = config.srcDir + '/' + namespace + '/frontend/' + frontend + '/translations';
    return gulp.src([src])
               .pipe(gulp.dest(dest));
});

/*
 * Task to install required fonts into the frontend
 */
gulp.task('fonts', function() {
    var frontend = (util.env.frontend || 'core');
    var namespace = (util.env.namespace || 'ARK');
    var src = [
        config.bootstrapDir + '/fonts/**/*',
        config.vendorDir + '/summernote/dist/font/**/*'
    ];
    var dest = config.srcDir + '/' + namespace + '/frontend/' + frontend + '/assets/fonts';
    return gulp.src(src)
               .pipe(gulp.dest(dest));
});

/*
 * Task to install required images into the frontend
 */
gulp.task('images', function() {
    var frontend = (util.env.frontend || 'core');
    var namespace = (util.env.namespace || 'ARK');
    var src = [
        config.vendorDir + '/x-editable/dist/bootstrap3-editable/img/**/*',
        config.vendorDir + '/bootstrap-fileinput/img/**/*',
        config.frontendsDir + '/' + frontend + '/images/**/*',
    ];
    var dest = config.srcDir + '/' + namespace + '/frontend/' + frontend + '/assets/images';
    return gulp.src(src)
               .pipe(gulp.dest(dest));
});

/*
 * Task to install required twig templates into the frontend
 */
gulp.task('twig', function() {
    var frontend = (util.env.frontend || 'core');
    var namespace = (util.env.namespace || 'ARK');
    var src = config.frontendsDir + '/' + frontend + '/twig/**/*';
    var dest = config.srcDir + '/' + namespace + '/frontend/' + frontend + '/templates';
    return gulp.src([src])
               .pipe(gulp.dest(dest));
});

/*
 * Task to compile required js into single minified js file
 */
gulp.task('js', function() {
    var frontend = (util.env.frontend || 'core');
    var namespace = (util.env.namespace || 'ARK');
    var src = [
        config.vendorDir + '/jquery/dist/jquery.js',
        config.bootstrapDir + '/javascripts/bootstrap.js',
        config.vendorDir + '/summernote/dist/summernote.js',
        config.vendorDir + '/select2/dist/js/select2.js',
        config.vendorDir + '/file-saver.js/FileSaver.js',
        config.vendorDir + '/tableExport.jquery.plugin/tableExport.min.js',
        config.vendorDir + '/col-resizable/colResizable-1.6.js',
        config.vendorDir + '/moment/moment.js',
        config.vendorDir + '/bootstrap-fileinput/js/plugins/canvas-to-blob.js',
        config.vendorDir + '/bootstrap-fileinput/js/plugins/purify.js',
        config.vendorDir + '/bootstrap-fileinput/js/plugins/sortable.js',
        config.vendorDir + '/bootstrap-fileinput/js/fileinput.js',
        config.vendorDir + '/bootstrap-fileinput/js/fileinput.js',
        config.vendorDir + '/bootstrap-fileinput/themes/gly/theme.js',
        config.vendorDir + '/smalot-bootstrap-datetimepicker/js/bootstrap-datetimepicker.js',
        config.vendorDir + '/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.js',
        config.vendorDir + '/bootstrap-table/dist/bootstrap-table.js',
        config.vendorDir + '/bootstrap-table/dist/extensions/accent-neutralise/bootstrap-table-accent-neutralise.js',
        config.vendorDir + '/bootstrap-table/dist/extensions/cookie/bootstrap-table-cookie.js',
        config.vendorDir + '/bootstrap-table/dist/extensions/copy-rows/bootstrap-table-copy-rows.js',
        config.vendorDir + '/bootstrap-table/dist/extensions/editable/bootstrap-table-editable.js',
        config.vendorDir + '/bootstrap-table/dist/extensions/export/bootstrap-table-export.js',
        config.vendorDir + '/bootstrap-table/dist/extensions/flat-json/bootstrap-table-flat-json.js',
        config.vendorDir + '/bootstrap-table/dist/extensions/multiple-search/bootstrap-table-multiple-search.js',
        config.vendorDir + '/bootstrap-table/dist/extensions/multiple-sort/bootstrap-table-multiple-sort.js',
        config.vendorDir + '/bootstrap-table/dist/extensions/natural-sorting/bootstrap-table-natural-sorting.js',
        config.vendorDir + '/bootstrap-table/dist/extensions/resizeable/bootstrap-table-resizeable.js',
        config.vendorDir + '/bootstrap-table/dist/extensions/select2-filter/bootstrap-table-select2-filter.js',
        config.vendorDir + '/bootstrap-table/dist/extensions/sticky-header/bootstrap-table-sticky-header.js',
        config.vendorDir + '/proj4/dist/proj4.js',
        config.frontendsDir + '/' + frontend + '/js/**/*'
    ];
    var dest = config.srcDir + '/' + namespace + '/frontend/' + frontend + '/assets/scripts';
    var conf = {
        compress: false,
        outSourceMap: true,
    };
    return gulp.src(src)
               .pipe(concat('ark.js'))
               .pipe(uglify('ark.min.js', conf))
               .pipe(gulp.dest(dest));
});

/*
 * Task to compile required Sass templates into single minified CSS file
 */
gulp.task('css', function() {
    var frontend = (util.env.frontend || 'core');
    var namespace = (util.env.namespace || 'ARK');
    var cssSrc = [
        config.vendorDir + '/summernote/dist/summernote.css',
        config.vendorDir + '/select2/dist/css/select2.min.css',
    ];
    var sassSrc = [
        './frontends/' + frontend + '/scss/ark.scss',
    ];
    var bootCssSrc = [
        config.vendorDir + '/smalot-bootstrap-datetimepicker/css/bootstrap-datetimepicker.css',
        config.vendorDir + '/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css',
        config.vendorDir + '/bootstrap-table/dist/bootstrap-table.css',
        config.vendorDir + '/bootstrap-table/dist/extensions/sticky-header/bootstrap-table-sticky-header.css',
        config.vendorDir + '/select2-bootstrap-frontend/dist/select2-bootstrap.css',
        config.vendorDir + '/bootstrap-fileinput/css/fileinput.css',
    ];
    var dest = config.srcDir + '/' + namespace + '/frontend/' + frontend + '/assets/styles';
    var mapsConf = {
        loadMaps: true,
    };
    var sassConf = {
        outputStyle: 'compressed',
        includePaths: [config.bootstrapDir + '/stylesheets'],
        precision: 8,
    };
    var prefixConf = {
        // Bootstrap 3 supported browsers, see bootstrap-sass docs
        browsers: [
            "Android 2.3",
            "Android >= 4",
            "Chrome >= 20",
            "Firefox >= 24",
            "Explorer >= 8",
            "iOS >= 6",
            "Opera >= 12",
            "Safari >= 6"
        ]
    };
    var cssStream = gulp.src(cssSrc)
                        .pipe(concat('tmp.css'));

    var sassStream = gulp.src(sassSrc)
                         .pipe(sourcemaps.init(mapsConf))
                         .pipe(sass(sassConf).on('error', sass.logError));

    var bootCssStream = gulp.src(bootCssSrc)
                        .pipe(concat('boot.tmp.css'));

    return merge(cssStream, sassStream, bootCssStream)
            .pipe(concat('ark.min.css'))
            .pipe(autoprefixer(prefixConf))
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest(dest));
});

/*
 * Task to build and install frontend, i.e. fonts, js, css, and templates
 */
gulp.task('build', ['fonts', 'images', 'js', 'css', 'twig', 'xliff', 'web', 'config', 'bin']);
