
var xmlhttp;
var site_url="http://localhost/basmic/system/application/views/author/saad/";

function deleteRow(i){
    document.getElementById('myTable').deleteRow(i)
}
function showMenuBars(q)
{
//onclick="paperauto()"
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
  menubar+= '<a href="#"  onclick="ShowBody(\''+q+'\',\'papercabinet\')">Papers Cabinet </a> | <a href="#" onclick="ShowBody(\''+q+'\',\'automation\')">Automation</a> ';
  /*body+='<table><tr><th><img src="images/Vista%20%28114%29.png" alt="fastcoms"></td><td><h2><strong>Paper Management</strong></h2></th></tr></table><br><br>';
  body+='<br><br><table width="0" border="0"><tbody><tr><td><center><img src="images/Vista%20%2848%29.png" alt="fastcoms" width="128" height="128"></center></td><td><center><a href="ar_paper">';
  body+='<img src="images/Vista%20%28137%29.png" alt="fastcoms" width="128" height="128"></a></center></td><td><center><a href="ar"><img src="images/Vista%20%28265%29.png" alt="fastcoms" width="128" height="128"></a></center></td></tr>';
  body+='<tr><td><center>Paper Cabinet</center></td><td><center><a href="http://localhost/fastcoms/index.php/chair/ar_paper.html">Accept/Reject Papers</a></center></td><td><center>Manually Accept/Reject</center></td></tr></tbody></table>';
  body+='<p>&nbsp;</p>';*/
  body+='Paper Management';

} else 
if (q == "reviewermanagement")
{
  menubar+= '<a href="#"  onclick="ShowBody(\''+q+'\',\'conferencereviewer\')">Conference Reviewer</a> | <a href="#" onclick="ShowBody(\''+q+'\',\'deadline\')">Deadline</a>  | <a href="#" onclick="ShowBody(\''+q+'\',\'automation\')">Automation</a> ';
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


function Reply(q)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
var url=site_url+"reply.php";
url=url+"?menubar="+q;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=ShowBodyChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function ShowBodyChanged()
{
if (xmlhttp.readyState==4)
  {
  document.getElementById("mainbody").innerHTML=xmlhttp.responseText;
  }

}



function ShowBody(menubars,optnos)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
var url=site_url+"manualpaper.php";
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
  document.getElementById("mainbody").innerHTML=xmlhttp.responseText;
  }

}

function Conferences(conf)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
var url=site_url+"manualpaper.php";
url=url+"?Listallconf="+conf;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=paperautoChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function paperauto()
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
if (document.getElementById("optionselect").value == "Manual")
{
document.getElementById("processing").innerHTML=document.getElementById("optionselect").value;
var url=site_url+"manualpaper.php";
url=url+"?Listallconf=1";
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=paperautoChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
} 
else if (document.getElementById("optionselect").value == "Automatic")
	{alert("automatic");} 
}

function paperautoChanged()
{
if (xmlhttp.readyState==4)
  {
  document.getElementById("processing").innerHTML=xmlhttp.responseText;
  }
}

function ShowPapers(confid,opt)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
var url=site_url+"manualpaper.php";
url=url+"?listpapers="+confid;
url=url+"&opt="+opt;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=ShowPapersChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function ShowPapersChanged()
{
if (xmlhttp.readyState==4)
  {
  document.getElementById("detail").innerHTML=xmlhttp.responseText;
  }
}

function ManualAccept(status,paperid)
{
/*alert ("Paper is changed to "+ status + "new is " + paperid);*/
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
	alert ("Your browser does not support XMLHTTP!");
	return;
  }
  if (status =="Accept")
  {  status =1;  } 
  else {  status = 0;  }
  
var url=site_url+"manualpaper.php";
url=url+"?acceptorreject="+status;
url=url+"&paperid="+paperid;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=ManualAcceptChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}
function ManualAcceptChanged()
{
if (xmlhttp.readyState==4)
  {
  document.getElementById("statusbar").innerHTML=xmlhttp.responseText;
  }
}


function GetStrings()
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Your browser does not support XMLHTTP!");
  return;
  }
alert("paper string is ");
var url="manualpaper.php";
//url=url+paper;
/*url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=ShowPapersChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);*/

}

function ShowPapersChanged()
{
if (xmlhttp.readyState==4)
  {
  document.getElementById("detail").innerHTML=xmlhttp.responseText;
  }
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
