window.onscroll = function () {
    var header = document.getElementById('main-header');
    if (window.scrollY > 50) {
        header.style.backgroundColor = '#0f0f0f';
        header.style.boxShadow = '5px 5px 10px rgba(0, 0, 0, 0.5)';
    } else {
        header.style.backgroundColor = 'transparent';
        header.style.boxShadow = 'none';
    }
};
