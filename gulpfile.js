var gulp = require('gulp');
var sass = require('gulp-sass');
var watch = require('gulp-watch');
var elixir = require('laravel-elixir');



gulp.task('default', function() {
    elixir(function(mix) {
        mix.sass('app.scss')
            .browserify('app.js');
    });
    return gulp.src('resources/assets/sass/*.scss')
        .pipe(watch('resources/assets/sass/*.scss'))
        .pipe(sass())
        .pipe(gulp.dest('public/css'));
});