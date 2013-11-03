
/*
 * GET home page.
 */

exports.index = function (req, res) {
	res.render('index', {
		title : 'NetDefense',
		user : req.user,
		data :
	});

};
