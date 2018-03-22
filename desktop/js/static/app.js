"use strict";

const loadVideo = require("./load-video");
const desktop = require("./desktop");
const topPanel = require("./top-panel");
const mainPlayer = require("./main-player");

loadVideo();
desktop();
topPanel();
mainPlayer();

// module.exports.tester = tester;