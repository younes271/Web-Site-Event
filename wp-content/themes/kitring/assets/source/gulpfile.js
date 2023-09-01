var gulp = require('gulp');
var $ = require('gulp-load-plugins')();
var cleanCSS = require("gulp-clean-css");
var rename   = require("gulp-rename");
var minify   = require('gulp-minify');


var sassPaths = [
  'bower_components/normalize.scss/sass',
  'bower_components/foundation-sites/scss',
  'bower_components/motion-ui/src'
];

gulp.task('sass', function () {
  return gulp.src('scss/app.scss')
    .pipe($.sass({
        includePaths: sassPaths,
        outputStyle: 'expanded' // if css compressed **file size**
      })
      .on('error', $.sass.logError))
    .pipe($.autoprefixer({
      browsers: ['last 2 versions', 'ie >= 9']
    }))
    .pipe(gulp.dest('../dist/css/'));
});

gulp.task('sass-minify', ['sass'], function () {
	return gulp.src('../dist/css/app.css')
		.pipe(cleanCSS({ compatibility: 'ie9' }))
		.pipe(rename('app.min.css'))
		.pipe(gulp.dest('../dist/css/'));
});

gulp.task('default', ['sass', 'sass-minify'], function () {
  gulp.watch(['scss/**/*.scss'], ['sass']);
  gulp.watch(['scss/**/*.scss'], ['sass-minify']);
  gulp.watch(['scss/**/**/*.scss'], ['sass']);
  gulp.watch(['scss/**/**/*.scss'], ['sass-minify']);
  gulp.watch(['../../dahz-modules/**/assets/scss/**/*.scss'], ['sass']);
  gulp.watch(['../../dahz-modules/**/assets/scss/**/*.scss'], ['sass-minify']);
  gulp.watch(['../../dahz-modules/**/assets/scss/*.scss'], ['sass']);
  gulp.watch(['../../dahz-modules/**/assets/scss/*.scss'], ['sass-minify']);
});
