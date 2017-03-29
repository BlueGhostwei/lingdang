/**
 * 实现异步方法promise模式的模块
 * @param  {[type]} require [description]
 * @param  {[type]} exports [description]
 * @param  {[type]} module  [description]
 * @return {[type]}         [description]
 */
define("core/promise", [ "core/event", "core/lang" ], function(require, exports, module) {
    "use strict";
    var Event = require("core/event");
    module.exports = Event.Promise;
});