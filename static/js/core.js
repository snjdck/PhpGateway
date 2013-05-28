function addListener(target, type, handler)
{
	target = $(target);
	if(target.addEventListener){
		target.addEventListener(type, handler, false);
	}else if(target.attachEvent){
		target.attachEvent("on" + type, handler);
	}else{
		target["on" + type] = handler;
	}
}

function $(target)
{
	if(typeof target == "string"){
		return document.getElementById(target);
	}
	return target;
}