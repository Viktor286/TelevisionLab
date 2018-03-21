"use strict";

const gulp = require('gulp');
const csscomb = require('gulp-csscomb');
const cleanCSS = require('gulp-clean-css');
const rename = require('gulp-rename');
const autoprefixer = require('autoprefixer');
const postcss = require('gulp-postcss');
const sourcemaps = require('gulp-sourcemaps');
const del = require('del');
const concat = require('gulp-concat');
const path = require('path');
const newer = require('gulp-newer');
const less = require('gulp-less');
const browserSync = require('browser-sync').create();
const gulpStylelint = require('gulp-stylelint');
const debug = require('gulp-debug');

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
    const sftp = require('gulp-sftp');
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

const Desktop_Input_LessFiles = ['./desktop/css/less/**/*.less', '!./desktop/css/less/elements.less'];
const Desktop_FinalCssPath = './desktop/css/';

const Desktop_Watch_OtherFiles = [
    './index.php',
    './desktop/js/app.js'
];

gulp.task('less-desktop', function () {
    return gulp.src(Desktop_Input_LessFiles, {since: gulp.lastRun('less-desktop')})
        .pipe(debug())
        .pipe(less())
        .pipe(csscomb())
        .pipe(postcss([autoprefixer()]))
        .pipe(gulpStylelint({
            // fix: true,
            failAfterError: false,
            reportOutputDir: 'desktop/css/reports/stylelint',
            reporters: [
                {formatter: 'string', console: true},
                // {formatter: 'verbose', console: true},
                // {formatter: 'json', save: 'report.json'},
            ],
            debug: true
        }))
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

        '!./desktop/css/bundle.min.css'
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



