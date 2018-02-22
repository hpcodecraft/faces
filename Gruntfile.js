module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON("package.json"),

    less: {
      development: {
        files: {
          "src/content/css/app.css": "src/content/css/src/app-concat.less",
          "src/content/css/admin.css": "src/content/css/src/admin-concat.less"
        }
      },
      production: {
        options: {
          compress: true,
          cleancss: true
        },
        files: {
          "src/content/css/app-min.css": "src/content/css/src/app-concat.less",
          "src/content/css/admin-min.css":
            "src/content/css/src/admin-concat.less"
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
          "src/core/js/lib/jquery-1.10.2.js",
          "src/core/js/lib/jquery.scrollTo.js",
          "src/core/js/lib/hammer.js",
          "src/core/js/lib/jquery.hammer.js",
          "src/core/js/lib/jquery.specialevent.hammer.js",
          "src/core/js/lib/Faces.js",
          "src/core/js/lib/Tag.js",
          "src/core/js/app.js"
        ],
        dest: "src/core/js/min/app.js"
      },
      admin: {
        src: [
          "src/core/js/lib/jquery-1.10.2.js",
          "src/core/js/lib/jquery.scrollTo.js",
          "src/core/js/admin.js"
        ],
        dest: "src/core/js/min/admin.js"
      }
    },

    uglify: {
      options: {
        banner: ""
      },
      app: {
        src: "src/core/js/min/app.js",
        dest: "src/core/js/min/app-min.js"
      },
      admin: {
        src: "src/core/js/min/admin.js",
        dest: "src/core/js/min/admin-min.js"
      }
    }
  });

  grunt.loadNpmTasks("grunt-contrib-less");
  grunt.loadNpmTasks("grunt-contrib-concat");
  grunt.loadNpmTasks("grunt-contrib-uglify");

  grunt.registerTask("default", ["less", "concat", "uglify"]);
};
