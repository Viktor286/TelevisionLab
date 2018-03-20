"use strict";

let gulp = require('gulp');
let csscomb = require('gulp-csscomb');
let cleanCSS = require('gulp-clean-css');
let rename = require('gulp-rename');
let autoprefixer = require('autoprefixer');
let postcss = require('gulp-postcss');
let sourcemaps = require('gulp-sourcemaps');
let del = require('del');
let concat = require('gulp-concat');
let path = require('path');
let newer = require('gulp-newer');
let less = require('gulp-less');
let browserSync = require('browser-sync').create();
let sftp = require('gulp-sftp');

function clean(str) {
    return del([str]);
}

gulp.task('default', function () {
    console.log('--> default gulp launch...');
});


/**
 * --------- SFTP Deploy
 *
 *    npm run sftp-deploy
 */

gulp.task('sftp-deploy', function () {
    return gulp.src('./deploy-test/*')
        .pipe(sftp({
            host: 'u186876.ftp.masterhost.ru',
            port: 22,
            remotePath: '/home/u186876/televisionlab.net/www/',
            auth: 'access'
        }));
});




/**
 * --------- LESS for Desktop watch
 *
 *    npm run watch-less-desktop
 */

const Desktop_Input_LessFiles = ['./desktop/css/less/**/*.less'];
const Desktop_FinalCssPath = './desktop/css/';

const Desktop_Watch_OtherFiles = [
    './index.php',
    './desktop/js/app.js'
];

gulp.task('less-desktop', function () {
    return gulp.src(Desktop_Input_LessFiles)
        .pipe(newer(Desktop_FinalCssPath))
        .pipe(less())
        .pipe(postcss([autoprefixer()]))
        .pipe(csscomb())
        .pipe(gulp.dest(Desktop_FinalCssPath));
});

gulp.task('watch-less-desktop', function () {

    browserSync.init({
        proxy: "http://www.televisionlab.net/"
    });

    // Compile less + build bundle from result
    gulp.watch(Desktop_Input_LessFiles, gulp.series('less-desktop', Css_Bundle_Desktop));

    // Reload browserSync
    gulp.watch(Desktop_FinalCssPath).on('change', browserSync.reload);
    initAdditionalArrayToWatch(Desktop_Watch_OtherFiles);
});

function initAdditionalArrayToWatch(arr) {
    // chokidar (with IDEA IDE? notepad++ acts good with this) has a bug with array param for input
    // it fires 'add' event at first change, but after this emits 'unlink' and stops watch
    // debug chokidar through gulp:
    // gulp.watch(['./index.php', './desktop/js/app.js']).on('all', (evt,path) =>
    //     console.log(`-- Watch log: '${evt}' launch from ${path}`)
    // );
    // chokidar makes this exact bug with separate installation of chokidar, outside of gulp.task()
    arr.forEach((arr) => {

        gulp.watch(arr).on('change', (evt) => {
            browserSync.reload();
            console.log(`-- Watch log: '${evt}' changed`);
        });

    });
}




/**
 * --------- CSS Desktop Build
 *
 *    npm run build-desktop
 */

function Css_Bundle_Desktop() {
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

    const Desktop_Output_CssPath = './desktop/css/';
    const Desktop_Output_CssTarget = 'bundle.min.css';

    return gulp.src(Desktop_Input_CssFiles)
    // .pipe(newer(Desktop_Output_CssPath))
        .pipe(sourcemaps.init())
        // .pipe(postcss([autoprefixer()]))
        // .pipe(csscomb())
        .pipe(concat(Desktop_Output_CssTarget))
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(sourcemaps.write('/'))
        .pipe(gulp.dest(Desktop_Output_CssPath))
}

const buildDesktop = gulp.series(
    gulp.parallel(Css_Bundle_Desktop)
);

gulp.task('build-desktop', buildDesktop);



