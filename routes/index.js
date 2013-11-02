
/*
 * GET home page.
 */
 var mysql = require('mysql')
 config = require('./config.js');
 
 var connection = mysql.createConnection({
        host     : 'localhost',
        user     : config.mysqlUser,
        password : config.mysqlPass
    });

exports.index = function(req, res){
connection.query('SELECT `CHANNEL` FROM `aps` ;', req.body, 
        function (err, results) {
            if (err) throw err;
            var chans = new array();
            for(var i = 1; i < results.length; i++){
            chans[results[i].channel] = chans[results[i].channel] + 1;
            
            }
            for(var i = 1; i < chans.length; i++)
                {
                        data.push({
                                index: i,
                                name: 'test',
                                value: getRandomInt(0,1000)
                        });
                }
            res.render('index', { title: 'NetDefense' ,user: req.user, data:results});
        }
    );

  
};