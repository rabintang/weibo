function goto(elementId) {
	var pos=getElementPos(elementId);
	//alert("距左边距离"+ pos.x +",距上边距离"+pos.y);
	window.scrollTo(0, pos.y-45);
}


/*返回元素的top和left的值*/
function getElementPos(elementId) {
	var ua = navigator.userAgent.toLowerCase();
	var isOpera = (ua.indexOf('opera') != -1);
	var isIE = (ua.indexOf('msie') != -1 && !isOpera); // not opera spoof
	var el = document.getElementById(elementId);
	if(el.parentNode === null || el.style.display == 'none') {
		return false;
	}
	var parent = null;
	var pos = [];
	var box;
	if(el.getBoundingClientRect)    //IE
	{
		box = el.getBoundingClientRect();
		var scrollTop = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
		var scrollLeft = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
		return {x:box.left + scrollLeft, y:box.top + scrollTop};
	}
	else if(document.getBoxObjectFor)    // gecko
	{
		box = document.getBoxObjectFor(el);
		var borderLeft = (el.style.borderLeftWidth)?parseInt(el.style.borderLeftWidth):0;
		var borderTop = (el.style.borderTopWidth)?parseInt(el.style.borderTopWidth):0;
		pos = [box.x - borderLeft, box.y - borderTop];
	} 
	else    // safari & opera
	{
		pos = [el.offsetLeft, el.offsetTop];
		parent = el.offsetParent;
		if (parent != el) {
			while (parent) {
				pos[0] += parent.offsetLeft; 
				pos[1] += parent.offsetTop;
				parent = parent.offsetParent;
			}
		}
		if (ua.indexOf('opera') != -1 || ( ua.indexOf('safari') != -1 && el.style.position == 'absolute' )) {
			pos[0] -= document.body.offsetLeft;
			pos[1] -= document.body.offsetTop;
		}
	}
	if (el.parentNode) {
		parent = el.parentNode;
	} else {
		parent = null;
	}
	while (parent && parent.tagName != 'BODY' && parent.tagName != 'HTML') { // account for any scrolled ancestors
		pos[0] -= parent.scrollLeft;
		pos[1] -= parent.scrollTop;
		if (parent.parentNode) {
			parent = parent.parentNode;
		} else {
			parent = null;
		}
	}
	return {x:pos[0], y:pos[1]};
}

function recordAction(url, source){
	var frm_record_action = document.getElementById('recordActionFrm');
	frm_record_action.action = url;
	var sourceField = document.getElementById('sourceField');
	sourceField.value = source;
	frm_record_action.submit();
}