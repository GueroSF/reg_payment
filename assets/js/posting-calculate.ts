interface Money {
    money: number;
    use: boolean;
}

export class PostingCalculate {
    private _holderMoney: {[key:string]: Money} = {};
    private _element: HTMLDivElement;

    public constructor(private _doc: Document) {
    }

    public initListener(resultWrapper: string, elementsWithData: string): void {
        this._element = this._doc.querySelector(resultWrapper);

        this._doc.querySelectorAll(elementsWithData).forEach((input: HTMLInputElement) => {
            const action = parseInt(input.dataset.type, 10) === 1 ? '+' : '-';
            this._holderMoney[input.id] = {
                money: parseInt(action + input.dataset.money),
                use: input.checked
            }
            input.addEventListener('change', () => {
                this._holderMoney[input.id].use = input.checked;
                this.handlerChange();
            })
        })
    }

    private handlerChange(): void {
        const summ = this.calculator();

        if (0 === summ) {
            this._element.classList.add('hide');
        } else {
            this._element.classList.remove('hide');
            this._element.innerText = String(summ);
        }
    }

    private calculator(): number {
        return Object.values(this._holderMoney).reduce( (accumulator: number, money: Money) => {
            if (money.use) {
                return accumulator + money.money;
            }

            return  accumulator;
        },0);
    }
}

export const postingCalculate = new PostingCalculate(document);
