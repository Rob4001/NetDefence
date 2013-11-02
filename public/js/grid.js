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
	console.log(data);
	for (var i = 0; i < data.length; i++) {
		svg.selectAll("rect")
		.data(data)
		.enter()
		.append("rect")
		.style("stroke", "gray")
		.style("fill", "white")
		.attr("width", 20)
		.attr("height", 20)
		.attr("x", i % 5)
		.attr("y", (i - (i % 5)) / 5)
		.on("click", function (d) {
			d3.select("#value").text(d[1])
		})
		.on("mouseover", function () {
			d3.select(this).style("fill", "aliceblue");
		})
		.on("mouseout", function () {
			d3.select(this).style("fill", "white");
		});
	}

};
