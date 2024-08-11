var site_url="http://localhost/basmic/system/application/views/author/saad/";
var uploader="";
var uploadDir="";
var dirname="";
var filename="";
var timeInterval="";
var idname="";
var uploaderId="";
var http=createRequestObject();

function createRequestObject() 
{
    var obj;
    var browser = navigator.appName;
    if(browser == "Microsoft Internet Explorer"){return new ActiveXObject("Microsoft.XMLHTTP");}
    else{return new XMLHttpRequest();}   
}
function traceUpload() 
{
   http.onreadystatechange = handleResponse;   
   http.open("GET", site_url+'imageupload.php?uploadDir='+uploadDir+'&dirname='+dirname+'&filename='+filename+'&uploader='+uploader);       
   http.send(null);    
}
function handleResponse() 
{
	if(http.readyState == 4)
	{
		var response=http.responseText; 
		if(response.indexOf("File loaded") != -1)
		{	clearInterval(timeInterval);
			//document.getElementById('loading'+idname).innerHTML="";
		}
        document.getElementById(uploaderId).innerHTML=response;
    }
    else { document.getElementById(uploaderId).innerHTML="Loading File. Please wait..."; }
}
function uploadFile(obj, dname) 
{
	uploadDir=obj.value;
	idname=obj.name;
	dirname=dname;
	filename=uploadDir.substr(uploadDir.lastIndexOf('\\')+1);	
	uploaderId = 'uploader'+obj.name;
	uploader = obj.name;
	document.getElementById('formName'+obj.name).submit();
	//timeInterval=setInterval("traceUpload()", 1500);
	traceUpload();
}

