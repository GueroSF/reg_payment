'use strict';
const buttonHide = function () {
        document.querySelector('.button_for_view_if_zero').classList.add('hide');
};

window.onload = function () {

	let hideMonth = document.querySelectorAll('.hide');

    if (hideMonth.length == 0) {
		buttonHide();
	}

	document.querySelector('.button_for_view_if_zero button').onclick = function () {
        for (let i = 0, len = hideMonth.length; i < len; i++){
            hideMonth[i].classList.remove('hide');
            buttonHide();
        }
    }
};