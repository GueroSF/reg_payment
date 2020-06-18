'use strict';

class LoadingPosting {

    constructor(config) {
        this.url = config.url;
        this.limit = config.limit;
        this.amount = config.amount;

        this.offset = 0;
    }

    run() {
        this.btn = document.querySelector('#load-postings');

        if (this.checkAmount(this.amount)) {
            this.removeButton();

            return;
        }

        this.btn.addEventListener('click', this.handlerClick(document.querySelector('.posting-list')))
    }

    checkAmount(amount) {
        return amount < this.limit;
    }

    removeButton() {
        this.btn.remove();
    }

    handlerClick(htmlList) {
        return () => {
            this.offset += this.limit;
            fetch(this.url, {
                method: 'POST',
                body  : JSON.stringify({limit: this.limit, offset: this.offset})
            })
                .then(res => res.json())
                .then(data => {
                    if (this.checkAmount(data.amount)) {
                        this.removeButton();
                    }
                    htmlList.innerHTML += data.html;
                })
            ;
        }
    }
}

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

    const loader = new LoadingPosting(postingConfig);
    loader.run();
});
