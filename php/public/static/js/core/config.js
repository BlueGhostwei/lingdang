define(function(require, exports, module) {



    var dev={},_config={},host
    host = dev.host =  'http://'+location.host;

    _config.reSizeImg = 200

    //接口配置
    var api = _config.api = {};
    api.api_token = host + '/api_token';

    //创建用户接口
    api.user_store = host + 'admin/user/store';  //创建用户




























    module.exports =  _config;

});