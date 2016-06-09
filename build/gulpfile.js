var gulp = require('gulp');
var util = require('gulp-util');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var uglify = require('gulp-uglifyjs');
var rename = require('gulp-rename');
var fs = require("fs");

/*
 * Default task to provide help on available tasks
 */
gulp.task('default', function() {
    console.log('Welcome to the ARK 2 build system!');
    console.log('Available tasks via "npm run <task>"');
    console.log('  "build" - Build and install all assets');
    console.log('  "fonts" - Build and install just fonts');
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
        config.vendorDir + '/jquery/dist/jquery.min.js',
        config.bootstrapDir + '/javascripts/bootstrap.js',
    ];
    var dest = config.rootDir + '/themes/' + theme + '/scripts';
    var conf = {
        compress: false,
        outSourceMap: true,
    }
    return gulp.src(src)
               .pipe(uglify('ark.min.js', conf))
               .pipe(gulp.dest(dest));
});

/*
 * Task to compile required Sass templates into single minified CSS file
 */
gulp.task('css', function() {
    var theme = (util.env.theme || 'default');
    var src = './assets/' + theme + '/scss/ark.scss';
    var dest = config.rootDir + '/themes/' + theme + '/styles';
    var mapsConf = {
        loadMaps: true,
    }
    var sassConf = {
        outputStyle: 'compressed',
        includePaths: [config.bootstrapDir + '/stylesheets'],
        precision: 8,
    }
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
    }
    return gulp.src(src)
               .pipe(sourcemaps.init(mapsConf))
               .pipe(sass(sassConf).on('error', sass.logError))
               .pipe(autoprefixer(prefixConf))
               .pipe(rename('ark.min.css'))
               .pipe(sourcemaps.write('.'))
               .pipe(gulp.dest(dest));
});

/*
 * Task to build and install theme, i.e. fonts, js, css, and templates
 */
gulp.task('build', ['fonts', 'js', 'css', 'twig']);
