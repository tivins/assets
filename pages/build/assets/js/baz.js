import {
    Clipboard,
    MA,
    MagiCron,
    parseCloseButtons,
    parsePopupButtons,
    Theme
} from "./ma.js";

export class Box {

    /** @type {HTMLElement} */
    #element = null;
    /** @type {HTMLElement} */
    #elementHeader = null;
    /** @type {HTMLElement} */
    #elementHeaderTitle = null;
    /** @type {HTMLElement} */
    #elementBody;
    /**
     * Footer of the box
     * @type {HTMLElement}
     * */
    #elementFooter;

    constructor() {
        this.#element = document.createElement('div');
        this.#element.classList.add('box','mb');
        this.#elementHeader = document.createElement('div');
        this.#elementHeader.classList.add('header');
        this.#elementHeaderTitle = document.createElement('div');
        this.#elementHeaderTitle.classList.add('header-item', 'title');
        this.#elementHeaderTitle.innerText = 'Title';
        this.#elementBody = MA.createElement('div',{className:'body'},{});
        this.#elementFooter = MA.createElement('div',{className:'footer'},{});
        this.#elementHeader.append(this.#elementHeaderTitle);
        this.#element.append(this.#elementHeader,this.#elementBody,this.#elementFooter);
    }
    appendTo(node) {
        node.appendChild(this.#element);
    }
    setBodyClass(...c) {
        this.#elementBody.classList.add(c);
        return this;
    }
    setBodyHTML(v) {
        this.#elementBody.innerHTML = v;
        return this;
    }
    setFooterHTML(v) {
        this.#elementFooter.innerHTML = v;
        return this;
    }
    setFooterClass(...c) {
        this.#elementFooter.classList.add(c);
        return this;
    }
    addOption(e) {
        this.#elementHeader.append(e);
        return this;
    }
    addCloseButton() {
        let closeBtn = MA.createElement('a', {
            className: 'header-item p close-box-btn',
            innerHTML: `<i class="fa fa-fw fa-times"></i>`,
            href: "#",
        }, {});
        return this.addOption(closeBtn);
    }
}

class Base {
    static element;
    static get() {
        if (!this.element) {
            this.init();
        }
        return this.element;
    }
    static init() {
        this.element = document.createElement('div');
        document.body.append(this.element);
        return this.element;
    }
}

export class Dialog extends  Base {
    static box;
    static init() {
        const elm = Base.init();
        elm.className = 'dialog closed';

        this.box = new Box();
        this.box
            .addCloseButton()
            .setBodyHTML('Hello <b>World</b>')
            .setBodyClass('p-3')
            .setFooterClass('p-1')
            .setFooterHTML(`
                <button class="ghost close-box-btn">Cancel</button>
                <div class="flex-grow"></div>
                <button class=" success ml close-box-btn">OK</button>
            `);
        this.box.appendTo(elm);

        parseCloseButtons();
    }
    static show() {
        this.get().classList.remove('closed');
    }
}
HTMLElement.prototype.on = function(eventType,callback) {
    this.addEventListener(eventType,callback);
    return this;
}


export class PopOver {
    static element;
    static get() {
        if (!this.element) {
            this.init();
        }
        return this.element;
    }
    static init() {
        this.element = MA.createElement('div', {
            className: 'pop-over pop-more hidden'
        },{});
        document.body.append(this.element);
        document.addEventListener('click', (e) => {
            this.element.classList.add('hidden');
        });
    }

    /**
     *
     * @param target
     * @param data {Array}
     */
    static show(target, data) {
        const elm = this.get();
        elm.classList.remove('hidden');
        elm.style.opacity = '1';

        const list = MA.createElement('div',{className:'link-list'},{});

        data.forEach(itm => {
            // html += `<div class="item-link p-2"><a href="#" class="d-block">item${itm}yo!</a></div>`;
            const listItem = MA.createDiv('list-item',`
                <a href="#" class="d-flex item-link">
                  <i class="fs-200 ${itm.icon} p-3 op-025" style="text-align:center;width:5rem"></i>
                  <div class="flex-grow py-3 pr-4">
                    <div class="as-link">${itm.title}</div>
                    <div class="subtext-2">${itm.subTitle}</div>
                  </div>
                </a>
            `);
            list.appendChild(listItem);
        });

        elm.innerHTML = '';
        elm.appendChild(list);
        setTimeout(()=>{}, 0);
        MA.moveOver(elm, target, 'down');
    }
}


export class Baz {
    static init() {

        console.debug(MA.version());
        MagiCron.setInterval(1000).run();
        Clipboard.parseCopiable();
        parseCloseButtons();
        parsePopupButtons();
        Theme.initButtons();
        Theme.applyCurrent();
        Dialog.init();
    }
}