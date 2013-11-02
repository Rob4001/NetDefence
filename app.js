
/**
 * Module dependencies.
 */

var express = require('express');
var routes = require('./routes');
var http = require('http');
var passport = require('passport'),
util = require('util'),
GitHubStrategy = require('passport-github').Strategy,
path = require('path'),
config = require('./config.js');

var app = express();

// all environments
app.set('port', process.env.PORT || 3000);
app.set('views', __dirname + '/views');
app.set('view engine', 'jade');
app.use(express.favicon());
app.use(express.logger('dev'));
app.use(express.bodyParser());
app.use(express.methodOverride());
app.use(passport.initialize());
app.use(passport.session());
app.use(app.router);
app.use(express.static(path.join(__dirname, 'public')));

// development only
if ('development' == app.get('env')) {
  app.use(express.errorHandler());
}

passport.serializeUser(function(user, done) {
        done(null, user);
});

passport.deserializeUser(function(obj, done) {
        done(null, obj);
});

passport.use(new GitHubStrategy({
    clientID: config.githubID,
    clientSecret: config.githubSecret,
    callbackURL: config.githuibCallback
  },
  function(accessToken, refreshToken, profile, done) {
    // asynchronous verification, for effect...
    process.nextTick(function () {
      
      // To keep the example simple, the user's GitHub profile is returned to
      // represent the logged-in user.  In a typical application, you would want
      // to associate the GitHub account with a user record in your database,
      // and return that user instead.
      return done(null, profile);
    });
  }
));

app.get('/', routes.index);
app.get('/users', user.list);

// Auth Routes

app.get('/auth/github',
passport.authenticate('github'),
function(req, res){
});

app.get('/auth/github/callback', 
passport.authenticate('github', { failureRedirect: '/login' }),
function(req, res) {
res.redirect('/');
});

app.get('/logout', function(req, res){
req.logout();
res.redirect('/');
});

http.createServer(app).listen(app.get('port'), function(){
  console.log('Express server listening on port ' + app.get('port'));
});
