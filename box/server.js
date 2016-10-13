(function() {
  //此处设置
  var verifyURL= "/verify.php"
  var loginURL= "/login.php"

  var key="_ACAI_IP"
  function $(id){
	 return document.getElementById(id);
  }
  function notice(msg){
    $("message").innerHTML="<div class='notice'>"+msg+"</div>";
  }
  function error(msg){
    $("message").innerHTML="<div class='error'>"+msg+"</div>";
  }
 
  var httpRequest;
  $("connBtn").onclick = function() { makeRequest(); };

  function makeRequest() {
    notice("开始连接");
    var url='http://'+$('ip').value+verifyURL;
    httpRequest = new XMLHttpRequest();

    if (!httpRequest) {
      error('Giving up :( Cannot create an XMLHTTP instance');
      return false;
    }
    httpRequest.onreadystatechange = alertContents;
    httpRequest.open('GET', url);
    httpRequest.send();
  }

  function alertContents() {
    if (httpRequest.readyState === XMLHttpRequest.DONE) {
      notice("请求完成");
      if (httpRequest.status === 200) {
        notice("连接成功");
        var url='http://'+$('ip').value+loginURL;
        localStorage.setItem(key,$('ip').value);
        window.location=url;
      } else {
        error('连接错误:status:'+httpRequest.status);
      }
    }
  }
  function GetQueryString(name)
  {
       var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
       var r = window.location.search.substr(1).match(reg);
       if(r!=null)return  unescape(r[2]); return null;
  }

  var serverIp = localStorage.getItem(key);
  if(serverIp){
    $('ip').value = serverIp;
    if(!GetQueryString("reset"))
      makeRequest();
  }
})();
