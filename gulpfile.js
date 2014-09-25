'use strict';

var gulp = require('gulp'),
    del = require('del'),
    plumber = require('gulp-plumber'),
    sourcemaps = require('gulp-sourcemaps'),
    sass = require('gulp-sass'),
    postcss = require('gulp-postcss'),
    autoprefixer = require('autoprefixer-core'),
    csswring = require('csswring'),
    concat = require('gulp-concat'),
    flatten = require('gulp-flatten'),
    reduce = require('gulp-reduce-file'),
    uglify = require('gulp-uglify'),
    replace = require('gulp-replace'),
    iff = require('gulp-if'),
    browsersync = require('browser-sync'),
    reload = browsersync.reload.bind(null, {stream: true}),
    glob = require('glob'),
    browserify = require('browserify'),
    source = require('vinyl-source-stream'),
    buffer = require('vinyl-buffer');

var argv = require('yargs').argv,
    pkg = require('./package.json');


function watch(glob, tasks) {
  var w = require('gulp-watch'),
      batch = require('gulp-batch');
  w(glob, {verbose: true}, batch(function (events, cb) {
    gulp.start(tasks, cb);
  }));
}

function version() {
  var v = pkg.version || '0.1';
  return replace('{{ version }}', v);
}


gulp.task('build', ['theme', 'functions', 'assets']);

gulp.task('clean', function (cb) {
  del(['dist'], cb);
});


gulp.task('theme', function () {
  return gulp.src(['meta/**/*', 'theme/**/*.php'])
    .pipe(iff('**/*.{css,php}', version()))
    .pipe(gulp.dest('dist'))
    .pipe(reload());
});

gulp.task('functions', function () {
  function collect(file, memo) {
    return memo.concat(file.relative);
  }
  function output(memo) {
    return memo.reduce(function (str, filename) {
        return str + "require 'lib/" + filename + "';\n";
    }, '<?php\n');
  }
  return gulp.src('functions/*.php')
    .pipe(version())
    .pipe(gulp.dest('dist/lib'))
    .pipe(reduce('functions.php', collect, output, []))
    .pipe(gulp.dest('dist'))
    .pipe(reload());
});

gulp.task('assets', ['styles', 'scripts', 'images']);

gulp.task('styles', function () {
  return gulp.src(['blocks/util/**/*.scss', 'blocks/main/**/*.scss'])
    .pipe(sourcemaps.init())
    .pipe(sass({errLogToConsole: true, precision: 10}))
    .pipe(concat('styles.css'))
    .pipe(postcss([
      autoprefixer(),
      csswring({removeAllComments: true})
    ]))
    .pipe(iff(!argv.production, sourcemaps.write()))
    .pipe(gulp.dest('dist/assets'))
    .pipe(reload());
});

gulp.task('scripts', function () {
  var entries = [].concat(
    glob.sync('./blocks/util/**/*.js'),
    glob.sync('./blocks/main/**/*.js')
  );
  return browserify({
      entries: entries,
      debug: true
    })
    .transform('babelify')
    .plugin('bundle-collapser/plugin')
    .bundle()
    .pipe(source('bundle.js'))
    .pipe(buffer())
    .pipe(sourcemaps.init({loadMaps: true}))
    .pipe(uglify())
    .pipe(iff(!argv.production, sourcemaps.write()))
    .pipe(gulp.dest('dist/assets'))
    .pipe(reload());
});

gulp.task('images', function () {
  return gulp.src(['blocks/util/**/*.{jpg,png}', 'blocks/main/**/*.{jpg,png}'])
    .pipe(flatten())
    .pipe(gulp.dest('dist/assets'))
    .pipe(reload());
});


gulp.task('serve', ['watch'], function (cb) {
  browsersync({
    proxy: 'localhost:8080',
    open: false
  }, cb);
});

gulp.task('watch', ['build'], function () {
  watch(['meta/**/*', 'theme/**/*'], ['theme']);
  watch(['functions/**/*'], ['functions']);
  watch(['blocks/**/*.scss'], ['styles']);
  watch(['blocks/**/*.js'], ['scripts']);
  watch(['blocks/**/*.{jpg,png}'], ['images']);
});


gulp.task('default', ['build']);
