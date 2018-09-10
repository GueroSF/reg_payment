class Holder {
    private _input: string;
    private _sum: string;


    constructor(input: string, sum: string) {
        this._input = input;
        this._sum = sum;
    }

    get input(): string {
        return this._input;
    }

    get sum(): string {
        return this._sum;
    }
}

class CalculatorBoard {
    private _board: HTMLDivElement = document.querySelector('#calculator');
    private _boardInput: HTMLInputElement = this._board.querySelector('input');
    private _strResult: HTMLSpanElement = this._board.querySelector('.result span');

    private _btn: HTMLInputElement = document.querySelector('#calculator_btn input');

    private _storage: CalculatorStorage = new CalculatorStorage();
    private _calc: Calculator = new Calculator();

    private _form: HTMLFormElement = document.querySelector('#paymentAdd');

    constructor() {
        const holder: Holder = this._storage.get();

        if (holder !== null) {
            this._btn.checked = true;
            this._boardInput.value = holder.input;
            this._strResult.innerHTML = holder.sum;
            this.show();
        }
    }

    public init(): void {
        const self = this;

        this._boardInput.addEventListener('change', function () {
            self.calculate(this);
        });

        this._btn.addEventListener('change', function (event) {
            if (this.checked) {
                self.show();
            } else {
                self.hide();
                self._storage.remove();
            }
        });

        if (this._form !== null) {
            this._form.addEventListener('submit', function (event) {
                if (self.calcIsEnabled()) {
                    event.preventDefault();
                    let value = (<HTMLSelectElement>this.elements.namedItem('operation')).value === '2' ? '-' : '+';
                    value += (<HTMLInputElement>this.elements.namedItem('money')).value;

                    self._boardInput.value += value;

                    self.calculate(self._boardInput);

                    this.submit();
                }
            })
        }
    }

    public calculate(element: HTMLInputElement): void {
        let holder = new Holder(element.value, this._calc.count(element));

        this._strResult.innerHTML = holder.sum;
        this._storage.set(holder);
    }

    public show(): void {
        this._board.hidden = false;
    }

    public hide(): void {
        this._board.hidden = true;
        this.clearHtml();
    }

    private clearHtml(): void {
        this._boardInput.value = '';
        this._strResult.innerHTML = '';
    }

    public calcIsEnabled(): boolean {
        return this._btn.checked;
    }
}

class CalculatorStorage {
    private _store: Storage = window.localStorage;
    private _key: string = 'calcStorage';

    public set(holder: Holder): void {
        this._store.setItem(this._key, JSON.stringify(holder));
    }

    public get(): Holder {
        let rawData = JSON.parse(this._store.getItem(this._key));

        if (rawData === null) {
            return null;
        }

        return new Holder(rawData._input, rawData._sum);
    }

    public remove(): void {
        this._store.removeItem(this._key);
    }
}

class Calculator {
    public count(inputElement: HTMLInputElement): string {
        return this._parseString(inputElement.value);
    }

    private _parseString(string: string): string {
        let result: number = 0;

        string.match(/((\D)?\s?\d*)/gm).forEach(function (value: string) {
            let act: RegExpExecArray = /(\D)?(\d*)/.exec(value.trim());

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
    }
}

window.addEventListener('load', function () {
    const calcBoard = new CalculatorBoard();

    calcBoard.init();
});