var xmlhttp;
var site_url="http://localhost/basmic/system/application/views/rev/peer/";

function deleteRow(i)
{
    document.getElementById('myTable').deleteRow(i)
}

function Test()
{ alert("test"); }

function Papers(val)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
var url=site_url+"reviewerpaper.php";
url=url+"?ListPaper=true";
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=PapersChange;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);

}

function PapersChange()
{
if (xmlhttp.readyState==4)
  {document.getElementById("mainbody").innerHTML=xmlhttp.responseText;}
}
///////////////////////////////////////////////////////////
function Rate()
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
var url=site_url+"reviewerpaper.php";
url=url+"?RatePaper=true";
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=PapersChange;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function History()
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
var url=site_url+"reviewerpaper.php";
url=url+"?History=true";
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=PapersChange;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function RateUpdate(rate,paperid)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
var url=site_url+"reviewerpaper.php";
url=url+"?rating="+rate;
url=url+"&paper="+paperid;
url=url+"&check=true";
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=RateUpdateChange;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function RateUpdateChange()
{
if (xmlhttp.readyState==4)
  {document.getElementById("statusbar").innerHTML=xmlhttp.responseText;}
}

///////////////////////////////////////////////////////////
function Download(link)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
var url=site_url+"reviewerpaper.php";
url=url+"?DownloadFile=true";
url=url+"&path="+link;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=DownloadLink;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function DownloadLink()
{
if (xmlhttp.readyState==4)
  {document.getElementById("mainbody").innerHTML=xmlhttp.responseText;}
}

//////////////////////Brwoser Exception//////////////////////////////
function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}
