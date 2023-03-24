const addMenuItem = (menu, menuItem, clickHandler = () =>void(0)) => {

	const linkMenuContainer = document.createElement("li");
	
	const linkMenu = document.createElement("a");
	linkMenu.href = "#";
	linkMenu.addEventListener('click', () => { 
	
		menu.remove();
		clickHandler();
		
	});
	
	linkMenu.appendChild(document.createTextNode(menuItem));
				
	linkMenuContainer.appendChild(linkMenu);

	menu.appendChild(linkMenuContainer);

}

const displayModifyMenu = () => {

	const modifyFormContainer = document.getElementById("modifyFormContainer");
		
	if(document.getElementById("modifyFormContainer").innerHTML!=""){

	} else {
	
		const menuContainer = document.createElement("ul");

		menuContainer.classList.add("modmenu");
		
		//Activities
		
		addMenuItem(menuContainer, "Activities", modifyForms.displayActForm);
		
		//Projects

		addMenuItem(menuContainer, "Projects", modifyForms.displayProjForm);
		
		//Sub-Projects(Cont IDs)

		addMenuItem(menuContainer, "Sub-Projects", modifyForms.displaySubActForm);
		
		addMenuItem(menuContainer, "PU Codes", modifyForms.displayPUForm);
	
		//exit menu

		addMenuItem(menuContainer, "Exit");
		
		modifyFormContainer.appendChild(menuContainer);
	}
}