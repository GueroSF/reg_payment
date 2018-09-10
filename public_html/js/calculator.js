var Holder = /** @class */ (function () {
    function Holder(input, sum) {
        this._input = input;
        this._sum = sum;
    }
    Object.defineProperty(Holder.prototype, "input", {
        get: function () {
            return this._input;
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(Holder.prototype, "sum", {
        get: function () {
            return this._sum;
        },
        enumerable: true,
        configurable: true
    });
    return Holder;
}());
var CalculatorBoard = /** @class */ (function () {
    function CalculatorBoard() {
        this._board = document.querySelector('#calculator');
        this._boardInput = this._board.querySelector('input');
        this._strResult = this._board.querySelector('.result span');
        this._btn = document.querySelector('#calculator_btn input');
        this._storage = new CalculatorStorage();
        this._calc = new Calculator();
        this._form = document.querySelector('#paymentAdd');
        var holder = this._storage.get();
        if (holder !== null) {
            this._btn.checked = true;
            this._boardInput.value = holder.input;
            this._strResult.innerHTML = holder.sum;
            this.show();
        }
    }
    CalculatorBoard.prototype.init = function () {
        var self = this;
        this._boardInput.addEventListener('change', function () {
            self.calculate(this);
        });
        this._btn.addEventListener('change', function (event) {
            if (this.checked) {
                self.show();
            }
            else {
                self.hide();
                self._storage.remove();
            }
        });
        if (this._form !== null) {
            this._form.addEventListener('submit', function (event) {
                if (self.calcIsEnabled()) {
                    event.preventDefault();
                    var value = this.elements.namedItem('operation').value === '2' ? '-' : '+';
                    value += this.elements.namedItem('money').value;
                    self._boardInput.value += value;
                    self.calculate(self._boardInput);
                    this.submit();
                }
            });
        }
    };
    CalculatorBoard.prototype.calculate = function (element) {
        var holder = new Holder(element.value, this._calc.count(element));
        this._strResult.innerHTML = holder.sum;
        this._storage.set(holder);
    };
    CalculatorBoard.prototype.show = function () {
        this._board.hidden = false;
    };
    CalculatorBoard.prototype.hide = function () {
        this._board.hidden = true;
        this.clearHtml();
    };
    CalculatorBoard.prototype.clearHtml = function () {
        this._boardInput.value = '';
        this._strResult.innerHTML = '';
    };
    CalculatorBoard.prototype.calcIsEnabled = function () {
        return this._btn.checked;
    };
    return CalculatorBoard;
}());
var CalculatorStorage = /** @class */ (function () {
    function CalculatorStorage() {
        this._store = window.localStorage;
        this._key = 'calcStorage';
    }
    CalculatorStorage.prototype.set = function (holder) {
        this._store.setItem(this._key, JSON.stringify(holder));
    };
    CalculatorStorage.prototype.get = function () {
        var rawData = JSON.parse(this._store.getItem(this._key));
        if (rawData === null) {
            return null;
        }
        return new Holder(rawData._input, rawData._sum);
    };
    CalculatorStorage.prototype.remove = function () {
        this._store.removeItem(this._key);
    };
    return CalculatorStorage;
}());
var Calculator = /** @class */ (function () {
    function Calculator() {
    }
    Calculator.prototype.count = function (inputElement) {
        return this._parseString(inputElement.value);
    };
    Calculator.prototype._parseString = function (string) {
        var result = 0;
        string.match(/((\D)?\s?\d*)/gm).forEach(function (value) {
            var act = /(\D)?(\d*)/.exec(value.trim());
            if (act[2] !== undefined && act[2] !== '') {
                switch (act[1]) {
                    case '+':
                        result = result + parseInt(act[2]);
                        break;
                    case '-':
                        result = result - parseInt(act[2]);
                        break;
                    default:
                        result = parseInt(act[2]);
                }
            }
        });
        return String(result);
    };
    return Calculator;
}());
window.addEventListener('load', function () {
    var calcBoard = new CalculatorBoard();
    calcBoard.init();
});
