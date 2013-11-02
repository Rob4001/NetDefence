
/*
 * GET home page.
 */
 var mysql = require('mysql')
 config = require('../config.js');
 
 var connection = mysql.createConnection({
        host     : 'localhost',
        user     : config.mysqlUser,
        password : config.mysqlPass
    });
connection.query('USE loaded', function (err) {
        if (err) throw err;
});
exports.index = function(req, res){
connection.query('SELECT `CHANNEL` FROM `aps` ;', req.body, 
        function (err, results) {
            if (err) throw err;
            var chans = new Array();
            for(var i = 1; i < results.length; i++){
            chans[results[i].channel] = chans[results[i].channel] + 1;
            
            }
            var data = [];
            for(index in chans)
                {
                
                        data.push({
                                label: key,
                                value: chans[index]
                        });
                }
            res.render('index', { title: 'NetDefense' ,user: req.user, data: data});
        }
    );

  
};
