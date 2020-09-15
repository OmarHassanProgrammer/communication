var
    gulp = require("gulp"),
    concat = require("gulp-concat"),
    sass = require("gulp-sass"),
    sourcemaps = require("gulp-sourcemaps"),
    autoprefix = require("gulp-autoprefixer"),
    notify = require("gulp-notify"),
    minify = require('gulp-minify');

gulp.task('php', function() {
    return gulp.src('project/api/*.php')
        .pipe(gulp.dest("dist/api"))
        .pipe(notify("php apis has been moved to dist folder"));
});

gulp.task('css' ,function() {
    return gulp.src(['project/css/sass/**/*.css', 'project/css/sass/**/*.scss'])
        .pipe(sourcemaps.init())
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(autoprefix())
        .pipe(concat('styles.css'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('dist/css'))
        .pipe(notify("scss files has been compiled and moved to dist folder"));
});

gulp.task('css-libs' ,function() {
    return gulp.src('project/css/libs/*.css')
        .pipe(sourcemaps.init())
        .pipe(autoprefix())
        .pipe(concat('styles-libs.css'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('dist/css'))
        .pipe(notify("scss libs files has been compiled and moved to dist folder"));
});

gulp.task('html', function() {
    return gulp.src(['project/view/pages/*.php', 'project/view/pages/*.html'])
        .pipe(gulp.dest('dist'))
        .pipe(notify("php pages has been moved to dist folder"));
});

gulp.task('js', function() {
    return gulp.src('project/js/scripts/*.js')
        .pipe(concat('scripts.js'))
        .pipe(minify())
        .pipe(gulp.dest('dist/script'))
        .pipe(notify("js files has been compresed and moved to dist folder"));
});

gulp.task('js-libs' ,function() {
    return gulp.src('project/js/libs/*.js')
        .pipe(sourcemaps.init())
        .pipe(concat('scripts-libs.js'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('dist/script'))
        .pipe(notify("js libs files has been compiled and moved to dist folder"));
});

gulp.task('includes', function() {
    return gulp.src('project/view/includes/**')
        .pipe(gulp.dest('dist/includes'))
        .pipe(notify('include folder has been moved to dist folder'));
});

gulp.task('watch', function() {
    gulp.watch('project/api/*.php', ['php']);
    gulp.watch(['project/css/sass/**/*.css', 'project/css/sass/**/*.scss'], ['css']);
    gulp.watch(['project/css/libs/*.css', 'project/css/libs/*.scss'], ['css-libs']);
    gulp.watch(['project/view/pages/*.php', 'project/view/pages/*.html'], ['html']);
    gulp.watch('project/view/includes/**', ['includes']);
    gulp.watch('project/js/scripts/*.js', ['js']);
    gulp.watch('project/js/libs/*.js', ['js-libs']);
});

gulp.task('default', ['watch']);