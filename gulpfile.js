"use strict";

const gulp = require('gulp');
const fs = require('fs');
const csscomb = require('gulp-csscomb');
const cleanCSS = require('gulp-clean-css');
const rename = require('gulp-rename');
const autoprefixer = require('autoprefixer');
const postcss = require('gulp-postcss');
const sourcemaps = require('gulp-sourcemaps');
const concat = require('gulp-concat');
const path = require('path');
const newer = require('gulp-newer');
const less = require('gulp-less');
const browserSync = require('browser-sync').create();
const gulpStylelint = require('gulp-stylelint');
const rev = require('gulp-rev');
const debug = require('gulp-debug');
const plumber = require('gulp-plumber');
const notify = require('gulp-notify');
const gulpif = require('gulp-if');
const uglyfly = require('gulp-uglyfly');

const notifyError = {
    errorHandler: notify.onError(function (err) {
        return {
            title: 'Notify',
            message: err.message
        };
    })
};

const production = process.env.NODE_ENV === 'production' || false;
production ? console.log('\n-------->>>> production mode build <<<<--------\n') : null;


gulp.task('default', function () {
    {
    }
});


gulp.task('sftp-deploy', function () {
    const sftp = require('gulp-sftp');
    return gulp.src('./deploy-test/!*')
        .pipe(sftp({
            host: 'u186876.ftp.masterhost.ru',
            port: 22,
            remotePath: '/home/u186876/televisionlab.net/www/',
            auth: 'access'
        }));
});


gulp.task('less-compile-desktop', function () {
    return gulp.src([
        './desktop/css/less/**/*.less',
        '!./desktop/css/less/elements.less'], {since: gulp.lastRun('less-compile-desktop')})
        .pipe(plumber(notifyError))
        .pipe(debug())
        .pipe(less())
        .pipe(csscomb())
        .pipe(postcss([autoprefixer()]))
        .pipe(gulpStylelint({
            // fix: true,
            failAfterError: false,
            reportOutputDir: 'desktop/css/reports/stylelint/',
            reporters: [
                {formatter: 'string', console: true},
                {formatter: 'json', save: 'report.json'},
            ],
            debug: true
        }))
        .pipe(gulp.dest('./desktop/css/static/'));
        // gulp.dest can combine destinations for stream file.dirname, file.basename etc.
        // .pipe(gulp.dest(function (file) {
        //     return file.dirname === './desktop/css/' ? './desktop/css/static/' :
        //         file.dirname === './add/css/' ? './add/css/static/' : './gulp-default-path/';
        // }));
});


gulp.task('build-desktop-css', function () {

    // In development mode reset manifest files to non-hashed titles
    if (!production) {
        const manifestFile = './desktop/css/manifest/bundle.css.json';
        const nameToReset = 'bundle.min.css';
        manifestOverwrite(manifestFile, nameToReset);
    }

    return gulp.src([
        './_global/css/reset.css',
        './_global/css/jquery.tagit.css',
        './_global/css/tagit.ui-zendesk.css',
        './_global/css/fonts-google-opensans.css',

        './_global/css/general.css',
        './_global/css/common.css',
        './_global/css/main_player_controls.css',

        './desktop/css/static/*.css',

        '!./desktop/css/bundle.min.css' // exclude existing target itself from bundle
    ])
        .pipe(sourcemaps.init())
        .pipe(concat({path: 'bundle.min.css', cwd: ''}))
        .pipe(cleanCSS({compatibility: 'ie8'}))

        .pipe(gulpif(production, rev())) // revisioning

        .pipe(sourcemaps.write('/'))
        .pipe(gulp.dest('./desktop/css/'))

        .pipe(gulpif(production, rev.manifest('bundle.css.json'))) // revisioning
        .pipe(gulpif(production, gulp.dest('./desktop/css/manifest/'))) // revisioning

});


gulp.task('watch-less-and-build-desktop-css', function () {

    browserSync.init({
        proxy: "http://www.televisionlab.net/"
    });

    gulp.watch([
        './desktop/css/less/**/*.less',
        '!./desktop/css/less/elements.less'], gulp.series('less-compile-desktop', 'build-desktop-css'));

    gulp.watch([
        './desktop/css/*.css',
        './desktop/css/static/*.css',
        './index.php',
        // './desktop/js/app.js'
    ]).on('change', browserSync.reload);

});


gulp.task('production-desktop-css', gulp.series('less-compile-desktop', 'build-desktop-css'));


gulp.task('build-vendors-js', function () {
    return gulp.src([
        './_global/js/compatibility.js',
        './_global/js/jquery-1.11.0.min.js',
        './_global/js/handlebars.js',
        './_global/js/waterfall.js',
        './_global/js/jquery-ui-custom.min.js',
        './_global/js/tag-it.js',
        './_global/js/vimeo.api.player.js',
        './_global/js/screw-default-buttons.js'
    ])
        .pipe(debug())
        .pipe(concat({path: 'vendors.js'}))
        .pipe(uglyfly({mangle:true}))
        .pipe(rev()) // revisioning
        .pipe(gulp.dest('./desktop/js/'))
        .pipe(rev.manifest('vendors.js.json')) // revisioning
        .pipe(gulp.dest('./desktop/js/manifest/'))


});

function manifestOverwrite(targetFile, defaultName){
    let css_manifest = JSON.parse(fs.readFileSync(targetFile, 'utf8'));
    if (css_manifest[defaultName] !== defaultName) {
        const content = JSON.stringify({[defaultName]: defaultName}, null, 4);

        fs.writeFile(targetFile, content, 'utf8', function (err) {
            if (err) {
                return console.log(err);
            }
            console.log("\n Reset to non-hashed filename in manifest " +
                `\n ${targetFile} \n `);
        });
    }
}
