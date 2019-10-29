'use strict'

const mysql = require('mysql')
const conf = require('./db-conf')
const dbOptions = {
		host : conf.mysql.host,
		port : conf.mysql.port,
		user : conf.mysql.user,
		password : conf.mysql.pass,
		database : conf.mysql.db
}
const myConn = mysql.createConnection(dbOptions)

myConn.connect((err) => {
	return (err) ? console.log(`Error al Conectarse a MySQL: ${err.stack}`) : console.log(`Conexión establecida con MySQL N°: ${myConn.threadId}`)
})

//console.log(conf.mysql.db)

module.exports = myConn