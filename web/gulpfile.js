var gulp = require('gulp'),
    connect = require('gulp-connect');

gulp.task('devServer', function() {
  connect.server({
    livereload: true
  });
});
gulp.task('html', function () {
  gulp.src([
    './*.html', './*.js'
  ])
    .pipe(connect.reload());
});
gulp.task('watchFiles', function () {
  gulp.watch(['./*.html', './*.js'], ['html']);
});

// Start
gulp.task('default', ['devServer', 'watchFiles']);