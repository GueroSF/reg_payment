'use strict';

window.addEventListener('load', function() {

    const button = {
        element: document.querySelector('.button-for-view-if-zero'),
        hide: function() {
            this.element.classList.add('hide');
        }
    };

    const hiddenMonths = document.querySelectorAll('.hide');

    if (hiddenMonths.length === 0) {
        button.hide();

        return;
    }


    button.element.addEventListener('click', function() {
        hiddenMonths.forEach(function (element) {
            element.classList.remove('hide');
        });

        button.hide();
    })
});
