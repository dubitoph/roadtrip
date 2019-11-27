import {showHide} from './show_hide.js'
export function checkActive(e, options, head, select,customSelect,count,openH, selHide){

	if(e.target.localName != "li") return;
	options.forEach( o => e.target != o ? o.classList.remove('isActive') : o.classList.add('isActive') )

/*
	selHide.children.forEach( o => e.target.getAttribute('rel') === o.value ? o.setAttribute('selected', 'selected') : o.removeAttribute('selected') )
*/

	Array.prototype.forEach.call(selHide.children, child => {
		o => e.target.getAttribute('rel') === o.value ? o.setAttribute('selected', 'selected') : o.removeAttribute('selected')
		console.log('hello')
	});

	head.innerHTML = e.target.innerHTML
	showHide(select,customSelect,count,openH)


}
