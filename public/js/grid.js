
var cubeSize = 50;

var screenSize = (5*cubeSize)+20;

var svg = "";
var list = "";
var grid = grid || {};

var la = "";
var lo = "";

var dataurl = "http://api.geeksoc-hackathon.tk/data/";

refreshResources();

grid.setup = function (s, l) {
	svg = d3.select("#" + s).append("svg")
		.attr("width", screenSize)
		.attr("height", screenSize);
	list = d3.select("#" + l);
};

grid.updateGrid = function (lat, lon) {
	$.ajax({
		url : dataurl + "map.php?lat=" + lat + "&lon=" + lon,
		type : "GET",
		dataType : "json",
		success : onMapReceived
	});
};

function onMapReceived(data) {

	for (var x = 0; x < 5; x++) {
		for (var y = 0; y < 5; y++) {
			data[x + (y * 5)].x = x;
			data[x + (y * 5)].y = y;
		}
	}

	svg.selectAll("rect")
	.data(data)
	.enter()
	.append("rect")
	.style("stroke", "gray")
	.style("fill", function (d) {
		return calcColour(d);
	})
	.attr("width", cubeSize)
	.attr("height", cubeSize)
	.attr("x", function (d) {
		return (d.x * cubeSize) + 5;
	})
	.attr("y", function (d) {
		return (d.y * cubeSize) + 5;
	})
	.on("click", function (d) {
		//d3.select("#value").text(JSON.stringify(d))
		updateList(d);
		svg.selectAll("rect").style("stroke", "gray");
		d3.select(this).style("stroke", "red");
	})
	.on("mouseover", function () {
		d3.select(this).style("fill", "aliceblue");
	})
	.on("mouseout", function () {
		d3.select(this).style("fill", function (d) {
			return calcColour(d);
		});
	});

};

function updateList(data) {
list.selectAll("tr").remove();
	list.selectAll("tr").data(data).enter().append("tr").each(function (d, i) {
		d3.select(this).append("td").text(function (d) {
			return d.BSSID;
		});
        d3.select(this).append("td").text(function (d) {
			return d.SECURITY;
		});
        var actions = d3.select(this).append("td");
		actions.append("button").attr("onClick", function (d) {
			return "hack(" + d.id + ")";
		}).text("Hack");
	});
	
};

function calcColour(d) {

	if (d.length == 0) {
		return "white";
	} else {
		return d3.rgb(240, 248, 255).darker(d.length).toString();
	}
};

function hack(d) {
	$.ajax({
		url : dataurl + "hack.php",
		type : "POST",
		data : d
	});
	refreshResources();
}

function refreshResources() {
    d3.select('#rec').text("asdsda")
	//var sessionValue = '<%=Session["username"]%>'
}
