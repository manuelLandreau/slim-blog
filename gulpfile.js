let gulp = require('gulp');
let sass = require('gulp-sass');
let rename = require('gulp-rename');
let concat = require('gulp-concat');

gulp.task('sass', () => {
    return gulp.src([
        './resources/bootstrap/*.scss',
        './resources/views/**/*.scss'
    ])
        .pipe(sass({includePaths: 'node_modules/bootstrap-sass/assets/stylesheets/'})
            .on('error', sass.logError))
        .pipe(gulp.dest('./public/css'));
});
gulp.task('fonts', () => {
    return gulp.src('./node_modules/bootstrap-sass/assets/fonts/bootstrap/*')
        .pipe(gulp.dest('./public/fonts'));
});

gulp.task('build', () => {
    gulp.run(['fonts', 'sass']);
});

gulp.task('watch:scss', () => {
    gulp.watch('./resources/**/*.scss', ['sass']);
});