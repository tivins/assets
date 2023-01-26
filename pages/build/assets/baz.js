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