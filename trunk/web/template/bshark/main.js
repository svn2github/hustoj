window.onscroll = function () {
    var sl = -Math.max(document.body.scrollLeft, document.documentElement.scrollLeft);
    document.getElementById('navbar').style.left = sl + 'px';
}
function totop() {
    var scrollToTop = window.setInterval(function () {
        var pos = window.pageYOffset;
        if (pos > 0) {
            window.scrollTo(0, pos - 100); // how far to scroll on each step
        } else {
            window.clearInterval(scrollToTop);
        }
    }, 16);
}
