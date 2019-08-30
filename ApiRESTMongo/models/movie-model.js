'use strict'

const conn = require('./movie-connection')
class MovieModel {
	static getAll(cb) {
		conn
			.find((err, docs) => {
				if(err) throw err
				cb(docs)
			})
	}

	static getOne(id, cb) {
		conn
			.findOne({movie_id : id}, (err, docs) => {
				if(err) throw err
				cb(docs)
			})
	}

	static save(data, cb) {
		conn
			.count({movie_id : data.movie_id}, (err, count) => {
				if(err) throw err
				console.log(`Número de Docs: ${count}`)
				if(count == 0) {
					conn.create(data, (err) => {
						if(err) throw err
						cb()
					})
				} else if(count == 1) {
					conn.findOneAndUpdate(
						{movie_id : data.movie_id},
						{
							title : data.title,
							release_year : data.release_year,
							rating : data.rating,
							image : data.image
						},
						(err) => {
							if(err) throw(err)
							cb()
						}
					)
				}
			})
	}
	static delete(id, cb) {
		conn.remove({movie_id : id}, (err, docs) => {
			if(err) throw err
			cb()
		})
	}
}

module.exports = MovieModel