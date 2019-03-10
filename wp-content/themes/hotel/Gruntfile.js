module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        less: {
            development: {
                options: {
                    compress: true,
                    yuicompress: true,
                    optimization: 2
                },
                files: {
                    "css/main.css": "less/design.less"
                }
            }
        },
        concat: {
            /* concat css*/
            css: {
                src: [
                    "css/*.css",
                    "!css/main.min.css"
                ],
                dest: 'css/main.min.css'
            },

            concatAppDev: {
                options: {
                    separator: ';',
                },
                src: [
                    'js/libs/*.js',
                    'js/scripts/*.js'
                ],
                dest: 'js/app.min.js'
            },

            concatAppDevAngular: {
                options: {
                    separator: ';',
                },
                src: [
                    'app/libs/*.js',
                    'app/app.js'
                ],
                dest: 'app/app.min.js'
            },

        },
        cssmin: {
            dist: {
                files: {
                    'css/main.min.css': 'css/main.min.css'
                }
            }
        },
        uglify: {
            dist: {
                files: {
                    'js/app.min.js': 'js/app.min.js'
                }
            },
            options: {
                compress: {
                    hoist_funs: false,
                    dead_code: true,
                    drop_console: false
                }
            }
        },
        watch: {
            default: {
                files: [
                    "css/*.css",
                    "less/design.less",
                    'js/libs/*.js',
                    'js/scripts/*.js',
                    'app/libs/*.js',
                    'app/app.js',
                    "!css/main.min.css",
                    "!js/app.min.js",
                    "!app/app.min.js"
                ],
                tasks: ['livebuild'],
                options: {
                    event: ['all']
                }
            }
        }
    });
    require("time-grunt")(grunt);

    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks("grunt-contrib-uglify");

    grunt.registerTask('livebuild', [
        'less',
        'concat',
        'cssmin'
    ]);    

};
