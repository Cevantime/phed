var config       = require('../config')
var gulp         = require('gulp')
var gulpSequence = require('gulp-sequence')
var getEnabledTasks = require('../lib/getEnabledTasks')
require('./webpackProduction')
require('./sizereport')


//var productionTask = function(cb) {
  global.production = true
  var tasks = getEnabledTasks('production')
  
//}
var task = gulp.series('clean', gulp.parallel(tasks.assetTasks), gulp.parallel(tasks.codeTasks), config.tasks.production.rev ? 'rev': [], 'size-report', 'static');
gulp.task('production', task)
module.exports = task
