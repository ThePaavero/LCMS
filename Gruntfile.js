
module.exports = function(grunt) {

	require('time-grunt')(grunt);
	require('jit-grunt')(grunt, {
		bower: 'grunt-bower-task'
	});

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		banner: '/*! <%= pkg.name %>\n <%= grunt.template.today("yyyy-mm-dd") %>\n Author:<%= pkg.author %>\n License: <%= pkg.license %>\n*/\n',

		uglify: {
			lcms: {
				files: {
					'.tmp/assets/js/lcms.min.js': ['assets/lcms/js/lcms.js', 'assets/lcms/js/**/*.js']
				}
			},
			project: {
				files: {
					'.tmp/assets/js/project.min.js': ['assets/project/js/main.js', 'assets/project/js/autoload/**/*.js'],
				}
			}
		},

		sass: {
			lcms: {
				files: {
					'.tmp/assets/css/lcms.css': [
						'assets/lcms/scss/lcms.scss'
					]
				}
			},
			project: {
				files: {
					'.tmp/assets/css/project.css': [
						'assets/project/scss/project.scss',
					]
				}
			}
		},

		cssmin: {
			project: {
				files: {
					'.tmp/assets/css/project.min.css': [
						'.tmp/assets/css/project.css'
					]
				}
			},
			lcms: {
				files: {
					'.tmp/assets/css/lcms.min.css': [
						'.tmp/assets/css/lcms.css'
					]
				}
			}
		},

		concat: {
			lcms: {
				src: ['assets/lcms/js/lcms.js', 'assets/lcms/js/**/*.js'],
				dest: '.tmp/assets/js/lcms.min.js'
			},
			project: {
				src: ['assets/project/js/main.js', 'assets/project/js/autoload/**/*.js'],
				dest: '.tmp/assets/js/project.min.js'
			}
		},

		copy: {
			assets_css: {
				files: [
					{
						src: '.tmp/assets/css/*',
						expand: true,
						dest: 'public_html/assets/css/',
						flatten: true,
						filter: 'isFile'
					}
				]
			},
			assets_js: {
				files: [
					{
						src: '.tmp/assets/js/*',
						expand: true,
						dest: 'public_html/assets/js/',
						flatten: true,
						filter: 'isFile'
					}
				]
			},
			colorbox: {
				files: [
					{
						src: 'bower_components/jquery-colorbox/example1/**/*',
						expand: true,
						dest: 'public_html/assets/lib/jquery-colorbox/',
						flatten: true,
						filter: 'isFile'
					}
				]
			}
		},

		bower: {
			src: {
				options: {
					targetDir: 'public_html/assets/lib/',
					layout: 'byComponent',
					install: false,
					verbose: true,
					cleanTargetDir: true,
					cleanBowerDir: false,
					bowerOptions: {
						production: true
					}
				}
			}
		},

		clean: [
			'.tmp/',
			'public_html/assets/*'
		],

		watch: {
			dev: {
				files: [
					'assets/js/**/*.js',
					'assets/scss/**/*.scss',
				],
				tasks : ['quickbuild']
			},
			options: {
				livereload: false
			}
		}

	});

	grunt.registerTask('default', [
		'build'
	]);

	grunt.registerTask('dev', [
		'clean',
		'bower',
		'quickbuild',
		'watch'
	]);

	grunt.registerTask('quickbuild', [
		'newer:sass',
		'newer:concat',
		'copy'
	]);

	grunt.registerTask('build', [
		'clean',
		'bower',
		'uglify',
		'sass',
		'cssmin',
		'copy'
	]);
};
