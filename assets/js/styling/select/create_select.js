import {domCreate} from './dom_create.js'

export function createCustomSelect(select){
    let head;
  	const ul = domCreate('ul', 'select-options', '', select, '')
  	const selected = select.querySelector('[selected]')
  	if(selected) head = domCreate('div', 'select-styled', '', select,  selected.innerHTML)
  	select.querySelectorAll('option').forEach( (o,i) => {
  		let className = selected === o ? "isActive" : ''
  		domCreate('li', className, {
  			'rel': o.value,
  			'tabindex': '0',
  		}, ul, o.innerHTML)
  		if(i === 0 && !head) head = domCreate('div', 'select-styled', '', select,  o.innerHTML)
  	})
  	select.insertBefore(head, ul);
}
