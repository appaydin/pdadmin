/**
 * Load Gulp
 * Load Plugins
 */
var gulp = require('gulp'),
  sass = require('gulp-sass'),
  cleanCSS = require('gulp-clean-css'),
  concat = require('gulp-concat'),
  merge = require('merge-stream'),

  fs = require('fs'),
  glob = require('glob');

/**
 * SCSS to CSS
 * Concat & Minify CSS
 */
gulp.task('style', function () {
  let scssStream = gulp.src('src/assets/style.scss')
    .pipe(sass())
    .pipe(cleanCSS())
    .pipe(concat('app.min.css'))
    .pipe(gulp.dest('dist'));

  return scssStream;
});
gulp.task('styleDev', function () {
  let scssStream = gulp.src('src/assets/style.scss')
    .pipe(sass())
    .pipe(concat('app.min.css'))
    .pipe(gulp.dest('dist'));

  return scssStream;
});

// Watch SCSS
gulp.task('styleWatch', function () {
  return gulp.watch(['src/assets/*.scss', 'src/assets/*/*.scss', 'src/assets/*/*/*.scss'], ['styleDev'])
});


/**
 * Extract Keen-Ui Scss
 */
gulp.task('keen-extract-style', function () {
  let extractPattern = "./node_modules/keen-ui/src/*.vue"
  let copyPattern = "./node_modules/keen-ui/src/styles/*.scss"
  let srcDir = "src/assets/keen-ui/src/"

  // Extract VUE Scss
  let content = ''
  glob(extractPattern, null, function (err, files) {
    files.forEach(function (file) {
      let comment = "/*================================================\n" + file.replace(/\\/g, '/').replace(/.*\//, '') + "\n================================================*/\n"
      fs.readFile(file, 'utf8', function (err, data) {
        let regex = /.*<style.*?>([\s\S]*)<\/style>/g
        let match = regex.exec(data)
        if (match && match[1]) {
          content += comment + match[1].replace(/.*@import.*/g, '').trim() + '\n\n\n'
        }
      })
    })
  })

  // Copy SRC
  glob(copyPattern, null, function (err, files) {
    files.forEach(function (file) {
      let filename = srcDir + file.replace(/\\/g, '/').replace(/.*\//, '')
      fs.readFile(file, 'utf8', function (err, data) {
        fs.writeFile(filename, data)
      });
    })
  })

  // Write File
  setTimeout(function () {
    fs.writeFile(srcDir + 'keen-vue.scss', content)
  }, 3000)
})

/**
 * Start
 */
gulp.task('default', ['style']);
gulp.task('dev', ['styleDev', 'styleWatch']);