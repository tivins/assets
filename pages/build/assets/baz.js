import {MA} from "./ma.js";

export class Box {

    /** @type {HTMLElement} */
    #element = null;
    /** @type {HTMLElement} */
    #elementHeader = null;
    /** @type {HTMLElement} */
    #elementHeaderTitle = null;
    #elementBody;
    #elementFooter;

    construct() {
        this.#element = document.createElement('div');
        this.#element.classList.add('box','mb-3');
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

}
export class PopOver {
    static #element;
    static get() {
        if (!this.#element) {
            this.#init();
        }
        return this.#element;
    }
    static #init() {
        this.#element = MA.createElement('div', {
            className: 'pop-over pop-more hidden'
        },{});
        document.body.append(this.#element);
        document.addEventListener('click', (e) => {
            this.#element.classList.add('hidden');
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