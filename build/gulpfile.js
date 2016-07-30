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
 * Default task to provide help on available tasks
 */
gulp.task('default', function() {
    console.log('Welcome to the ARK 2 build system!');
    console.log('Available tasks via "npm run <task>"');
    console.log('  "build" - Build and install all assets');
    console.log('  "fonts" - Build and install just fonts');
    console.log('  "img" - Build and install just images');
    console.log('  "js" - Build and install just javascript');
    console.log('  "css" - Build and install just css');
});

var config = {
    assetsDir: './assets',
    rootDir: '../web',
    vendorDir: './vendor',
    bootstrapDir: './vendor/bootstrap-sass/assets',
};

/*
 * Task to create new theme
 */
gulp.task('create', function() {
    var theme = (util.env.theme || 'default');
    var src = config.assetsDir + '/default/**/*';
    var dest = config.assetsDir + '/' + theme;
    try {
        fs.statSync(dest);
        util.log('Theme already exists!');
        return util.noop();
    } catch(e) {
        return gulp.src([src])
                   .pipe(gulp.dest(dest));
    }
});

/*
 * Task to install required fonts into the theme
 */
gulp.task('fonts', function() {
    var theme = (util.env.theme || 'default');
    var src = config.bootstrapDir + '/fonts/**/*';
    var dest = config.rootDir + '/themes/' + theme + '/fonts';
    return gulp.src([src])
               .pipe(gulp.dest(dest));
});

/*
 * Task to install required images into the theme
 */
gulp.task('img', function() {
    var theme = (util.env.theme || 'default');
    var src = [
        config.vendorDir + '/x-editable/dist/bootstrap3-editable/img/**/*'
    ];
    var dest = config.rootDir + '/themes/' + theme + '/img';
    return gulp.src(src)
               .pipe(gulp.dest(dest));
});

/*
 * Task to install required twig templates into the theme
 */
gulp.task('twig', function() {
    var theme = (util.env.theme || 'default');
    var src = config.assetsDir + '/' + theme + '/twig/**/*';
    var dest = config.rootDir + '/themes/' + theme + '/templates';
    return gulp.src([src])
               .pipe(gulp.dest(dest));
});

/*
 * Task to compile required js into single minified js file
 */
gulp.task('js', function() {
    var theme = (util.env.theme || 'default');
    var src = [
        config.vendorDir + '/jquery/dist/jquery.js',
        config.bootstrapDir + '/javascripts/bootstrap.js',
        config.vendorDir + '/select2/dist/js/select2.js',
        config.vendorDir + '/file-saver.js/FileSaver.js',
        config.vendorDir + '/tableExport.jquery.plugin/tableExport.min.js',
        config.vendorDir + '/col-resizable/colResizable-1.6.js',
        config.vendorDir + '/moment/moment.js',
        config.vendorDir + '/smalot-bootstrap-datetimepicker/js/bootstrap-datetimepicker.js',
        config.vendorDir + '/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.js',
        config.vendorDir + '/bootstrap-table/dist/bootstrap-table.js',
        config.vendorDir + '/bootstrap-table/dist/extensions/accent-neutralise/bootstrap-table-accent-neutralise.js',
        config.vendorDir + '/bootstrap-table/dist/extensions/cookie/bootstrap-table-cookie.js',
        config.vendorDir + '/bootstrap-table/dist/extensions/copy-rows/bootstrap-table-copy-rows.js',
        config.vendorDir + '/bootstrap-table/dist/extensions/editable/bootstrap-table-editable.js',
        config.vendorDir + '/bootstrap-table/dist/extensions/export/bootstrap-table-export.js',
        config.vendorDir + '/bootstrap-table/dist/extensions/flat-json/bootstrap-table-flat-json.js',
        config.vendorDir + '/bootstrap-table/dist/extensions/mobile/bootstrap-table-mobile.js',
        config.vendorDir + '/bootstrap-table/dist/extensions/multiple-search/bootstrap-table-multiple-search.js',
        config.vendorDir + '/bootstrap-table/dist/extensions/multiple-sort/bootstrap-table-multiple-sort.js',
        config.vendorDir + '/bootstrap-table/dist/extensions/natural-sort/bootstrap-table-natural-sort.js',
        config.vendorDir + '/bootstrap-table/dist/extensions/resizeable/bootstrap-table-resizeable.js',
        config.vendorDir + '/bootstrap-table/dist/extensions/select2-filter/bootstrap-table-select2-filter.js',
        config.vendorDir + '/bootstrap-table/dist/extensions/sticky-header/bootstrap-table-sticky-header.js',
        config.assetsDir + '/' + theme + '/js/**/*'
    ];
    var dest = config.rootDir + '/themes/' + theme + '/scripts';
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
    var theme = (util.env.theme || 'default');
    var sassSrc = './assets/' + theme + '/scss/ark.scss';
    var cssSrc = [
        config.vendorDir + '/select2/dist/css/select2.min.css',
        config.vendorDir + '/select2-bootstrap-theme/dist/select2-bootstrap.min.css',
        config.vendorDir + '/smalot-bootstrap-datetimepicker/css/bootstrap-datetimepicker.css',
        config.vendorDir + '/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css',
        config.vendorDir + '/bootstrap-table/dist/extensions/sticky-header/bootstrap-table-sticky-header.css'
    ];
    var dest = config.rootDir + '/themes/' + theme + '/styles';
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
    var sassStream = gulp.src(sassSrc)
                         .pipe(sourcemaps.init(mapsConf))
                         .pipe(sass(sassConf).on('error', sass.logError));

    var cssStream = gulp.src(cssSrc)
                        .pipe(concat('tmp.css'));

    return merge(sassStream, cssStream)
            .pipe(concat('ark.min.css'))
            .pipe(autoprefixer(prefixConf))
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest(dest));
});

/*
 * Task to build and install theme, i.e. fonts, js, css, and templates
 */
gulp.task('build', ['fonts', 'img', 'js', 'css', 'twig']);
