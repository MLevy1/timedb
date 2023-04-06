/*
const displayDuration = {
	
	createCell: function(cellText){
		td = document.createElement("td")
		td. appendChild(document. createTextNode(cellText))
		return td
	},
	displayList: function(obj){
			
		const tbl = document.createElement("table")
		
		tbl.id = "tblModForm"
		
		const thead = document.createElement("thead")
		
		const heads = Object.keys((obj[Object.keys(obj)[1]]))

		heads.forEach(element => {
			
			let th = document.createElement("th")

			th. appendChild (document.createTextNode(element))
				
			thead.appendChild(th)
				
		});

		tbl.appendChild(thead)
		
		const tbody = document.createElement("tbody")

		for (i in obj){

			let tr = document.createElement("tr")

			heads.forEach(h => {

				let inp = obj[i][h]

				let td = displayDuration.createCell(inp)

				tr.appendChild(td)

			})
						
			tbody.appendChild(tr)
		
		}

		tbl.appendChild(tbody)

		return tbl

	}

}
*/
function displayActDurs(){

	const activityDurationList = {};

	LEvents.sort();
				
	LEvents.reverse();
				
	ELen = LEvents.length;
				
	var minDate = Date.now()-(2*24*60*60*1000);
				
	text = 
		"<table class='durationSummary'>" +
			"<thead>" +
				"<th>Activity</th>" +
				"<th>Duration</th>" +
			"</thead>" +
			"<tbody>";
				
	for (i = 0; i < ELen; i++) {
				
		if(i==0){
		
			var eventLength = Date.now()-Date.parse(LEvents[i][0]);
		
		}else{
					
			eventLength = Date.parse(LEvents[i-1][0])-Date.parse(LEvents[i][0]);
					
		}
					
		//formatEventDuration(eventLength);
					
		if(Date.parse(LEvents[i][0]) > minDate){

			//arr1.push([LEvents[i][3], eventLength]);

													if( activityDurationList. hasOwnProperty(LEvents[i][3])==false){
							
														activityDurationList[ LEvents [i][3] ] = eventLength;
													} else {

			activityDurationList [ LEvents[i][3] ] += eventLength;
		
		}
					
	}
				
}
				
let sortArray = [];

for (let activityName in activityDurationList) {
	
	sortArray.push( [activityName, activityDurationList[activityName]]);
	
}

sortArray.sort(function(a, b){
	return b[1]-a[1];
})

let sortedActivityDurationList = {}

sortArray.forEach(function(item){
	sortedActivityDurationList[ item [0]] = item[1];
});

for (let activityName in sortedActivityDurationList) {
				
	text += "<tr><td>" + activityName + "</td><td>" + formatEventDuration (sortedActivityDurationList [ activityName ]) + "</td></tr>";

	}
				
text += "</tbody></table>";

				document.getElementById("listContainer").innerHTML = text;

}

function displayContDurs(){

	const contDurationList = {};

	LEvents.sort();
				
	LEvents.reverse();
				
	ELen = LEvents.length;
				
	var minDate = Date.now()-(2*24*60*60*1000);
				
	text = 
		"<table class='durationSummary'>" +
			"<thead>" +
				"<th>Sub-Projecf</th>" +
				"<th>Duration</th>" +
			"</thead>" +
			"<tbody>";
				
	for (i = 0; i < ELen; i++) {
				
		if(i==0){
		
			var eventLength = Date.now()-Date.parse(LEvents[i][0]);
		
		}else{
					
			eventLength = Date.parse(LEvents[i-1][0])-Date.parse(LEvents[i][0]);
					
		}
					
		if(Date.parse(LEvents[i][0]) > minDate){
													if( contDurationList. hasOwnProperty(LEvents[i][3])==false){
							
														contDurationList[ LEvents [i][3] ] = eventLength;
													} else {

			contDurationList [ LEvents[i][3] ] += eventLength;
		
		}
					
	}
				
}
				
let sortArray = [];

for (let contName in contDurationList) {
	
	sortArray.push( [contName, contDurationList[contName]]);
	
}

sortArray.sort(function(a, b){
	return b[1]-a[1];
})

let sortedContDurationList = {}

sortArray.forEach(function(item){
	sortedContDurationList[ item [0]] = item[1];
});

for (let contName in sortedContDurationList) {
				
	text += "<tr><td>" + contName + "</td><td>" + formatEventDuration  ( sortedContDurationList [ contName ]) + "</td></tr>";

	}
				
text += "</tbody></table>";

				document.getElementById("listContainer").innerHTML = text;

}