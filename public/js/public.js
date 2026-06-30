window.onload=function()
{
		 var oPlay=document.getElementById('play');
		 var aLi=oPlay.getElementsByTagName('li');
		 var oButton=document.getElementById('button');
		 var aDiv=oButton.getElementsByTagName('div');
		 var oPrev=document.getElementById('prev');
		 var oNext=document.getElementById('next');
		 var oFlash=document.getElementById('flash');
		 var now=0;
		 var timer2=null;
		 for(var i=0; i<aDiv.length; i++) {
		 	aDiv[i].index=i;
		 	aDiv[i].onmouseover=function(){
		 		if(now==this.index) return;
		 		now=this.index;
		 		tab();
		 	}
		 }
		 oPrev.onclick=function(){
		 	now--;
		 	if(now==-1){
		 		now=aDiv.length-1;
		 	}
		 	tab();
		 }
		 oNext.onclick=function(){
		 	now++;
		 	if(now==aDiv.length){
		 		now=0;
		 	}
		 	tab();
		 }
		 oFlash.onmouseover=function()
		{
		    clearInterval(timer2);
		}
		 oFlash.onmouseout=function()
		{
			timer2=setInterval(oNext.onclick,4000);
		}
		 timer2=setInterval(oNext.onclick,5000);
		 function tab(){
		 	for(var i=0; i<aLi.length; i++){
		 		aLi[i].style.display='none';
		 	}
		 	for(var i=0; i<aDiv.length; i++) {
		 		aDiv[i].style.background="#DDDDDD";
		 	}
		 	aDiv[now].style.background='#A10000';
		 	aLi[now].style.display='block';
		 	aLi[now].style.opacity=0;
		 	aLi[now].style.filter="alpha(opacity=0)";
		 	jianbian(aLi[now]);
		 }
		function jianbian(obj){
			var alpha=0;
			clearInterval(timer);
			var timer=setInterval(function(){
				alpha++;
				obj.style.opacity=alpha/100;
				obj.style.filter="alpha(opacity="+alpha+")";
				if(alpha==100) {
					clearInterval(timer);
				}
			},10);
		}
}

function startTime(){
	var today=new Date();
	var Y=today.getFullYear();
	var M=today.getMonth() + 1;
	var D=today.getDate();
	var h=today.getHours();
	var m=today.getMinutes();
	var s=today.getSeconds();// 在小于10的数字前加一个‘0’
	m=checkTime(m);
	s=checkTime(s);
	document.getElementById('txt').innerHTML=Y+"-"+M+"-"+D+" "+h+":"+m+":"+s;
	t=setTimeout(function(){startTime()},500);
}
function checkTime(i){
	if (i<10){
		i="0" + i;
	}
	return i;
}