let gulp = require('gulp');
let sass = require('gulp-sass');

gulp.task('sass', () => {
    return gulp.src(['./recources/**/*.scss'])
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./public/css'));
});

gulp.task('sass:watch', () => {
    gulp.watch('./recources/**/*.scss', ['sass']);
});