var config  = require('../config')
var ghPages = require('gulp-gh-pages')
var gulp    = require('gulp')
var opn    = require('opn')
var os      = require('os')
var package = require('../../package.json')
var path    = require('path')
require('./production')

var settings = {
  url: package.homepage,
  src: path.join(config.root.dest, '/**/*'),
  ghPages: {
    cacheDir: path.join(os.tmpdir(), package.name)
  }
}

var deployTask = function() {
  return gulp.src(settings.src)
    .pipe(ghPages(settings.ghPages))
    .on('end', function(){
      opn(settings.url)
    })
}

gulp.task('deploy', gulp.series('production'), deployTask)
module.exports = deployTask
