var gulp = require('gulp');
var wait = require('gulp-wait');
var pug = require('gulp-pug');
var rename = require('gulp-rename');
var sass = require('gulp-sass');
var cssmin = require('gulp-cssmin');
var sourcemaps = require('gulp-sourcemaps');
var notify = require("gulp-notify");
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var browserSync = require('browser-sync').create();
var perfectionist = require('perfectionist');
var plumber = require('gulp-plumber');
var postcss = require('gulp-postcss');
var cssdeclsort = require('css-declaration-sorter');
var autoprefixer = require('gulp-autoprefixer');
var htmlmin = require('gulp-htmlmin');
let cleanCSS = require('gulp-clean-css');


function myJavascript(cb) {
  return gulp.src([ './sjs/plugins/*.js', './sjs/scripts.js'])
    .pipe(plumber({
      errorHandler: notify.onError("Error: <%= error.message %>")
    }))
    .pipe(concat('scripts.js'))
    .pipe(uglify())
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest('./js/'))
    .pipe(browserSync.stream())
}

function singleJavascript(cb) {
  return gulp.src(['./sjs/pages/*.js'])
    .pipe(plumber({
      errorHandler: notify.onError("Error: <%= error.message %>")
    }))
    .pipe(uglify())
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest('./js/'))
    .pipe(browserSync.stream())
}

// function includesJavascript(cb) {
//   return gulp.src(['./sjs/add-ons/*.js'])
//     .pipe(plumber({
//       errorHandler: notify.onError("Error: <%= error.message %>")
//     }))
//     .pipe(uglify())
//     .pipe(rename({
//       suffix: '.min'
//     }))
//     .pipe(gulp.dest('./js/add-ons/'))
//     .pipe(browserSync.stream())
// }

function myCss(cb) {
  return gulp.src(['./scss/style.scss', './scss/pages/*.scss','./scss/add-ons/*.scss'])
    .pipe(wait(500))
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(plumber({
      errorHandler: notify.onError("Error: <%= error.message %>")
    }))
    // .pipe(sass({
    //   outputStyle: 'compressed'
    // }))
    // .pipe(cssmin())
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(cleanCSS({
      debug: true
    }, (details) => {
      console.log(`${details.name}: ${details.stats.originalSize}`);
      console.log(`${details.name}: ${details.stats.minifiedSize}`);
    }))
    .pipe(sourcemaps.write('./maps'))
    .pipe(gulp.dest('./css/'))
    .pipe(browserSync.stream());
}

function myCssAddOns(cb) {
  return gulp.src(['./scss/add-ons/*.scss'])
    .pipe(wait(500))
    .pipe(plumber({
      errorHandler: notify.onError("Error: <%= error.message %>")
    }))
    .pipe(sass({
      outputStyle: 'compressed'
    }))
    .pipe(cssmin())
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(cleanCSS({
      debug: true
    }, (details) => {
      console.log(`${details.name}: ${details.stats.originalSize}`);
      console.log(`${details.name}: ${details.stats.minifiedSize}`);
    }))
    .pipe(gulp.dest('./css/add-ons/'))
    .pipe(browserSync.stream())
}

// BrowserSync
function serveSync(done) {
  browserSync.init({
      open: false,
      host: 'shynhpremium.localhost',
      proxy: 'shynhpremium.localhost',
      port: 8080 // for work mamp
  });
  done();
}

// BrowserSync Reload
function serveReload(done) {
  browserSync.reload();
  done();
}


function myWatch() {
  //gulp.watch('scss/**/*',  gulp.series(myCss,myCssAddOns));
  gulp.watch('scss/**/*',  gulp.series(myCss));
  gulp.watch('sjs/**/*', gulp.series(myJavascript));
  gulp.watch("sjs/**/*", gulp.series(singleJavascript));
  //gulp.watch("sjs/**/*", gulp.series(includesJavascript));
  gulp.watch(
    [
      // './sjs/**/*',
      // './scss/**/*',
      // './scss/add-ons/*',
      './pug/**/*',
      "./**/*.php",
      "./*.html",
    ],
    gulp.series(serveReload)
  );
}

const build = gulp.series(gulp.parallel( myJavascript,singleJavascript,myCss,myCssAddOns));
const watch = gulp.parallel(build, myWatch, serveSync);
gulp.task('default', watch);
// exports.default = watch