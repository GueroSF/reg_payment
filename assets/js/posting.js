'use strict';

window.addEventListener('load', () => {
    const btn = document.querySelector('#collapsed-form-add');
    const character = btn.querySelector('.character');
    const formContainer = document.querySelector('.form-container');

    btn.addEventListener('click', () => {
        if (formContainer.classList.contains('collapsed')) {
            character.innerText = '-';
            formContainer.classList.remove('collapsed');
        } else {
            character.innerText = '+';
            formContainer.classList.add('collapsed');
        }
    });
});
