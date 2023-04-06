const modifyForms = {

	cancelBtn: function(){
		const cancelBtn = document.createElement("input");
		cancelBtn.type = "button";
		cancelBtn.value = "Exit";
		cancelBtn.onclick = () => {
			modifyForms.clearDiv()
			document.getElementById("modifyFormResult").classList.add('hidden');
		};

		return cancelBtn
	},
	clearDiv: function () {

        const listDiv = document.getElementById("modifyFormContainer")

        while(listDiv.firstChild){

            listDiv.removeChild(listDiv.firstChild)

        }

    },
	createCell: function(cellText){
		td = document.createElement("td")
		td. appendChild(document. createTextNode(cellText))
		
		return td
	},
	addUpdateButtons: function(tbl, modForm){
		
		let rows = tbl.rows

		for (let i = 0; i < rows.length; i++) {
			let row = rows[i]
			let curr = rows[i].cells[0].innerHTML
			let cell = row.insertCell(-1)
			
			a = document.createElement("a")
			a.href="#"
			a.addEventListener('click', () => { 
				switch(modForm) {

					case "act":
						modifyForms.displayModifyActForm(curr)
						break
					case "proj":
						modifyForms.displayModifyProjForm(curr)
						break
					case "sub-proj":
						modifyForms.displayModifySubProjForm(curr)
						break
					case "pu":
						modifyForms.displayModifyPUForm(curr)	
						break
					case "lbg":
						modifyForms.displayModifyLocalBtnGroupForm(curr)	
						break
					case "lb":
						modifyForms.displayModifyLocalBtnForm(curr)
						break
				}
			});
			a.appendChild(document.createTextNode("U"))
			cell.appendChild(a)
		}
	},
	addColorBox: function(tbl){
		
		let rows = tbl.rows

		for (let i = 0; i < rows.length; i++) {
			let row = rows[i]
			let clr = rows[i].cells[3].innerHTML
			let cell = row.insertCell(-1)
			cell.style.backgroundColor = clr
			cell.classList.add("clrBox")
		}
	},
	addDropDown: function(obj, elementName, dispField){
	
		const selectElement = document.createElement("select");
			selectElement.name = elementName;
			selectElement.id = elementName;
			selectElement.options[0] = new Option("Select an option", "");
					
			for(i in obj){
				
				selectElement . options [selectElement.options.length] = new Option (obj[i][dispField], i);
					
			}
			
		return selectElement
			
	},
	displayList: function(obj){

		const tbl = document.createElement("table")
		tbl.id = "tblModForm"
		const thead = document.createElement("thead")
		
		const heads = Object.keys((obj[Object.keys(obj)[1]]))

		heads.forEach(element => {
			let th = document.createElement("th")

			th.appendChild(document.createTextNode(element))
			thead.appendChild(th)
		});

		tbl.appendChild(thead)
		
		const tbody = document.createElement("tbody")

		for (i in obj){

			let tr = document.createElement("tr")

			heads.forEach(h => {

				let inp = obj[i][h]

				let td = modifyForms.createCell(inp)	

				tr.appendChild(td)

			})
						
			tbody.appendChild(tr)
		
		}

		tbl.appendChild(tbody)

		return tbl

	},
	displayActForm: function(){

		modifyForms.clearDiv()

		const tbl = modifyForms.displayList(objLAct)

		modifyForms.addUpdateButtons(tbl, "act")

		sd = document.createElement("div")
		
		d = document.getElementById("modifyFormContainer")
		
		const cancelBtn = modifyForms.cancelBtn()

		const newActBtn = document.createElement("input");
			newActBtn.id = "add";
			newActBtn.type = "button";
			newActBtn.value = "Add New";
			newActBtn.onclick = () => {
				
				modifyForms.displayNewActForm()
			};

		d.appendChild(cancelBtn)

		d.appendChild(newActBtn)
			
		d.appendChild(tbl)

	},
	displayProjForm: function(){
	
		modifyForms.clearDiv()

		const tbl = modifyForms.displayList(objLProj)

		modifyForms.addUpdateButtons(tbl, "proj")

		d = document.getElementById("modifyFormContainer")
		
		const cancelBtn = modifyForms.cancelBtn()

		const newProjBtn = document.createElement("input");
			newProjBtn.id = "add";
			newProjBtn.type = "button";
			newProjBtn.value = "Add New";
			newProjBtn.onclick = () => {
				
				modifyForms.displayNewProjForm()
			};

		d.appendChild(cancelBtn)

		d.appendChild(newProjBtn)
			
		d.appendChild(tbl)

	},
	displaySubActForm: function(){
		
		modifyForms.clearDiv()

		const tbl = modifyForms.displayList(objLCont)

		modifyForms.addUpdateButtons(tbl, "sub-proj")

		d = document.getElementById("modifyFormContainer")
		
		const cancelBtn = modifyForms.cancelBtn()

		const newSPBtn = document.createElement("input");
			newSPBtn.id = "add";
			newSPBtn.type = "button";
			newSPBtn.value = "Add New";
			newSPBtn.onclick = () => {
				modifyForms.displayNewSubProjForm()
			};

		d.appendChild(cancelBtn)

		d.appendChild(newSPBtn)
			
		d.appendChild(tbl)

	},
	displayPUForm: function(){
	
		modifyForms.clearDiv()

		const tbl = modifyForms.displayList(objLPU)

		modifyForms.addColorBox(tbl)

		modifyForms.addUpdateButtons(tbl, "pu")

		d = document.getElementById("modifyFormContainer")
		
		const cancelBtn = modifyForms.cancelBtn()

		const newPUBtn = document.createElement("input");
			newPUBtn.id = "add";
			newPUBtn.type = "button";
			newPUBtn.value = "Add New";
			newPUBtn.onclick = () => {
				d.remove()
				modifyForms.displayNewPUForm()
			};

		d.appendChild(cancelBtn)

		d.appendChild(newPUBtn)
			
		d.appendChild(tbl)
	},
	displayLocalBtnGroupForm: function(){

		modifyForms.clearDiv()

		const tbl = modifyForms.displayList(objLocalButtonGroups)

		modifyForms.addUpdateButtons(tbl, "lbg")

		sd = document.createElement("div")
		
		d = document.getElementById("modifyFormContainer")
		
		const cancelBtn = modifyForms.cancelBtn()

		const newLBGBtn = document.createElement("input");
			newLBGBtn.id = "add";
			newLBGBtn.type = "button";
			newLBGBtn.value = "Add New";
			newLBGBtn.onclick = () => {
				modifyForms.displayNewLocalBtnGroupForm()
			};

		d.appendChild(cancelBtn)

		d.appendChild(newLBGBtn)
			
		d.appendChild(tbl)

	},
	displayLocalBtnForm: function(){

		modifyForms.clearDiv()

		const objLB = {}

		for(i in objLocalEventButtons){

			objLB[i] = {idtbllocaleventbtns: [i], Activity: objLAct[objLocalEventButtons[i]["actID"]].ActDesc, SubProject: objLCont[objLocalEventButtons[i]["contid"]].ContDesc, ButtonGroup: objLocalButtonGroups[objLocalEventButtons[i]["localButtonGroup"]].btnGroupName}
			
			if(objLocalEventButtons[i].hasOwnProperty('warn')==true){

				objLB[i].warn = objLocalEventButtons[i].warn

			} else {

				objLB[i].warn = "N/A"

			}

		}

		

		const tbl = modifyForms.displayList(objLB)

		//const tbl = modifyForms.displayList(objLocalEventButtons)

		modifyForms.addUpdateButtons(tbl, "lb")

		sd = document.createElement("div")
		
		d = document.getElementById("modifyFormContainer")
		
		const cancelBtn = modifyForms.cancelBtn()

		const newLBBtn = document.createElement("input");
			newLBBtn.id = "add";
			newLBBtn.type = "button";
			newLBBtn.value = "Add New";
			newLBBtn.onclick = () => {
				modifyForms.displayNewLocalBtnForm()
			};

		d.appendChild(cancelBtn)

		d.appendChild(newLBBtn)
			
		d.appendChild(tbl)

	},
	displayModifyActForm: function(act) {
	
		modifyForms.clearDiv()
	
		const modifyFormContainer = document.getElementById("modifyFormContainer");
	
		const modifyFormResult = document.getElementById("modifyFormResult");

		if(document.getElementById("modifyFormContainer").innerHTML!=""){
			
		} else {

			modifyFormResult.classList.remove("hidden");
		
			const formElement = document.createElement("form");
				formElement.method = "post";
				formElement.action = "./update/updateAct.php";
				formElement.target = "modifyFormResult";
				formElement.id = "updateForm";
				
			const formTitle = document.createElement("h2");
				formTitle.appendChild(document.createTextNode("Update Activity"));
				formElement.appendChild(formTitle);
				
			const inputElementActId = document.createElement("input");
				inputElementActId.name = "ActID"
				inputElementActId.id = "ActID"
				inputElementActId.classList.add("modform")
				inputElementActId.value = act
				inputElementActId.readOnly = true
							
				formElement.appendChild(inputElementActId);
					
			const inputElementActivityName = document.createElement("input")
				inputElementActivityName.type = "text"
				inputElementActivityName.name = "ActDesc"
				inputElementActivityName.value = objLAct[act].ActDesc
				inputElementActivityName.id = "ActDesc"
				formElement.appendChild (inputElementActivityName)
					
			const inputElementUseCode = document.createElement("select");
				inputElementUseCode.name = "UCode";
				inputElementUseCode.id = "UCode";
				inputElementUseCode.options[0] = new Option("Select a Use Code", "");
					
				for(i in objLPU){
					inputElementUseCode . options [inputElementUseCode.options.length] = new Option (objLPU[i].PUCodeDesc, i);
				}
				
				inputElementUseCode.value = objLAct[act].UCode
				
				formElement.appendChild (inputElementUseCode);
			
			const inputElementProfileCode = document.createElement("input");
				inputElementProfileCode.type = "text"
				inputElementProfileCode.name = "PCode"
				inputElementProfileCode.value = objLAct[act].PCode
				inputElementProfileCode.id = "PCode"
				formElement.appendChild (inputElementProfileCode)
			
			const inputElementActivityStatus = document.createElement("input");
				inputElementActivityStatus.type = "text";
				inputElementActivityStatus.name = "Status";
				inputElementActivityStatus.value = objLAct[act].Status
				inputElementActivityStatus.id = "Status";
				formElement.appendChild ( inputElementActivityStatus );
				
			const submitBtn = document.createElement("input");
				submitBtn.type = "submit";
				submitBtn.value = "Submit";
			formElement.appendChild(submitBtn);

			submitBtn.addEventListener("click", () => {

				objLAct[document.getElementById("ActID").value] = {ActID: document.getElementById("ActID").value, ActDesc: document.getElementById("ActDesc").value, PCode: document.getElementById("PCode").value, Status: document.getElementById("Status").value, UCode: document.getElementById("UCode").value }
				
			})
		

			const cancelBtn = modifyForms.cancelBtn()

			formElement.appendChild(cancelBtn);

			modifyFormContainer.appendChild(formElement);
		}	
	},
	displayNewActForm: function(){
		
		modifyForms.clearDiv()

		const actIds ={};
		
		for (a in objLAct) {
			actIds[a.substring(0, 1)] = Number(a.substring(1));
		
		}
		
		const modifyFormContainer = document.getElementById("modifyFormContainer");
		const modifyFormResult = document.getElementById("modifyFormResult");
	
		if(document.getElementById("modifyFormContainer").innerHTML!=""){
	
		} else {
	
			modifyFormResult.classList.remove("hidden");
		
			const formElement = document.createElement("form");
				formElement.method = "post";
				formElement.action = "./add/addAct.php";
				formElement.target = "modifyFormResult";
				formElement.id = "actForm";
				
			const formTitle = document.createElement("h2");
				formTitle.appendChild(document.createTextNode("New Activity"));
				formElement.appendChild(formTitle);
				
			const inputElementUseCode = document.createElement("select");
				inputElementUseCode.name = "UCode";
				inputElementUseCode.placeholder = "Use Code";
				inputElementUseCode.id = "UCode";
				inputElementUseCode.options[0] = new Option("Select a Use Code", "");
					
			for(i in objLPU){
				inputElementUseCode.options[inputElementUseCode.options.length] = new Option(objLPU[i].PUCodeDesc, i);
			}
	
			inputElementUseCode.addEventListener('change', () => { 
				
				let lastNum;
				
				const pcode = inputElementUseCode.value;
				
				if(actIds[inputElementUseCode.value]){
				
					lastNum = (actIds[inputElementUseCode.value]);
				
				} else { 
				
					lastNum = 0;
				
				}
				
				let nextNum = lastNum+1;
				
				if( nextNum < 10  ) {
				
					nextNum = "0"+nextNum;
				
				} else {
				
					nextNum = String(nextNum);
				
				}
				
				nextNum = pcode+nextNum;
				
				const actIdInput  = document.getElementById("ActID");
				
				actIdInput.value=nextNum;
				
			});
			
			formElement. appendChild(inputElementUseCode);
					
			const inputElementActId = document.createElement("input");
				inputElementActId.type = "text";
				inputElementActId.name = "ActID";
				inputElementActId.id = "ActID";
				inputElementActId.placeholder = "ActID";
				formElement.appendChild(inputElementActId);
			
			const inputElementActivityName = document.createElement("input");
			
				inputElementActivityName.type = "text";
				inputElementActivityName.name = "ActDesc";
				inputElementActivityName.placeholder = "Activity Name";
				inputElementActivityName.id = "ActDesc";
				formElement.appendChild(inputElementActivityName);
			
			const fieldsetElement = document.createElement("fieldset");
			
			const legendElement = document.createElement("legend");
				legendElement.appendChild(document.createTextNode("Profile Codes"));
				fieldsetElement.appendChild(legendElement);
	
			for(i in objLPU){
				let checkbox = document.createElement("input");
					checkbox.type = "checkbox";
					checkbox.id = "PCode-"+i;
					checkbox.name = "PCode[]";
					checkbox.value = i;
				let label = document.createElement("label");
					label.htmlFor = i;
					label.appendChild(document.createTextNode(objLPU[i].PUCodeDesc));
				
				label.appendChild(checkbox);
				fieldsetElement.appendChild(label);
			}
			
			formElement.appendChild(fieldsetElement);
						
			const submitBtn = document.createElement("input");
				submitBtn.type = "submit";
				submitBtn.value = "Submit";
				formElement.appendChild(submitBtn);
	
			submitBtn.addEventListener("click", () => {
	
				let cntCheckedBoxes = document.querySelectorAll('input[name="PCode[]"]:checked').length
	
				let varCode = "";
	
				for (i=0; i<cntCheckedBoxes; i++) {
	
					varCode += document.querySelectorAll('input[name="PCode[]"]:checked')[i].value;
	
				}
	
				objLAct[document.getElementById("ActID").value] = {ActID: document.getElementById("ActID").value, ActDesc: document.getElementById("ActDesc").value, PCode: varCode, Status: "Active", UCode: document.getElementById("UCode").value }
				//formElement.reset()
	
			})
	
			const cancelBtn = modifyForms.cancelBtn()

			formElement.appendChild(cancelBtn);

			modifyFormContainer.appendChild(formElement);
		}	
	},
	displayModifyProjForm: function(proj){
		
		modifyForms.clearDiv()
	
		const modifyFormContainer = document.getElementById("modifyFormContainer");
		
		const modifyFormResult = document.getElementById("modifyFormResult");
	
		if(document.getElementById("modifyFormContainer").innerHTML!=""){

		} else {
	
			modifyFormResult.classList.remove("hidden");
		
			const formElement = document.createElement("form");
				formElement.method = "post";
				formElement.action = "./update/updateProj.php";
				formElement.target = "modifyFormResult";
				formElement.id = "projForm";
				
			const formTitle = document.createElement("h2")
				formTitle.appendChild(document.createTextNode("Update Project"))
				formElement.appendChild(formTitle)
	
			const inputElementProjId = document.createElement("input")
				inputElementProjId.type = "text"	
				inputElementProjId.name = "ProjID"
				inputElementProjId.id = "ProjID"
				inputElementProjId.value = objLProj[proj].ProjID
				inputElementProjId.readOnly = true
				
			formElement.appendChild(inputElementProjId);
			
			const inputElementProjName = document.createElement("input");
				inputElementProjName.type = "text";
				inputElementProjName.name = "ProjDesc";
				inputElementProjName.value = objLProj[proj].ProjDesc
				inputElementProjName.id = "ProjDesc";
				formElement.appendChild(inputElementProjName);
	
	
			const inputElementProjStatus = document.createElement("input");
				inputElementProjStatus.type = "text";
				inputElementProjStatus.name = "ProjStatus";
				inputElementProjStatus.value = objLProj[proj].ProjStatus
				inputElementProjStatus.id = "ProjStatus";
				formElement.appendChild(inputElementProjStatus);
				
			const inputElementProfileCode = document.createElement("select");
				inputElementProfileCode.name = "PCode";
				inputElementProfileCode.placeholder = "Profile Code";
				inputElementProfileCode.id = "PCode";
				inputElementProfileCode.options[0] = new Option("Select a Profile Code", "");
					
				for(i in objLPU){
					inputElementProfileCode.options[inputElementProfileCode.options.length] = new Option(objLPU[i].PUCodeDesc, i);
				}

				inputElementProfileCode.value = objLProj[proj].ProfileCode

				formElement.appendChild(inputElementProfileCode);
			
			const submitBtn = document.createElement("input");
				submitBtn.type = "submit";
				submitBtn.value = "Submit";
			formElement.appendChild(submitBtn);
				
			submitBtn.addEventListener("click", () => {

				objLProj[document.getElementById("ProjID").value] = {ProjID: document.getElementById("ProjID").value, ProjDesc: document.getElementById("ProjDesc").value, ProfileCode: document.getElementById("PCode").value, ProjStatus: document.getElementById("ProjStatus").value }

			})
		
			const cancelBtn = modifyForms.cancelBtn()
			
			formElement.appendChild(cancelBtn);
			
			modifyFormContainer.appendChild(formElement);
		}
		
	},
	displayNewProjForm: function(){
	
		modifyForms.clearDiv()

		const modifyFormContainer = document.getElementById("modifyFormContainer");

		const modifyFormResult = document.getElementById("modifyFormResult");
	
		if(document.getElementById("modifyFormContainer").innerHTML!=""){
	
		} else {
	
			modifyFormResult.classList.remove("hidden");
		
			const formElement = document.createElement("form");
				formElement.method = "post";
				formElement.action = "./add/addProj.php";
				formElement.target = "modifyFormResult";
				formElement.id = "projForm";
				
			const formTitle = document.createElement("h2");
				formTitle.appendChild(document.createTextNode("New Project"));
				formElement.appendChild(formTitle);
	
			const inputElementProjId = document.createElement("input");
				inputElementProjId.type = "text";
				inputElementProjId.name = "ProjID";
				inputElementProjId.id = "ProjID";
				inputElementProjId.placeholder = "ProjID";
			formElement.appendChild(inputElementProjId);
			
			const inputElementProjName = document.createElement("input");
				inputElementProjName.type = "text";
				inputElementProjName.name = "ProjDesc";
				inputElementProjName.placeholder = "Project Name";
				inputElementProjName.id = "ProjDesc";
			formElement.appendChild(inputElementProjName);
				
			const inputElementProfileCode = document.createElement("select");
				inputElementProfileCode.name = "PCode";
				inputElementProfileCode.placeholder = "Profile Code";
				inputElementProfileCode.id = "PCode";
				inputElementProfileCode.options[0] = new Option("Select a Profile Code", "");
					
				for(i in objLPU){
					
					inputElementProfileCode.options[inputElementProfileCode.options.length] = new Option(objLPU[i].PUCodeDesc, i);
				}
				
			formElement.appendChild(inputElementProfileCode);
			
			const submitBtn = document.createElement("input");
				submitBtn.type = "submit";
				submitBtn.value = "Submit";
			formElement.appendChild(submitBtn);
			
			submitBtn.addEventListener("click", () => {
	
				objLProj[document.getElementById("ProjID").value] = {ProjID: document.getElementById("ProjID").value, ProjDesc: document.getElementById("ProjDesc").value, ProfileCode: document.getElementById("PCode").value, ProjStatus: "Active" }
				
				//formElement.reset()
			})
	
			const cancelBtn = modifyForms.cancelBtn()

			formElement.appendChild(cancelBtn);

			modifyFormContainer.appendChild(formElement);
		}
		
	},
	displayModifySubProjForm: function(sp){

		modifyForms.clearDiv()
	
		const modifyFormContainer = document.getElementById("modifyFormContainer");
		
		const modifyFormResult = document.getElementById("modifyFormResult");
	
		if(document.getElementById("modifyFormContainer").innerHTML!=""){
	
		} else {
	
			modifyFormResult.classList.remove("hidden");
		
			const formElement = document.createElement("form");
				formElement.method = "post";
				formElement.action = "./update/updateSubProj.php";
				formElement.target = "modifyFormResult";
				formElement.id = "newSubProjForm";
				
			const formTitle = document.createElement("h2");
				formTitle.appendChild(document.createTextNode("Update Sub Project"));
				formElement.appendChild(formTitle);
	
			const inputElementSubProjId = document.createElement("input")
				inputElementSubProjId.type = "text"
				inputElementSubProjId.name = "ContID"
				inputElementSubProjId.id = "ContID"
				inputElementSubProjId.value = objLCont[sp].ContID
				inputElementSubProjId.readOnly = true
			
			formElement.appendChild(inputElementSubProjId)
			
				const inputElementProjId = document.createElement("input")
				inputElementProjId.type = "text"
				inputElementProjId.name = "ProjID"
				inputElementProjId.id = "ProjID"
				inputElementProjId.value = objLCont[sp].ProjID
				inputElementProjId.readOnly = true
			
			formElement.appendChild(inputElementProjId)
	
			const inputElementSubProjName = document.createElement("input");
				inputElementSubProjName.type = "text";
				inputElementSubProjName.name = "ContDesc";
				inputElementSubProjName.value = objLCont[sp].ContDesc
				inputElementSubProjName.id = "ContDesc";
			formElement.appendChild(inputElementSubProjName);
				
			const inputElementActive = document.createElement("input");
				inputElementActive.type = "text";
				inputElementActive.name = "Active";
				inputElementActive.value = objLCont[sp].Active
				inputElementActive.id = "Active";
			formElement.appendChild(inputElementActive);

			const submitBtn = document.createElement("input");
				submitBtn.id = "btnSubmit";
				submitBtn.type = "submit";
				submitBtn.value = "Submit";
			formElement.appendChild(submitBtn);

			submitBtn.addEventListener("click", () => {

				objLCont[document.getElementById("ContID").value] = {ContID: document.getElementById("ContID").value, ContDesc: document.getElementById("ContDesc").value, ProjID: document.getElementById("ProjID").value, Active: "Y" }

			})

			const cancelBtn = modifyForms.cancelBtn()
	
			formElement.appendChild(cancelBtn);

			modifyFormContainer.appendChild(formElement);
		}	
		
	},
	displayNewSubProjForm: function(){
		modifyForms.clearDiv()

		const modifyFormContainer = document.getElementById("modifyFormContainer");
		
		const modifyFormResult = document.getElementById("modifyFormResult");
	
		if(document.getElementById("modifyFormContainer").innerHTML!=""){
	
		} else {
	
			modifyFormResult.classList.remove("hidden");
		
			const formElement = document.createElement("form");
				formElement.method = "post";
				formElement.action = "./add/addSubProj.php";
				formElement.target = "modifyFormResult";
				formElement.id = "newSubProjForm";
				
			const formTitle = document.createElement("h2");
				formTitle.appendChild(document.createTextNode("New Sub Project"));
				formElement.appendChild(formTitle);
	
			const inputElementProjId = document.createElement("select");
				inputElementProjId.name = "ProjID";
				inputElementProjId.id = "ProjID";
				inputElementProjId.options[0] = new Option("Select a Project", "");
					
				for(i in objLProj){
					if(objLProj[i].ProjStatus!="Closed"){
						inputElementProjId.options[inputElementProjId.options.length] = new Option(objLProj[i].ProjDesc, i);
					}
				}
				
				formElement.appendChild(inputElementProjId);
	
			const inputElementSubProjId = document.createElement("input");
				inputElementSubProjId.type = "text";
				inputElementSubProjId.name = "ContID";
				inputElementSubProjId.id = "ContID";
				inputElementSubProjId.placeholder = "Sub-Proj ID";
				formElement.appendChild(inputElementSubProjId);
			
			const inputElementSubProjName = document.createElement("input");
				inputElementSubProjName.type = "text";
				inputElementSubProjName.name = "ContDesc";
				inputElementSubProjName.placeholder = "Sub Project Name";
				inputElementSubProjName.id = "ContDesc";
				formElement.appendChild(inputElementSubProjName);
						
			const submitBtn = document.createElement("input");
				submitBtn.type = "submit";
				submitBtn.value = "Submit";
				formElement.appendChild(submitBtn);

			
			submitBtn.addEventListener("click", () => {

				objLCont[document.getElementById("ContID").value] = {ContID: document.getElementById("ContID"), ContDesc: document.getElementById("ContDesc").value, ProjID: document.getElementById("ProjID").value, Active: "Active" }

				//formElement.reset()
	
			})
		
			
	
			const cancelBtn = modifyForms.cancelBtn()
			
			formElement.appendChild(cancelBtn);
					
			modifyFormContainer.appendChild(formElement);
		}	
	
	},
	displayModifyPUForm: function(pu){
		modifyForms.clearDiv()

		const modifyFormContainer = document.getElementById("modifyFormContainer");
		
		const modifyFormResult = document.getElementById("modifyFormResult");
	
		if(document.getElementById("modifyFormContainer").innerHTML!=""){
	
		} else {
	
			modifyFormResult.classList.remove("hidden");
		
			const formElement = document.createElement("form");
				formElement.method = "post";
				formElement.action = "./update/updatePU.php";
				formElement.target = "modifyFormResult";
				formElement.id = "modifyPUForm";
				
			const formTitle = document.createElement("h2");
				formTitle.appendChild(document.createTextNode("Update PU Code"));
				formElement.appendChild(formTitle);
	
			const inputElementPUCode = document.createElement("input");
				inputElementPUCode.type = "text"
				inputElementPUCode.name = "PUCode";
				inputElementPUCode.id = "PUCode";
				inputElementPUCode.classList.add("modform")
				inputElementPUCode.value = objLPU[pu].PUCode
				inputElementPUCode.readOnly = true


			formElement.appendChild(inputElementPUCode);
			
			const inputElementPUCodeDesc = document.createElement("input");
				inputElementPUCodeDesc.type = "text";
				inputElementPUCodeDesc.name = "PUCodeDesc";
				inputElementPUCodeDesc.id = "PUCodeDesc";
				inputElementPUCodeDesc.value = objLPU[pu].PUCodeDesc
			
			formElement.appendChild(inputElementPUCodeDesc);
	
			const inputElementColor = document.createElement("input");
				inputElementColor.type = "color";
				inputElementColor.name = "Color";
				inputElementColor.value = objLPU[pu].Color
				inputElementColor.id = "Color";
			formElement.appendChild(inputElementColor);

			const inputElementActive = document.createElement("select");
				inputElementActive.name = "Active";
				inputElementActive.value = objLPU[pu].Active
				inputElementActive.id = "Active";
				inputElementActive.options[0] = new Option("Y");
				inputElementActive.options[1] = new Option("N");

			formElement.appendChild(inputElementActive);
				
			const submitBtn = document.createElement("input");
				submitBtn.id = "btnSubmit";
				submitBtn.type = "submit";
				submitBtn.value = "Submit";
			formElement.appendChild(submitBtn);

			submitBtn.addEventListener("click", () => {

				objLCont[document.getElementById("PUCode").value] = {PUCode: document.getElementById("PUCode"), PUCodeDesc: document.getElementById("PUCodeDesc").value, Color: document.getElementById("Color").value }

				//formElement.reset()
	
			})

			const cancelBtn = modifyForms.cancelBtn()
	
			formElement.appendChild(cancelBtn);

			modifyFormContainer.appendChild(formElement);
		}	

	},
	displayNewPUForm: function(){
		modifyForms.clearDiv()

		const modifyFormContainer = document.getElementById("modifyFormContainer");
		
		const modifyFormResult = document.getElementById("modifyFormResult");
	
		if(document.getElementById("modifyFormContainer").innerHTML!=""){
	
		} else {
	
			modifyFormResult.classList.remove("hidden");
		
			const formElement = document.createElement("form");
				formElement.method = "post";
				formElement.action = "./add/addPU.php";
				formElement.target = "modifyFormResult";
				formElement.id = "addPUForm";
				
			const formTitle = document.createElement("h2");
				formTitle.appendChild(document.createTextNode("New PU Code"));
				formElement.appendChild(formTitle);
	
			const inputElementPUCode = document.createElement("input");
				inputElementPUCode.type = "text";
				inputElementPUCode.name = "PUCode";
				inputElementPUCode.id = "PUCode";
				inputElementPUCode.placeholder = "PU Code";
			formElement.appendChild(inputElementPUCode);
			
			const inputElementPUCodeDesc = document.createElement("input");
				inputElementPUCodeDesc.type = "text";
				inputElementPUCodeDesc.name = "PUCodeDesc";
				inputElementPUCodeDesc.placeholder = "PU Code Description";
				inputElementPUCodeDesc.id = "PUCodeDesc";
			formElement.appendChild(inputElementPUCodeDesc);
				
			const inputElementColor = document.createElement("input");
				inputElementColor.type = "text";
				inputElementColor.name = "Color";
				inputElementColor.placeholder = "Color";
				inputElementColor.id = "Color";
				formElement.appendChild(inputElementColor);
			
			const submitBtn = document.createElement("input");
				submitBtn.type = "submit";
				submitBtn.value = "Submit";
				formElement.appendChild(submitBtn);
	
				const cancelBtn = modifyForms.cancelBtn()

				formElement.appendChild(cancelBtn);

			modifyFormContainer.appendChild(formElement);
		}
	},
	displayModifyLocalBtnGroupForm: function(lbg){
		
		modifyForms.clearDiv()

		const modifyFormContainer = document.getElementById("modifyFormContainer");
		
		const modifyFormResult = document.getElementById("modifyFormResult");
	
		if(document.getElementById("modifyFormContainer").innerHTML!=""){
	
		} else {
			
			modifyFormResult.classList.remove("hidden");
		
			const formElement = document.createElement("form");
				formElement.method = "post";
				formElement.action = "./update/updateLBG.php";
				formElement.target = "modifyFormResult";

				
			const formTitle = document.createElement("h2");
				formTitle.appendChild(document.createTextNode("Update Local Button Group"));
				formElement.appendChild(formTitle);
	
			const inputElementBtnGroup = document.createElement("input");
				inputElementBtnGroup.type = "text"
				inputElementBtnGroup.name = "btnGroup";
				inputElementBtnGroup.id = "btnGroup";
				inputElementBtnGroup.classList.add("modform")
				inputElementBtnGroup.value = objLocalButtonGroups[lbg].btnGroup
				inputElementBtnGroup.readOnly = true

			formElement.appendChild(inputElementBtnGroup);
			
			const inputElementBtnGroupName = document.createElement("input");
			inputElementBtnGroupName.type = "text";
			inputElementBtnGroupName.name = "btnGroupName";
			inputElementBtnGroupName.id = "btnGroupName";
			inputElementBtnGroupName.value = objLocalButtonGroups[lbg].btnGroupName
			
			formElement.appendChild(inputElementBtnGroupName);
					
			const submitBtn = document.createElement("input");
				submitBtn.id = "btnSubmit";
				submitBtn.type = "submit";
				submitBtn.value = "Submit";
			formElement.appendChild(submitBtn);

			submitBtn.addEventListener("click", () => {

				objLocalButtonGroups[document.getElementById("btnGroup").value] = {btnGroup: document.getElementById("btnGroup"), btnGroupName: document.getElementById("btnGroupName").value }

				//formElement.reset()
	
			})

			const cancelBtn = modifyForms.cancelBtn()
	
			formElement.appendChild(cancelBtn);

			modifyFormContainer.appendChild(formElement);
		}	
	},
	displayNewLocalBtnGroupForm: function(){

		modifyForms.clearDiv()

		const modifyFormContainer = document.getElementById("modifyFormContainer");

		const modifyFormResult = document.getElementById("modifyFormResult");
	
		if(document.getElementById("modifyFormContainer").innerHTML!=""){
	
		} else {
	
			modifyFormResult.classList.remove("hidden");
		
			const formElement = document.createElement("form");
				formElement.method = "post";
				formElement.action = "./add/addLBG.php";
				formElement.target = "modifyFormResult";
				
			const formTitle = document.createElement("h2");
				formTitle.appendChild(document.createTextNode("New Local Button Group"));
				formElement.appendChild(formTitle);
	
			const inputElementBtnGroup = document.createElement("input");
				inputElementBtnGroup.type = "text";
				inputElementBtnGroup.name = "btnGroup";
				inputElementBtnGroup.id = "btnGroup";
				inputElementBtnGroup.placeholder = "Button Group ID";
			formElement.appendChild(inputElementBtnGroup);
			
			const inputElementBtnGroupName = document.createElement("input");
				inputElementBtnGroupName.type = "text";
				inputElementBtnGroupName.name = "btnGroupName";
				inputElementBtnGroupName.placeholder = "Button Group Name";
				inputElementBtnGroupName.id = "btnGroupName";
			formElement.appendChild(inputElementBtnGroupName);
				
			
			const submitBtn = document.createElement("input");
				submitBtn.type = "submit";
				submitBtn.value = "Submit";
			formElement.appendChild(submitBtn);
			
			submitBtn.addEventListener("click", () => {
	
				//objLProj[document.getElementById("ProjID").value] = {ProjID: document.getElementById("ProjID").value, ProjDesc: document.getElementById("ProjDesc").value, ProfileCode: document.getElementById("PCode").value, ProjStatus: "Active" }
				
				//formElement.reset()
			})
			
			const cancelBtn = modifyForms.cancelBtn()

			formElement.appendChild(cancelBtn);

			modifyFormContainer.appendChild(formElement);
		}

	},
	displayModifyLocalBtnForm: function(lb){

		modifyForms.clearDiv()

		const modifyFormContainer = document.getElementById("modifyFormContainer");
		
		const modifyFormResult = document.getElementById("modifyFormResult");
	
		if(document.getElementById("modifyFormContainer").innerHTML!=""){
	
		} else {
			
			modifyFormResult.classList.remove("hidden");
		
			const formElement = document.createElement("form");
				formElement.method = "post";
				formElement.action = "./update/updateLB.php";
				formElement.target = "modifyFormResult";
				
			const formTitle = document.createElement("h2");
				formTitle.appendChild(document.createTextNode("Update Local Button"));
				formElement.appendChild(formTitle);
	
			const inputElementId = document.createElement("input");
				inputElementId.type = "text"
				inputElementId.name = "idtbllocaleventbtns";
				inputElementId.id = "idtbllocaleventbtns";
				inputElementId.classList.add("modform")
				inputElementId.value = objLocalEventButtons[lb].idtbllocaleventbtns
				inputElementId.readOnly = true

			formElement.appendChild(inputElementId);
						
			const inputElementActId = document.createElement("input");
				inputElementActId.type = "text";
				inputElementActId.name = "actID";
				inputElementActId.id = "actID";
				inputElementActId.value = objLocalEventButtons[lb].actID
			
			formElement.appendChild(inputElementActId);

			const inputElementContId = document.createElement("input");
				inputElementContId.type = "text";
				inputElementContId.name = "contID";
				inputElementContId.id = "contID";
				inputElementContId.value = objLocalEventButtons[lb].contid
		
			formElement.appendChild(inputElementContId);

			const inputElementLocalBtnGroup = document.createElement("input");
				inputElementLocalBtnGroup.type = "text";
				inputElementLocalBtnGroup.name = "localbtngroup";
				inputElementLocalBtnGroup.id = "localbtngroup";
				inputElementLocalBtnGroup.value = objLocalEventButtons[lb].localButtonGroup

			formElement.appendChild(inputElementLocalBtnGroup);

			const inputElementWarn = document.createElement("input");
				inputElementWarn.type = "text";
				inputElementWarn.name = "warn";
				inputElementWarn.id = "warn";
				inputElementWarn.placeholder = "Warning Time";
				inputElementWarn.value = objLocalEventButtons[lb].warn

			formElement.appendChild(inputElementWarn);

			const submitBtn = document.createElement("input");
				submitBtn.id = "btnSubmit";
				submitBtn.type = "submit";
				submitBtn.value = "Submit";
			formElement.appendChild(submitBtn);

			submitBtn.addEventListener("click", () => {

				objLocalEventButtons[document.getElementById("idtbllocaleventbtns").value] = {idtbllocaleventbtns: document.getElementById("idtbllocaleventbtns"), actID: document.getElementById("actID").value, contid: document.getElementById("contID").value, localButtonGroup: document.getElementById("localbtngroup").value, warn: document.getElementById("warn").value }

				//formElement.reset()
	
			})

			const cancelBtn = modifyForms.cancelBtn()
	
			formElement.appendChild(cancelBtn);

			modifyFormContainer.appendChild(formElement);
		}

	},
	displayNewLocalBtnForm: function(){
		
		modifyForms.clearDiv()

		const modifyFormContainer = document.getElementById("modifyFormContainer");
		
		const modifyFormResult = document.getElementById("modifyFormResult");
	
		if(document.getElementById("modifyFormContainer").innerHTML!=""){
	
		} else {
			
			modifyFormResult.classList.remove("hidden");
		
			const formElement = document.createElement("form");
				formElement.method = "post";
				formElement.action = "./add/addLB.php";
				formElement.target = "modifyFormResult";
				
			const formTitle = document.createElement("h2");
				formTitle.appendChild(document.createTextNode("New Local Button"));
				formElement.appendChild(formTitle);
			
			const nextIndex = Math.max(...Object.keys(objLocalEventButtons))+1

			const objSelAct = {}
			const arrAct = []
			
			for (i in objLAct){
			
				if(objLAct[i]["Status"]=="Active") {
				
					arrAct.push([objLAct[i]["ActDesc"], i])
				
				}
			
			}
			
			arrAct.sort()
			
			for(i=0; i<arrAct.length; i++){
			
				objSelAct[arrAct[i][1]] = {actID: arrAct[i][1], ActDesc: arrAct[i][0]}
			
			}
			
			
			const inputElementActId = modifyForms.addDropDown(objSelAct,  "actID", "ActDesc")
			formElement.appendChild(inputElementActId);
			
			const objSelCont = {}
			const arrCont = []
			
			for (i in objLCont){
			
				if(objLCont[i].Active=="Y" && objLProj[objLCont[i]["ProjID"]]["ProjStatus"]!="Closed"){
				
					arrCont.push([objLProj[objLCont[i]["ProjID"]]["ProjDesc"]+": "+objLCont[i]["ContDesc"], i])
				
				}
				
			}
			
			arrCont.sort()
			
			for(i=0; i<arrCont.length; i++){
			
				objSelCont[arrCont[i][1]] = {contID: arrCont[i][1], contDesc: arrCont[i][0]}
			
			}
			
			const inputElementContId = modifyForms.addDropDown(objSelCont,  "contID", "contDesc")
			formElement.appendChild(inputElementContId);

			const inputElementLocalBtnGroup = modifyForms.addDropDown(objLocalButtonGroups,  "localbtngroup", "btnGroupName")
			formElement.appendChild(inputElementLocalBtnGroup);

			const inputElementWarn = document.createElement("input");
				inputElementWarn.type = "text";
				inputElementWarn.name = "warn";
				inputElementWarn.placeholder = "Warning Time";
				inputElementWarn.id = "warn";
			formElement.appendChild(inputElementWarn);
					
			const submitBtn = document.createElement("input");
				submitBtn.id = "btnSubmit";
				submitBtn.type = "submit";
				submitBtn.value = "Submit";
			formElement.appendChild(submitBtn);

			submitBtn.addEventListener("click", () => {

				objLocalEventButtons[nextIndex] = {idtbllocaleventbtns: nextIndex, actID: document.getElementById("actID").value, contid: document.getElementById("contID").value, localButtonGroup: document.getElementById("localbtngroup").value, warn: document.getElementById("warn").value }

				//formElement.reset()
	
			})

			const nextBtn = document.createElement("input");
			nextBtn.type = "button";
			nextBtn.value = "Next";
			nextBtn.onclick = () => {
				modifyForms.clearDiv()
				document.getElementById("modifyFormResult").classList.add('hidden');
				modifyForms.displayLocalBtnForm()
			};
	
			formElement.appendChild(nextBtn)

			const cancelBtn = modifyForms.cancelBtn()
	
			formElement.appendChild(cancelBtn);

			modifyFormContainer.appendChild(formElement);
		}

	}

}

