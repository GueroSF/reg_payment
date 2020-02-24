'use strict';

class Button {
    name: string;
    action: boolean;
    divButton: HTMLDivElement;

    constructor(name: string) {
        this.name = name;
        this.init();
        this.addEvent();
    }

    private init() {
        this.divButton = document.querySelector('.'+ this.name);
        this.action = this.divButton !== null;
    }

    private addEvent() {
        if (!this.action) {
            return;
        }
        let self = this;
        this.divButton.querySelector('button').addEventListener('click', function (e) {
            document.querySelectorAll('.month').forEach(function (elem) {
                elem.classList.remove('hide');
                self.hide();
            })
        })
    }

    private hide() {
        if (!this.action) {
            return;
        }
        this.divButton.classList.add('hide');
    }

    hideIfNull() {
        if (!this.action) {
            return;
        }

        let hideMonth = document.querySelectorAll('.hide');

        if (hideMonth.length === 0) {
            this.hide();
        }

    }
}

window.addEventListener('load', function () {
    let b = new Button('button_for_view_if_zero');
    b.hideIfNull();
});