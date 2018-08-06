'use strict';
var Button = /** @class */ (function () {
    function Button(name) {
        this.name = name;
        this.init();
        this.addEvent();
    }
    Button.prototype.init = function () {
        this.divButton = document.querySelector('.' + this.name);
        this.action = this.divButton !== null;
    };
    Button.prototype.addEvent = function () {
        if (!this.action) {
            return;
        }
        var self = this;
        this.divButton.querySelector('button').addEventListener('click', function (e) {
            document.querySelectorAll('.month').forEach(function (elem) {
                elem.classList.remove('hide');
                self.hide();
            });
        });
    };
    Button.prototype.hide = function () {
        if (!this.action) {
            return;
        }
        this.divButton.classList.add('hide');
    };
    Button.prototype.hideIfNull = function () {
        if (!this.action) {
            return;
        }
        var hideMonth = document.querySelectorAll('.hide');
        if (hideMonth.length === 0) {
            this.hide();
        }
    };
    return Button;
}());
window.addEventListener('load', function () {
    var b = new Button('button_for_view_if_zero');
    b.hideIfNull();
});
