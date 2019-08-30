'use strict'

	const mongoose = require('mongoose')
	const conf = require('./db-conf')
	const Schema = mongoose.Schema
	const MovieSchema = new Schema({
		movie_id : "string",
		title : "string",
		release_year : "string",
		rating : "string",
		image : "string"
	},
	{
		collection : "movie"
	})
	const MovieModel = mongoose.model("Movie", MovieSchema)

mongoose.connect(`mongodb:\/\/${conf.mongo.host}/${conf.mongo.db}`)

module.exports = MovieModel