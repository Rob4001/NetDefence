//define screen size
var screenSize = 120;

//define rect size
var cubeSize = 20;

var svg = "";
var grid = grid || {};

var la = "";
var lo = "";

var dataurl = "http://api.geeksoc-hackathon.tk/data/map.php";

grid.setup = function (s) {
	svg = d3.select("#" + s).append("svg")
		.attr("width", screenSize)
		.attr("height", screenSize);

};

grid.updateGrid = function (lat, lon) {
	$.ajax({
		url : dataurl + "?lat=" + lat + "&lon=" + lon,
		type : "GET",
		dataType : "json",
		success : onDataReceived
	});
};

function onDataReceived(data) {

	for (var x = 0; x < 5; x++) {
    for (var y = 0; y < 5; y++) {
       data[x+(y*5)].x = x;
       data[x+(y*5)].y = y;
    }
    }

		svg.selectAll("rect")
		.data(data)
		.enter()
		.append("rect")
		.style("stroke", "gray")
		.style("fill", function(d){return calcColour(d);})
		.attr("width", 20)
		.attr("height", 20)
		.attr("x", function (d){return (d.x*20)+5;})
		.attr("y", function (d){return (d.y*20)+5;})
		.on("click", function (d) {
			d3.select("#value").text(JSON.stringify(d))
		})
		.on("mouseover", function () {
			d3.select(this).style("fill", "aliceblue");
		})
		.on("mouseout", function () {
			d3.select(this).style("fill", function(d){return calcColour(d);});
		});
	

};

function calcColour(d){

if(d.length == 0){
return "white";
}else{
return d3.rgb(240,248,255).darken(d.length).toString();
}
};
