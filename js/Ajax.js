
function testScript($a){
    getLabelsPost();
    getOkPost();
//    alert($a);
//    var t1 = window.setInterval(getOkPost,1000);
}

var xmlHttp;

function GetXmlHttpObject(){
    if (window.XMLHttpRequest){
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }else{// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    return xmlhttp;
}
// -----------ajax方法-----------//
function getLabelsPost(){
    xmlHttp=GetXmlHttpObject();
    if (xmlHttp==null){
        alert('您的浏览器不支持AJAX！');
        return;
    }

//    var url="http://123.57.242.185/end_cms/api.php?p=internet_control_baseStation";
    var url="http://localhost/yunbucket/qiniuyun/testEmail.php";

    xmlhttp.open("POST",url,true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send();

//    xmlHttp.onreadystatechange=getLabelsOK;//发送事件后，收到信息了调用函数
//    getOkPost();
}

function getOkPost(){
    if(xmlHttp.readyState==1||xmlHttp.readyState==2||xmlHttp.readyState==3){
        // 本地提示：加载中/处理中
        alert(xmlHttp.readyState);
    }
    if (xmlHttp.readyState==4 && xmlHttp.status==200){
        var d=xmlHttp.responseText; // 返回值
        // 处理返回值
        alert(xmlHttp.readyState);
    }
}