require('../css/last-operations.scss');
import {postingCalculate, PostingCalculate} from './posting-calculate';

class LastOperations {

    constructor(private _calculator: PostingCalculate) {
    }

    public run():void {
        this._calculator.initListener('.calculator-last-operation','.math-checkbox');
    }
}

const lastOperations = new LastOperations(postingCalculate);
window.addEventListener('load', () => {
    lastOperations.run();
});
