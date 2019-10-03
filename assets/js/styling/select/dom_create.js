export function domCreate(tag, className, attrs, append, text){
	const obj = document.createElement(tag);
	if(className) obj.classList.add(className)
	if(attrs) for (var key in attrs) { obj.setAttribute(key, attrs[key]) }
	if(text) obj.innerHTML = text
	append.appendChild(obj)
	return obj
}
