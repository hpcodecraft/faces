module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    less: {
      development: {
        files: {
          "content/css/app.css": "content/css/src/app-concat.less",
          "content/css/admin.css": "content/css/src/admin-concat.less",
        }
      },
      production: {
        options: {
          compress: true,
          cleancss: true,
        },
        files: {
          "content/css/app-min.css": "content/css/src/app-concat.less",
          "content/css/admin-min.css": "content/css/src/admin-concat.less",
        }
      }
    },

    concat: {
      options: {
        separator: "\n",
        banner: "",
        footer: ""
      },
      app: {
        src: [
          'core/js/lib/jquery-1.10.2.js',
          'core/js/lib/jquery.scrollTo.js',
          'core/js/lib/hammer.js',
          'core/js/lib/jquery.hammer.js',
          'core/js/lib/jquery.specialevent.hammer.js',
          'core/js/lib/Faces.js',
          'core/js/lib/Tag.js',
          'core/js/app.js',
        ],
        dest: 'core/js/min/app.js',
      },
      admin: {
        src: [
          'core/js/lib/jquery-1.10.2.js',
          'core/js/lib/jquery.scrollTo.js',
          'core/js/admin.js',
        ],
        dest: 'core/js/min/admin.js',
      }
    },

    uglify: {
      options: {
        banner: ""
      },
      app: {
        src: 'core/js/min/app.js',
        dest: 'core/js/min/app-min.js',
      },
      admin: {
        src: 'core/js/min/admin.js',
        dest: 'core/js/min/admin-min.js',
      },
    },

  });

  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');

  grunt.registerTask('default', ['less', 'concat', 'uglify']);
};