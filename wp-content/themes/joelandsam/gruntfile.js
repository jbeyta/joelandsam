module.exports = function(grunt) {

	grunt.initConfig({

		pkg: grunt.file.readJSON('package.json'),
		sass: {
			dist: {
				options: {
					sourceComments: 'map',
					includePaths: require('node-bourbon').includePaths
				},
				files: {
					'css/style.css': 'css/scss/style.scss',
					'css/admin/admin-style.css': 'css/scss/admin-style.scss' 
				}
			}
		},

		cssmin: {
			css:{
				src: 'css/style.css',
				dest: 'css/style.min.css'
			}
		},

		jshint: {
			beforeconcat: ['js/*.js']
		},

		concat: {
			dist: {
				src: [
				'js/plugins/*',
				'js/foundation.min.js',
				'js/cw-main.js',
				],
				dest: 'js/dist.js'
			}
		},

		uglify: {
			my_target: {
				options: {
					sourceMap: true,
					sourceMapName: 'js/sourcemap.map'
				},
				files: {
					'js/dist.min.js': ['js/dist.js']
				}
			}
		},

		watch: {
			options: {
				livereload: true,
			},
			scripts: {
				files: ['js/*.js'],
				tasks: ['concat', 'uglify'],
				options: {
					spawn: false,
				}
			},
			css: {
				files: ['css/scss/*.scss'],
				tasks: ['sass', 'cssmin'],
				options: {
					spawn: false,
				}
			},
			php: {
				files: ['*.php'],
				options: {
					spawn: false
				}
			},
		},

		connect: {
			server: {
				options: {
					port: 8000,
					base: './'
				}
			}
		},

	});

	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.registerTask('default', ['watch']);
};