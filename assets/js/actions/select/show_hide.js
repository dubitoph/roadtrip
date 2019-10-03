export function showHide(select,customSelect,count,openH){
	select.classList.toggle('isActive');
  const top = document.defaultView.getComputedStyle(customSelect, "").paddingTop
	const bottom = document.defaultView.getComputedStyle(customSelect, "").paddingBottom
	const total = Number(openH) + Number(top.replace('px', '')) + Number(bottom.replace('px', ''))
	customSelect.style.height = count === false ? total + 'px' :  0 + 'px'
	count = !count
}
