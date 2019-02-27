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
              "assets/css/main.css": "assets/less/design.less"
            }
          }
        },
        concat: {
            /* concat css*/
            css: {
                src: [
                    "assets/css/*.css",
                    "!assets/css/main.min.css"
                ],
                dest: 'assets/css/main.css'
            },

            /*concat main app dev*/
            concatAppDev: {
                options: {
                    separator: ';',
                },
                src: [
                    'assets/js/libs/*.js',
                    'assets/js/scripts/*.js',
                ],
                dest: 'assets/js/app.js'
            }
        },
        cssmin: {
            dist: {
                files: {
                    'assets/css/main.min.css': 'assets/css/main.css'
                }
            }
        },
        watch: {
            default: {
                files: [
                    'assets/js/libs/*.js',
                    'assets/js/scripts/*.js',
                    "assets/css/*.css",
                    "assets/less/design.less",
                    "!assets/css/main.min.css"
                ],
                tasks: ['build'],
                options: {
                    event: ['all']
                }
            }
        }
    });
    
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-cssmin');    
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-watch');

    /*build dev + prod*/
    grunt.registerTask('build', [
        'less',
        'concat',
        'cssmin'
    ]);
};