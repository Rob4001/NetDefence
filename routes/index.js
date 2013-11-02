
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
connection.query('SELECT `CHANNEL` FROM `aps`',
        function (err, results) {
            if (err) throw err;
            console.log(results)
            var chans = new Array();
            for(var i = 1; i < results.length; i++){
            chans[results[i].channel] += 1;
            
            }
            console.log(chans);
            var data = [];
            for(var index in chans)
                {
                
                        data.push({
                                label: index,
                                value: chans[index]
                        });
                }
                console.log(data)
            res.render('index', { title: 'NetDefense' ,user: req.user, data: JSON.stringify(data)});
        }
    );

  
};
