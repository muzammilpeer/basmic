var xmlhttp

function deleteRow(i){
    document.getElementById('myTable').deleteRow(i)
}/*
function showMenuBars(q)
{
menubar=null;
body=null;
body = '<div class="componentheading" >';
menubar='<div style="font-size:16px;font-weight:bold;margin-top:6px" ><bold>';
if (q == "usermanagement")
{
  menubar+= '<a href="#"  onclick="ShowBody(\''+q+'\',\'1\')">Users </a> | <a href="#" onclick="ShowBody(\''+q+'\',\'2\')">Add Conference Administrators</a>  | <a href="#" onclick="ShowBody(\''+q+'\',\'3\')">Closing Conference</a> ';
  body+='User Management';
} else
if (q == "papermanagement")
 {
  menubar+= '<a href="#"  onclick="ShowBody(\''+q+'\',\'1\')">Papers Cabinet </a> | <a href="#" onclick="ShowBody(\''+q+'\',\'2\')">Automation</a> ';
  body+='Paper Management';
} else 
if (q == "reviewermanagement")
{
  menubar+= '<a href="#"  onclick="ShowBody(\''+q+'\',\'1\')">Conference Reviewer</a> | <a href="#" onclick="ShowBody(\''+q+'\',\'2\')">Deadline</a>  | <a href="#" onclick="ShowBody(\''+q+'\',\'3\')">Automation</a> ';
  body+='Reviewer Management';
} else
if ( q == "history")
{
  menubar+= '<a href="#"  onclick="ShowBody(\''+q+'\',\'1\')">Conferences </a> | <a href="#" onclick="ShowBody(\''+q+'\',\'2\')">Papers</a>  | <a href="#" onclick="ShowBody(\''+q+'\',\'3\')">Closing Message</a> ';
  body+='History of Conferences and Papers';
}
menubar+='</bold></div>';
body+='</div>';
 
  document.getElementById("menubar").innerHTML=menubar;
  document.getElementById("mainbody").innerHTML=body;
}
*/

function showMenuBar(opt)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
var url="tst.php";
url=url+"?q="+opt;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=stateChangedMenuBar;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}
function stateChangedMenuBar()
{
if (xmlhttp.readyState==4)
  {
  document.getElementById("menubar").innerHTML=xmlhttp.responseText;
  }
}
var temp;
function changeRigths(email,rights)
{
//alert("hello "+email+rights);
/*
if (rights.length==0 || email.length == 0)
  {
  document.getElementById(email+"status").innerHTML="not completed";
  return;
  }
  temp = email;*/
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
var url="processing.php";
url=url+"?grp="+rights;
url=url+"&email="+email;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=ChangeRoles;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
//alert("hello new "+email+rights);

}

function ChangeRoles()
{
if (xmlhttp.readyState==4)
  {
  alert(xmlhttp.responseText+" has assigned new Role");
  //document.getElementById("Status").innerHTML=xmlhttp.responseText;
  }
}


function showHint(email,str)
{
if (str.length==0)
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
var url="tst.php";
url=url+"?q="+str;
url=url+"&p="+email;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function stateChanged()
{
if (xmlhttp.readyState==4)
  {
//  document.getElementById("menubar").innerHTML=xmlhttp.responseText;
  document.getElementById("mainbody").innerHTML=xmlhttp.responseText;
  }
}
/*
function ShowBody(menubars,optnos)
{
/*if (str.length==0)
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
var url="tst.php";
url=url+"?menubar="+menubars;
url=url+"&optno="+optnos;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=ShowBodyChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function ShowBodyChanged()
{
if (xmlhttp.readyState==4)
  {
//  document.getElementById("mainbody").innerHTML=null;
  document.getElementById("mainbody").innerHTML=xmlhttp.responseText;
  }
}*/
function ListReviewer(str)
{
if (str.length==0)
  {
  document.getElementById("refreshtable").innerHTML="";
  return;
  }
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
  
//  alert("new data");
var url="tst.php";
if ( str == "13")
{str="*";}
url=url+"?reviewer="+str;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=stateChangedListReviewer;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function stateChangedListReviewer()
{
 	if(xmlHttp.readyState == 0)
	{
	document.getElementById("refreshtable").innerHTML = "Sending Request...";
	}
	if(xmlHttp.readyState == 1)
	{
	document.getElementById("refreshtable").innerHTML = "Loading Response...";
	}
	if(xmlHttp.readyState == 2)
	{
	 document.getElementById("refreshtable").innerHTML = "Response   Loaded...";
	}
	if(xmlHttp.readyState == 3)
	{
	 document.getElementById("refreshtable").innerHTML = "Response Ready...";
	}

if (xmlhttp.readyState==4)
  {
   document.getElementById("refreshtable").innerHTML = "Response Ready...";
	
/*  document.getElementById("refreshtable").innerHTML=xmlhttp.responseText;
  */}
}




function ListUser(str)
{
if (str.length==0)
  {
  document.getElementById("refreshtable").innerHTML="";
  return;
  }
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
var url="response.php";
if ( str == "13")
{str="*";}
url=url+"?q="+str;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=stateChangedListUser;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function stateChangedListUser()
{
if (xmlhttp.readyState==4)
  {
  document.getElementById("refreshtable").innerHTML=xmlhttp.responseText;
  }
}

function ShowPaper(confid)
{

/*if (str.length==0)
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }*/
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }

var url="ajaxreviewer.php";
url=url+"?confids="+confid;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=ShowPaperChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function ShowPaperChanged()
{
/* 	if(xmlHttp.readyState == 0)
	{
	document.getElementById("detailtable").innerHTML = "Sending Request...";
	}
	if(xmlHttp.readyState == 1)
	{
	document.getElementById("detailtable").innerHTML = "Loading Response...";
	}
	if(xmlHttp.readyState == 2)
	{
	 document.getElementById("detailtable").innerHTML = "Response   Loaded...";
	}
	if(xmlHttp.readyState == 3)
	{
	 document.getElementById("detailtable").innerHTML = "Response Ready...";
	}
'<img src="images/ajax-loader.gif" />'
*/	
	if (xmlhttp.readyState==3)
	{
	document.getElementById("detailtable").innerHTML="loading..";
	}else
	if (xmlhttp.readyState==4)
	{
	//document.getElementById("detailtable").innerHTML='<img src="images/ajax-loader.gif" />';
	document.getElementById("detailtable").innerHTML=xmlhttp.responseText;
	}
}



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
