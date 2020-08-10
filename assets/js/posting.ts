declare const postingConfig;

class LoadingPosting {

    private url: string;
    private readonly limit: number;
    private readonly amount: number;

    private offset = 0;

    private btn: HTMLButtonElement;
    private status: HTMLElement;

    constructor(config) {
        this.url = config.url;
        this.limit = config.limit;
        this.amount = config.amount;
    }

    run() {
        this.btn = document.querySelector('#load-postings');

        if (this.checkAmount(this.amount)) {
            this.removeButton();

            return;
        }

        this.btn.addEventListener('click', this.handlerClick(document.querySelector('.posting-list')));
        this.status = this.btn.querySelector('.status');
    }

    checkAmount(amount) {
        return amount < this.limit;
    }

    removeButton() {
        this.btn.remove();
    }

    handlerClick(htmlList) {
        return () => {
            this._loadingBegin();
            this.offset += this.limit;
            fetch(this.url, {
                method: 'POST',
                body  : JSON.stringify({limit: this.limit, offset: this.offset})
            })
                .then(res => res.json())
                .then(data => {
                    this._loadingFinish();
                    if (this.checkAmount(data.amount)) {
                        this.removeButton();
                    }
                    htmlList.innerHTML += data.html;
                })
                .catch(err => {
                    this._loadingError();
                    this.offset -= this.limit;
                    console.error(err);
                })
            ;
        }
    }

    _loadingBegin() {
        this._toggleIcon(true, 'error');
        this._toggleIcon(true, 'finish');
        this._toggleIcon(false, 'begin');
    }

    _loadingFinish() {
        this._toggleIcon(true, 'begin');
        this._toggleIcon(false, 'finish');
    }

    _loadingError() {
        this._toggleIcon(true, 'begin');
        this._toggleIcon(false, 'error');
    }

    _toggleIcon(needHidden, token) {
        if (needHidden === true) {
            this.status.classList.remove(token);
        } else {
            this.status.classList.add(token);
        }
    }

}

window.addEventListener('load', () => {
    const btn: HTMLButtonElement = document.querySelector('#collapsed-form-add');
    const character: HTMLDivElement = btn.querySelector('.character');
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
