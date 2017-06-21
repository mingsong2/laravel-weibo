var gulp = require('gulp');
var sass = require('gulp-sass');
var watch = require('gulp-watch');

gulp.task('default', function() {
    return gulp.src('resources/assets/sass/*.scss')
        .pipe(watch('resources/assets/sass/*.scss'))
        .pipe(sass())
        .pipe(gulp.dest('public/css'));
});