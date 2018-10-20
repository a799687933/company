define(function(require) {
    var $ = require('jquery');
    var Index = require('../static/index');
    var index = new Index(0,5,'.seriesImgDiv');
    index.slider();
    index.transform();
    index.loadOfflineInfo();
    index.loading();
    index.submits();
    index.page();
    index.jump();
});
