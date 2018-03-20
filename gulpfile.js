let gulp = require('gulp');
let csscomb = require('gulp-csscomb');
let cleanCSS = require('gulp-clean-css');
let rename = require('gulp-rename');
let autoprefixer = require('autoprefixer');
let postcss = require('gulp-postcss');
let sourcemaps = require('gulp-sourcemaps');
let del = require('del');
let concat = require('gulp-concat');

// gulp-saas
// browser-sync
// let less = require('gulp-less');

// For webpack
// let babel = require('gulp-babel');
// let uglify = require('gulp-uglify');


function clean(str) {
    return del([str]);
}


gulp.task('default', function () {
    // place code for your default task here
    console.log('Gulp default is ok');
});


function production_Deploy() {
    // sftp upload
}


// let paths = {
//     styles: {
//         src: 'src/styles/**/*.less',
//         dest: 'assets/styles/'
//     }
// };
//
// paths.scripts = {
//         src: 'src/scripts/**/*.js',
//         dest: 'assets/scripts/'
//     };


function cssDevelopment_Desktop() {
    // each: watch, less, csscomb

//     return gulp.src(paths.styles.src)
//         .pipe(less())
//         .pipe(cleanCSS())
//         // pass in options to the stream
//         .pipe(rename({
//             basename: 'main',
//             suffix: '.min'
//         }))
//         .pipe(gulp.dest(paths.styles.dest));
}


function cssBundle_Desktop() {
    // More post-css
    // https://github.com/postcss/postcss

    const Desktop_Input_CssFiles = [

        './_global/css/reset.css',
        './_global/css/jquery.tagit.css',
        './_global/css/tagit.ui-zendesk.css',
        './_global/css/fonts-google-opensans.css',

        './_global/css/general.css',
        './_global/css/common.css',
        './_global/css/main_player_controls.css',

        './desktop/css/*.css',
    ];

    const Output_CssPath = './desktop/css/';
    const Output_CssTarget = 'bundle.min.css';

    return gulp.src(Desktop_Input_CssFiles)
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer()]))
        .pipe(csscomb())
        .pipe(concat(Output_CssTarget))
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(sourcemaps.write('/'))
        .pipe(gulp.dest(Output_CssPath))
}


const buildDesktop = gulp.series(
    gulp.parallel(cssBundle_Desktop)
);

gulp.task('build_Desktop', buildDesktop); // npm run build_Desktop



