/*
 * Copyright 2015 Suowen team.
 */
 /**
  * suowen interface
  **/
(function(global) {
    "use strict";

    var ProtoBuf = dcodeIO.ProtoBuf;
    var SuowenAPI = {version:1,token:""};
    /**
     * 初始化API
     * @param url API 的URL地址
     */
    SuowenAPI.Init = function(url){
        this.url = url;
        this.builder = ProtoBuf.newBuilder({ convertFieldsToCamelCase: true });
        //添加公共类
        suowen.api.AddProto("/sys/Common.json");
        suowen.api.AddProto("/sys/Model.json");
    };
    /**
     * 增加一个协议定义，目前尚不能增加多个协议.
     * @see https://github.com/dcodeIO/ProtoBuf.js/issues/289
     * TODO 能够支持添加多个协议
     * @param path
     * @constructor
     */
    SuowenAPI.AddProto=function(path){
        ProtoBuf.loadJsonFile(this.url+"/proto"+path,this.builder);
    };
    /**
     * 构建
     * @returns 命名空间
     */
    SuowenAPI.Build = function(){
        if(this.root){
            throw Error("Suowen Protocol Built!");
        }else{
            this.root = this.builder.build();
            return this.root;
        }
    };

    /**
     * 执行某一个API
     * @param cmd API的命令
     * @param protobufRequest protobuf请求对象
     * @param success 当执行成功后的操作
     * @param fail 当执行失败后的操作
     */
    SuowenAPI.Fetch = function(protobufRequest,success,fail){
        if(this.url == null){
            throw Error("URL Not Configuration");
        }
        var me = this;
        var ProtoBuf = dcodeIO.ProtoBuf;
        var xhr = ProtoBuf.Util.XHR();
        xhr.open(
            "POST",
            this.url,
            true
        );
        xhr.responseType = "arraybuffer";

        xhr.setRequestHeader('Content-Type','binary/octet-stream');
        xhr.setRequestHeader("X-Suowen-Request","protobuf");
        xhr.onload = function(evt) {
            var error = xhr.getResponseHeader("X-Suowen-Error")
            var responseType = me.root.sys.BaseResponse
            var response = responseType.decode(xhr.response);
            me.token = xhr.getResponseHeader("Suowen-Token")
            if(error){
                fail(response.getMessage())
            }else{
                var responseCmd = protobufRequest.toString().replace(/Request$/,"Response")+".cmd";
                var protobufResponse = response.get(responseCmd)
                success(protobufResponse)
            };
        };
        var baseRequest= new this.root.sys.BaseRequest()
        baseRequest.setToken(this.token);
        baseRequest.setVersion(this.version);
        baseRequest.set(protobufRequest.toString()+".cmd",protobufRequest)

        xhr.send(baseRequest.toArrayBuffer());
    };

    (global["suowen"] = global["suowen"] || {})["api"] = SuowenAPI;
})(this);
