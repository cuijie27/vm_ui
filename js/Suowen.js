/** suowen interface **/
(function(global) {
    "use strict";

    var ProtoBuf = dcodeIO.ProtoBuf;
    var SuowenAPI = {version:1,token:""};
    SuowenAPI.Init = function(url){
        this.url = url;
        this.builder = ProtoBuf.newBuilder({ convertFieldsToCamelCase: true });
        //this.AddProto("protos/sys/Common.proto")
    };
    SuowenAPI.AddProto=function(path){
        ProtoBuf.loadProtoFile(path,this.builder);
    };
    SuowenAPI.Build = function(){
        if(this.root){
            throw Error("Suowen Protocol Builted!");
        }else{
            this.root = this.builder.build();
            return this.root;
        }
    };

    SuowenAPI.Fetch = function(cmd,protobufRequest,success,fail){
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
                success(response)
            };
            /*
            var dicQueryResponse = response.get('.sys.DicQueryResponse.cmd')
            var data = dicQueryResponse.getData();
            for(var i=0;i<data.length;i++){
                var e = data[i].getObject();
                for(var j=0;j<e.length;j++){
                    alert(e[j].getKey())
                    alert(e[j].getValue());
                }
            }
            //alert(response.getMessage());
            */

        };
        var baseRequest= new this.root.sys.BaseRequest()
        baseRequest.setToken(this.token);
        baseRequest.setVersion(this.version);
        baseRequest.set('.stock.TakeStockQueryRequest.cmd',protobufRequest)

        xhr.send(baseRequest.toArrayBuffer());
    };

    (global["suowen"] = global["suowen"] || {})["api"] = SuowenAPI;
})(this);
