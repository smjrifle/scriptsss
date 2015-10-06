//Grow

var id;
	 function grow_me()
	 {
	 	if(document.getElementById("img1").style.width=="")
	 		document.getElementById("img1").style.width="4px";
	 	var obje=document.getElementById("img1").style.width;
	 	var newwidth=parseInt(obje)+50;
	 	if(newwidth>190)
	 		{window.clearInterval(id);return;}
	 	else
	 		id = setInterval(grow_me,1000);
	 	console.log(newwidth);
	 	document.getElementById("img1").style.width=newwidth + "px";
	 	
	 }


//Opacity

var id=0;
	var opq=0.0;
	function loaded()
	{
		id = setInterval(grow_me,100);
	}
	 function grow_me()
	 {
	 	
	 	opq=opq + 0.1;
	 	//console.log(count);
	 	//document.getElementById("mid-cont-wrapper").style.opacity=opq;
	 	if(opq>=1)
	 		{window.clearInterval(id);}
	 	document.getElementById("mid-cont-wrapper").style.opacity=opq;
	 }