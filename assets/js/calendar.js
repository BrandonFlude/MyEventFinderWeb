function getXMLHttpRequest() {
    if (window.XMLHttpRequest) {         // Mozilla/Safari
        return new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {     // IE
        return new ActiveXObject("Microsoft.XMLHTTP");
    }
}

function xmlhttpPost(strURL) {
    xmlHttpReq = getXMLHttpRequest();
    xmlHttpReq.open('POST', strURL, true);
    xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlHttpReq.onreadystatechange = stateChanged;
    xmlHttpReq.send(getQueryString());
}

function stateChanged() {
    if (xmlHttpReq.readyState == 4 || xmlHttp.readyState=="complete") {
         updatepage(xmlHttpReq.responseText);
    }
}

function getQueryString() {
    var form = document.forms['day'];
    var carType = form.carType.value;
    qstr = 'resultString=' + escape(carType);
    var carColor = form.carColor.value;
    qstr1 = escape(carColor);
    var res = qstr + ', ' + qstr1;
    return res;
}

function updatepage(str){
    document.getElementById("result").innerHTML = str;
}
