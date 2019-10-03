// --styling
import {createCustomSelect} from '../../styling/select/create_select.js'

// -- actions
import {showHide} from './show_hide.js'
import {checkActive} from './check_active.js'

function selectShowHide(){
	const selects = document.querySelectorAll('.select');
	if(!selects) return

	selects.forEach( select => {
		createCustomSelect(select)
		const head = select.querySelector('.select-styled');
		const customSelect = select.querySelector('.select-options');
		const options = customSelect.querySelectorAll('li');
		const selHide = select.querySelector('.select-hidden')
		const openH = [...options].reduce( (tot, o) => { return tot + o.clientHeight }, 0);

		let count = false;

		//show/hide events
		head.addEventListener('click', e => {
			showHide(select,customSelect,count,openH)
		})
		document.addEventListener('click', e => {
			e.target != select && e.target != customSelect && e.target !=  head && e.target.parentNode != customSelect ? select.classList.remove('isActive') :''
		})
		selHide.addEventListener('focusin', e => {showHide(select,customSelect,count,openH)} )

		//compare options
		customSelect.addEventListener('click', e =>  checkActive(e, options, head, select,customSelect,count,openH, selHide) )
		customSelect.addEventListener("keyup", function(e) {
  		e.preventDefault();
			if(e.keyCode === 13) checkActive(e, options, head, select,customSelect,count,openH, selHide)
		});
		options[options.length - 1].addEventListener('focusout', e => {
			if(!select.classList.contains('isActive')) return
			showHide(select,customSelect,count,openH)
		})
	})
}
selectShowHide();
