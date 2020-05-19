require('../css/toast.scss');

declare const holderMessages: Message[]

enum ToastType {
    Susses = 1,
    Error = 2,
    Info = 3
}

interface Message {
    url: string,
    type: ToastType,
    title: string,
    text: string | null
}

class Toast {
    private _wrap: HTMLDivElement;
    private _holderMessages: Message[];

    constructor(private _doc: Document) {
    }

    public init(messages: Message[]): void {
        this._holderMessages = messages;
        if (this._holderMessages.length === 0) {
            return;
        }

        this._wrap = this._doc.createElement('div');
        this._wrap.classList.add('toast-container');

        this._doc.body.appendChild(this._wrap);
    }

    public showAll(): void {
        this._holderMessages.forEach(message => this.show(message))
    }

    public show(message: Message): void {
        this._wrap.appendChild(this.createElement(message));
    }

    private createElement(messageData: Message): HTMLDivElement {
        const message = this._doc.createElement('div');
        message.classList.add('toast', this.calcClass(messageData.type));

        const titleContainer = this._doc.createElement('div');
        titleContainer.classList.add('title-container');

        const titleWrap = this._doc.createElement('div');
        titleWrap.classList.add('title');
        titleWrap.innerText = messageData.title;

        const action = this._doc.createElement('button');
        action.innerText = 'x';
        action.onclick = this.handlerClickButton(messageData, message);

        titleContainer.append(titleWrap, action);
        message.appendChild(titleContainer);

        if (messageData.text !== null) {
            const textWrap = this._doc.createElement('div');
            textWrap.classList.add('text');
            textWrap.innerText = messageData.text;

            message.appendChild(textWrap);
        }

        return message;
    }

    private handlerClickButton(message: Message, parentNode: HTMLDivElement): () => void {
        return () => {
            parentNode.classList.add('marked-as-read');
            fetch(message.url,{method: 'POST'})
                .then(() => {
                    parentNode.remove();
                });
        }
    }

    private calcClass(type: ToastType): string {
        switch (type) {
            case ToastType.Error:
                return 'error';
            case ToastType.Susses:
                return 'success';
            default:
                return 'info';
        }
    }
}

const toast = new Toast(document);
window.addEventListener('load', () => {
    toast.init(holderMessages);
    toast.showAll();
});
