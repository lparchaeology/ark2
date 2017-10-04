/*
 * ARK2 Frontend Build Script
 * Run via npm scripts or Build Console
 */

var gulp = require('gulp');
var util = require('gulp-util');
var rename = require('gulp-rename');
var fs = require('fs-extra');
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
    //'scripts',
    //'styles',
];

var buildTasks = baseTasks.concat(assetTasks, ['scripts', 'styles']);

/*
 * Return Frontend Source Path
 */
function frontendSourcePath() {
    return 'frontends/' + util.env.frontend;
}

/*
 * Return Frontend Manifest Path
 */
function frontendManifestPath() {
    return frontendSourcePath() + '/manifest.json';
}

/*
 * Return Frontend Manifest
 */
function frontendManifest() {
    return JSON.parse(fs.readFileSync(frontendManifestPath()));
}

/*
 * Return Frontend Destination Path
 */
function frontendDestPath(manifest) {
    return '../src/' + manifest.namespace + '/frontend/' + manifest.frontend;
}

/*
 * Task to install required files into the frontend
 */
function copyFiles(src, dest) {
    return gulp.src(src).pipe(gulp.dest(dest));
}

/*
 * Return Prefixed Paths
 */
function prefixPaths(prefix, paths) {
    var prefixed = [];
    for (var path in paths) {
        prefixed.push(prefix + paths[path]);
    }
    return prefixed;
}

/*
 * Return Destination Path
 */
function mergePaths(frontend, paths) {
    var prefixed = prefixPaths('node_modules/', paths.vendor);
    prefixed = prefixed.concat(prefixPaths('core/', paths.core));
    prefixed = prefixed.concat(prefixPaths('frontends/' + frontend + '/', paths.custom));
    return prefixed;
}

/*
 * Task to install required files into the frontend
 */
function installFiles(group) {
    var manifest = frontendManifest();
    var src = mergePaths(manifest.frontend, manifest[group]);
    var dest = frontendDestPath(manifest) + '/' + group;
    fs.removeSync(dest);
    return copyFiles(src, dest);
}

/*
 * Task to install required files into the frontend
 */
function installAssets(group) {
    var manifest = frontendManifest();
    var dest = frontendDestPath(manifest) + '/assets/' + group;
    fs.removeSync(dest);
    var sub = '';
    for (sub in manifest.assets[group].vendor) {
        copyFiles(prefixPaths('node_modules/', manifest.assets[group].vendor[sub]), dest + '/' + sub);
    }
    for (sub in manifest.assets[group].core) {
        copyFiles(prefixPaths('core/', manifest.assets[group].core[sub]), dest + '/' + sub);
    }
    for (sub in manifest.assets[group].custom) {
        copyFiles(prefixPaths('frontends/' + manifest.frontend + '/', manifest.assets[group].custom[sub]), dest + '/' + sub);
    }
    return util.noop();
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
    var manifest = {};
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
    copyFiles('core/scss/**/*', dest + '/scss');
    fs.mkdirSync(dest + '/twig');
    fs.mkdirSync(dest + '/twig/blocks');
    fs.mkdirSync(dest + '/twig/errors');
    fs.mkdirSync(dest + '/twig/layouts');
    fs.mkdirSync(dest + '/twig/pages');
    fs.mkdirSync(dest + '/twig/user');

    manifest = JSON.parse(fs.readFileSync('core/manifest.json'));
    manifest.frontend = util.env.frontend;
    manifest.namespace = util.env.namespace || 'ARK';
    fs.writeFileSync(frontendManifestPath(), JSON.stringify(manifest, null, 4));

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

    var manifest = frontendManifest();
    var src = [];
    var dest = frontendDestPath(manifest) + '/assets/scripts';
    var script = '';

    for (script in manifest.assets.scripts) {
        src = mergePaths(manifest.frontend, manifest.assets.scripts[script]);
        gulp.src(src)
            .pipe(concat(script + '.js'))
            .pipe(sourcemaps.init(manifest.options.sourcemaps))
            .pipe(uglify(manifest.options.uglify))
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
    var streams = require('merge-stream')();

    var manifest = frontendManifest();
    var src = [];
    var dest = frontendDestPath(manifest) + '/assets/styles';
    var style = '';
    var stream = {};

    for (style in manifest.assets.styles) {
        for (var i in manifest.assets.styles[style]) {
            stream = manifest.assets.styles[style][i];
            src = src.concat(mergePaths(manifest.frontend, stream));
        }
        // FIXME Sourcemaps are broken, see https://github.com/sass/libsass/issues/2312
        streams.add(
            gulp.src(src)
            //.pipe(sourcemaps.init(manifest.options.sourcemaps))
            .pipe(sass(manifest.options.sass).on('error', sass.logError))
            .pipe(concat(style + '.min.css'))
            .pipe(autoprefixer(manifest.options.autoprefixer))
            //.pipe(sourcemaps.write('.'))
            .pipe(gulp.dest(dest))
        );
    }

    return util.noop();
});

/*
 * Task to build and install frontend, i.e. fonts, js, css, and templates
 */
gulp.task('base', baseTasks);
gulp.task('assets', assetTasks);
gulp.task('build', buildTasks);
