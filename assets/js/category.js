'use strict';

window.addEventListener('load', function() {
    let hiddenItem = true;

    document.querySelectorAll('.toggle-hidden-item button').forEach(btn => {
        const hiddenElements = document.querySelectorAll('.item.hide');

        btn.addEventListener('click', () => {
            if (hiddenItem === true) {
                hiddenElements.forEach(el => el.classList.remove('hide'));
                btn.innerText = 'Скрыть';
            } else {
                hiddenElements.forEach(el => el.classList.add('hide'));
                btn.innerText = 'Показать';
            }

            hiddenItem = !hiddenItem;
        })
    })
});
