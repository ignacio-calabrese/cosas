'use strict'

const express = require('express')
const favicon = require('serve-favicon')
const bodyParser = require('body-parser')
const morgan = require('morgan')
const routes = require('./routes/index')
const port = (process.env.PORT || 3000)
const app = express()

app
	.set('views', `${__dirname}/views`)
	.set('view engine', 'jade')
	.set('port', port)

	.use( favicon(`${__dirname}/public/img/node-favicon.png`) )
	// parse application/json
	.use( bodyParser.json() )
	// parse application/x-www-form-urlencoded
	.use( bodyParser.urlencoded({extended: false}) )
	.use( morgan('dev') )
	.use(express.static(`${__dirname}/public`))
	.use(routes)

module.exports = app