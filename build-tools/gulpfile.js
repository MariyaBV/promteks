const gulp = require("gulp");
const requireDir = require("require-dir");
const tasks = requireDir("./tasks");

exports.style = tasks.style;
exports.style_other = tasks.style_other;
exports.js = tasks.js;
exports.dev_js = tasks.dev_js;
exports.html = tasks.html;
exports.bs_html = tasks.bs_html;
exports.watch = tasks.watch;

exports.default = gulp.parallel(
  exports.style,
  exports.style_other,
  exports.dev_js,
  exports.html,
  exports.bs_html,
  exports.watch
);
