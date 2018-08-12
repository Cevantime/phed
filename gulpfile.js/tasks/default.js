var gulp            = require('gulp')
var gulpSequence    = require('gulp-sequence')
var getEnabledTasks = require('../lib/getEnabledTasks')
require('./fonts')
require('./images')
require('./svgSprite')
require('./javascript')
require('./static')
require('./watch')
//var defaultTask = function(cb) {
  var tasks = getEnabledTasks('watch')
//  gulp.series('clean', gulp.parallel(tasks.assetTasks), gulp.parallel(tasks.codeTasks), 'static', 'watch', cb)
//}

var task = gulp.task('default', gulp.series('clean', gulp.parallel(tasks.assetTasks), gulp.parallel(tasks.codeTasks), 'static', 'watch'))
module.exports = task
