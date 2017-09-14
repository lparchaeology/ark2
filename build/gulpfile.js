/*
 * ARK2 Frontend Build Script
 * Run via npm scripts or Build Console
 */

var gulp = require('gulp');
var util = require('gulp-util');
var rename = require('gulp-rename');
var fs = require('fs');
var concat = require('gulp-concat');

var baseTasks = [
    'bin',
    'config',
    'templates',
    'translations',
    'web',
];

var assetTasks = [
    'fonts',
    'images',
    'scripts',
    'styles',
];

var buildTasks = baseTasks.concat(assetTasks);

/*
 * Return Frontend Source Path
 */
function frontendSourcePath() {
    return 'frontends/' + util.env.frontend;
}

/*
 * Return Frontend Config Path
 */
function frontendConfigPath() {
    return frontendSourcePath() + '/config.json';
}

/*
 * Return Frontend Config
 */
function frontendConfig() {
    return JSON.parse(fs.readFileSync(frontendConfigPath()));
}

/*
 * Return Frontend Destination Path
 */
function frontendDestPath(config) {
    return '../src/' + config.namespace + '/frontend/' + config.frontend;
}

/*
 * Return Destination Path
 */
function mergePaths(frontend, paths) {
    var prefixed = [];
    var path = '';
    for (path in paths.vendor) {
        prefixed.push('node_modules/' + paths.vendor[path]);
    }
    for (path in paths.core) {
        prefixed.push('core/' + paths.core[path]);
    }
    for (path in paths.custom) {
        prefixed.push('frontends/' + frontend + '/' + paths.custom[path]);
    }
    return prefixed;
}

/*
 * Task to install required files into the frontend
 */
function installFiles(group) {
    var config = frontendConfig();
    var src = mergePaths(config.frontend, config[group]);
    var dest = frontendDestPath(config) + '/' + group;
    return gulp.src(src)
        .pipe(gulp.dest(dest));
}

/*
 * Task to install required files into the frontend
 */
function installAssets(group) {
    var config = frontendConfig();
    var src = mergePaths(config.frontend, config.assets[group]);
    var dest = frontendDestPath(config) + '/assets/' + group;
    return gulp.src(src)
        .pipe(gulp.dest(dest));
}

/*
 * core task to provide help on available tasks
 */
gulp.task('core', function () {
    console.log('Welcome to the ARK 2 build system!');
    console.log('Available tasks via "npm run <task>"');
    console.log('  "create" - Create a new Frontend');
    console.log('  "build" - Build the Frontend');
    console.log('  "base" - Build just Frontend base');
    console.log('  "assets" - Build just Frontend assets');
    console.log('  "bin" - Build just bin directory');
    console.log('  "config" - Build just config directory');
    console.log('  "web" - Build just web directory');
    console.log('  "translations" - Build just translations');
    console.log('  "fonts" - Build just font assets');
    console.log('  "images" - Build just image assets');
    console.log('  "scripts" - Build just script assets');
    console.log('  "styles" - Build just style assets');
});

/*
 * Task to create new frontend
 */
gulp.task('create', function () {
    var config = {};
    var dest = frontendSourcePath();

    try {
        fs.statSync(dest);
        util.log('Frontend already exists!');
        return util.noop();
    } catch (e) {
        util.noop();
    }

    fs.mkdirSync(dest);
    fs.mkdirSync(dest + '/images');
    fs.mkdirSync(dest + '/images/brand');
    fs.mkdirSync(dest + '/images/icons');
    fs.mkdirSync(dest + '/js');
    gulp.src('core/scss/**/*')
        .pipe(gulp.dest(dest + '/scss'));
    fs.mkdirSync(dest + '/twig');
    fs.mkdirSync(dest + '/twig/blocks');
    fs.mkdirSync(dest + '/twig/errors');
    fs.mkdirSync(dest + '/twig/layouts');
    fs.mkdirSync(dest + '/twig/pages');
    fs.mkdirSync(dest + '/twig/user');

    config = JSON.parse(fs.readFileSync('core/config.json'));
    config.frontend = util.env.frontend;
    config.namespace = util.env.namespace || 'ARK';
    fs.writeFileSync(frontendConfigPath(), JSON.stringify(config, null, 4));

    return util.noop();
});

/*
 * Task to install required bin files into the frontend
 */
gulp.task('bin', function () {
    return installFiles('bin');
});

/*
 * Task to install required config files into the frontend
 */
gulp.task('config', function () {
    return installFiles('config');
});

/*
 * Task to install required twig templates into the frontend
 */
gulp.task('templates', function () {
    return installFiles('templates');
});

/*
 * Task to install required xliff files into the frontend
 */
gulp.task('translations', function () {
    return installFiles('translations');
});

/*
 * Task to install required web files into the frontend
 */
gulp.task('web', function () {
    return installFiles('web');
});

/*
 * Task to install required fonts into the frontend
 */
gulp.task('fonts', function () {
    return installAssets('fonts');
});

/*
 * Task to install required images into the frontend
 */
gulp.task('images', function () {
    return installAssets('images');
});

/*
 * Task to compile required js into single minified js file
 */
gulp.task('scripts', function () {
    var sourcemaps = require('gulp-sourcemaps');
    var uglify = require('gulp-uglify');

    var config = frontendConfig();
    var src = [];
    var dest = frontendDestPath(config) + '/assets/scripts';
    var script = '';

    for (script in config.assets.scripts) {
        src = mergePaths(config.frontend, config.assets.scripts[script]);
        gulp.src(src)
            .pipe(concat(script + '.js'))
            .pipe(sourcemaps.init(config.options.sourcemaps))
            .pipe(uglify(config.options.uglify))
            .pipe(sourcemaps.write('.'))
            .pipe(rename(script + '.min.js'))
            .pipe(gulp.dest(dest));
    }
    return util.noop();
});

/*
 * Task to compile required CSS Sass templates into single minified CSS file
 */
gulp.task('styles', function () {
    var sass = require('gulp-sass');
    var autoprefixer = require('gulp-autoprefixer');
    var sourcemaps = require('gulp-sourcemaps');

    var config = frontendConfig();
    var streams = require('merge-stream')();
    var src = [];
    var dest = frontendDestPath(config) + '/assets/styles';
    var style = '';
    var stream = {};

    for (style in config.assets.styles) {
        for (var i in config.assets.styles[style]) {
            stream = config.assets.styles[style][i];
            if (stream.format === 'sass') {
                src = frontendSourcePath() + '/' + stream.src;
                config.options.sass.includePaths = mergePaths(config.frontend, stream);
                streams.add(
                    gulp.src(src)
                    //.pipe(sourcemaps.init(config.options.sourcemaps))
                    .pipe(sass(config.options.sass).on('error', sass.logError))
                );
            } else if (stream.format === 'css') {
                src = mergePaths(config.frontend, stream);
                streams.add(
                    gulp.src(src)
                    .pipe(concat(stream.stream + '.css'))
                );
            }
        }
        streams.pipe(concat(style + '.min.css'))
            .pipe(autoprefixer(config.options.autoprefixer))
            //.pipe(sourcemaps.write('.'))
            .pipe(gulp.dest(dest));
    }

    return util.noop();
});

/*
 * Task to build and install frontend, i.e. fonts, js, css, and templates
 */
gulp.task('base', baseTasks);
gulp.task('assets', assetTasks);
gulp.task('build', buildTasks);
