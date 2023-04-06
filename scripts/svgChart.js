const objSVGEventChart = {

	chartDiv: 0,
	svgHeight: 50,
	textColor: "white",
	fontWeight: "bold",
	displayTimes: [12, 3, 6, 9, 12, 3, 6, 9],
	svgWidth: screen.width,
	moodColor: function(mood){

		switch(Number(mood)){
		
			case -1:
				clr = "red";
				break;
			case -0.5:
				clr = "yellow";
				break;
			case 0:
				clr = "gray";
				break;
			case 0.5:
				clr = "yellowgreen";
				break;
			case 1:
				clr = "green";
				break;
		}
	
		return clr;
	},
	makeListObj: function(obj, type){

		for(i in obj){
			objSVGList[i] = {startTime: obj[i][startTime], startX: this.getStartXCoord(obj[1][startTime]), width: (obj.dur/(24*60*60*1000)*this.svgWidth)}
		}
		if(type=="mood"){
			objSVGList[i]["fill"] = this.moodColor(obj[i].mood)
		} else {
			objSVGList[i]["fill"] = objLPU[objAct[ActID].UCode].Color
		}

	},
	drawBox: function(id, x, w, f){

		var element = document.getElementById(id);

		var svg = document.createElementNS("http://www.w3.org/2000/svg", "rect");
	
		svg.setAttribute('x', x);
		svg.setAttribute('y', 0);
		svg.setAttribute('width', w);
		svg.setAttribute('height', this.svgHeight);
		svg.setAttribute('fill', f);
			
		svg.setAttributeNS("http://www.w3.org/2000/xmlns/", "xmlns:xlink", "http://www.w3.org/1999/xlink");
			
		element.appendChild(svg);


	},
	addText: function(id){

		const element = document.getElementById(id);

		const svgTextElement = document.createElementNS("http://www.w3.org/2000/svg", "text");
	
		svgTextElement.setAttribute('x', 0);
		svgTextElement.setAttribute('y', 27.5);
		svgTextElement.setAttribute('fill', 'white');
		svgTextElement.setAttribute('font-weight', 'bold');
		svgTextElement.setAttribute('font-size', 10);
	
		let textNode = document.createTextNode("12A");
	
		svgTextElement.appendChild(textNode);
	
		this.displayTimes.forEach(t => {

			let xCoord = t*120;
	
			const tspanElement = document.createElementNS("http://www.w3.org/2000/svg", "tspan");
	
			tspanElement.setAttribute('x', xCoord);
			tspanElement.setAttribute('y', 27.5);
	
			textNode = document.createTextNode(t);
			tspanElement.appendChild(textNode);
			svgTextElement.appendChild(ts);


		});
		
		svgTextElement.setAttributeNS("http://www.w3.org/2000/xmlns/", "xmlns:xlink", "http://www.w3.org/1999/xlink");
	
		element.appendChild(svgTextElement);


	},
	getStartXCoord: function(startTime){

		let minTime = new Date();

		minTime.setHours(0, 0, 0, 0);
		
		var svgboxstartxcoord = ((startTime-minTime)/(24*60*60*1000))*svgWidthNum;
		
		return svgboxstartxcoord;
	},
	showChart: function(){

		if(i>0){
				
			var boxStart = svgboxstartxcoord(Date.parse(LMoods[i-1][0]));
		
		}else{
	
			var boxStart = svgboxstartxcoord(Date.parse(LMoods[i][0]));
		
		}
	
		//var boxId = "svgMoodChart";
		var boxStartX = svgboxstartxcoord(Date.parse(LMoods[i][0]));
		var boxWidth = (eventLength / (24*60*60*1000))*svgWidthNum;
		var boxFill = moodColor(LMoods[i][1]);
		
		if(boxStartX<0){
		
			if(boxStart>0){
			
				drawbox(boxId, 0, boxStart, boxFill);
			
			}
		
		}

		if(boxWidth>0){
		
			drawbox(Chartid, boxStartX, boxWidth, boxFill);

		}
	}

}

//determines the color of each box on the event chart
//**CAN BE REPLACED BY objLPU[objAct[ActID].UCode].Color**
function findActivityColor(ActID){
	
	var arrAct = LActs[0];

	var ans = $.inArray(ActID, arrAct);

	var PU = LActs[3][ans];
	
	var arrLPU = LPU[0];
	
	var an2 = $.inArray(PU, arrLPU);
	
	var clr = LPU[2][an2];
	
	return clr;
}

//sets the colors for the boxes in the mood chart

function moodColor(mood){

	switch(Number(mood)){
	
		case -1:
			clr = "red";
			break;
		case -0.5:
			clr = "yellow";
			break;
		case 0:
			clr = "gray";
			break;
		case 0.5:
			clr = "yellowgreen";
			break;
		case 1:
			clr = "green";
			break;
	}

	return clr;
}

//determines the starting x coord of each colored box in the svg charts

function svgboxstartxcoord(time){

	let minTime = new Date();
	minTime.setHours(0, 0, 0, 0);
	
	var svgboxstartxcoord = ((time-minTime)/(24*60*60*1000))*svgWidthNum;
	
	return svgboxstartxcoord;
}

//Draws colored boxes in svg charts

function drawbox(id, x, w, f){

	var element = document.getElementById(id);

	var svg = document.createElementNS("http://www.w3.org/2000/svg", "rect");

	svg.setAttribute('x', x);
	svg.setAttribute('y', 0);
	svg.setAttribute('width', w);
	svg.setAttribute('height', 50);
	svg.setAttribute('fill', f);
		
	svg.setAttributeNS("http://www.w3.org/2000/xmlns/", "xmlns:xlink", "http://www.w3.org/1999/xlink");
		
	element.appendChild(svg);
}

//Adds times to foreground of svg charts

function svgtext(id){

	var element = document.getElementById(id);

	var svg = document.createElementNS("http://www.w3.org/2000/svg", "text");

	svg.setAttribute('x', 0);
	svg.setAttribute('y', 20);
	svg.setAttribute('fill', 'white');
	svg.setAttribute('font-weight', 'bold');
	svg.setAttribute('font-size', 10);
	
	let spacing = svgWidthNum / 24

	arrTimes = [12, "|", "|", 3, "|", "|", 6, "|", "|", 9, "|", "|", 12, "|", "|", 3, "|", "|", 6, "|", "|", 9, "|", "|", 12]
	


	for (c = 0; c < arrTimes.length; c++){

		var xv = c*spacing;

		var ts = document.createElementNS("http://www.w3.org/2000/svg", "tspan");

		ts.setAttribute('x', xv);
		ts.setAttribute('y', 20);

		var txt = document.createTextNode(arrTimes[c]);
		ts.appendChild(txt);
		svg.appendChild(ts);

	}

	svg.setAttributeNS("http://www.w3.org/2000/xmlns/", "xmlns:xlink", "http://www.w3.org/1999/xlink");

	element.appendChild(svg);
}

function resetSVG(id){
	
	id = "#"+id;
	
	$(id).empty();
}

function displaySVGChart(){

	if(i>0){
        
		var at = svgboxstartxcoord(Date.parse(LEvents[i-1][0]));
		
		
	}else{
	
		var at = svgboxstartxcoord(Date.parse(LEvents[i][0]));
	
	}
	
	var ac0 = "svgEventChart";
	var ac1 = svgboxstartxcoord(Date.parse(LEvents[i][0]));
	var ac2 = (eventLength / (24*60*60*1000))*svgWidthNum;
	
	var ac3 = findActivityColor(LEvents[i][1]);
	
	if(ac1<0){
	
		if(at>0){
		
			drawbox(ac0, 0, at, ac3);
		
		}
	
	}
	
	if(ac1>0){
	
		drawbox(ac0, ac1, ac2, ac3);
	
	}

}
