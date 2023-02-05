import {List, PopOver} from "./baz.js";

export class MA {
    static version() {
        return {
            major: 0, minor: 1, revision: 0
        };
    }

    /**
     * @param elm {HTMLElement}
     * @returns {{top: number, left: number}}
     */
    static getOffset(elm) {
        const rect = elm.getBoundingClientRect();
        return {
            left: rect.left + window.scrollX, top: rect.top + window.scrollY
        };
    }

    /**
     * Shortcut to create HTMLElement.
     * Allows to assign properties and attributes in one call.
     *
     * Example:
     *
     * ```js
     * const elm = MA.createElement('div', {
     *     id: "my-id",
     *     innerText: "This is safe"
     * }, {
     *     "data-target": ".my-element"
     * });
     * ```
     *
     *
     * @param tagName {string}
     * @param props {object} Assign properties
     * @param attrs {object} Calls setAttribute(k, v)
     * @returns {HTMLElement}
     */
    static createElement(tagName, props, attrs) {
        const obj = Object.assign(document.createElement(tagName), props);
        for (const z in attrs) obj.setAttribute(z, attrs[z]);
        return obj;
    }

    static createDiv(className, html) {
        return this.createElement('div', {className: className, innerHTML: html}, {});
    }

    /**
     * @param element {HTMLElement}
     */
    static removeElement(element) {
        element.parentNode.removeChild(element);
    }

    /**
     * Look at the `data-target` attribute.
     * If the content is:
     * - "href" and is HTMLAnchorElement, will return the absolute URL pointed by `href` attribute.
     * - "myself", will return the `.innerText` or `.value` of the current HTMLElement.
     * - otherwise, will return the `.innerText` or `.value` of the target HTMLElement defined by a selector.
     *
     * Example:
     * ```html
     * <!-- href -->
     * <a id="ex1" href="/my-path" data-target="href">Copy URL</a>
     * <!-- mysql -->
     * <span id="ex2" data-target="myself">This is <b>the text</b> to <i>copy</i>.</span>
     * <!-- selector -->
     * <button id="ex3-1" data-target="#ex3-2">Trigger</span><div id="ex3-2">lorem <u>ipsum</u></div>
     * <script>
     *     MA.getTargetText(document.getElementById('ex1')); // "http://127.0.0.1:12345/path/my-path"
     *     MA.getTargetText(document.getElementById('ex2')); // "This is the text to copy."
     *     MA.getTargetText(document.getElementById('ex3-1')); // "lorem ipsum"
     * </script>
     * ```
     *
     * @param elm {HTMLElement|HTMLAnchorElement}
     * @returns {null|string}
     */
    static getTargetText(elm) {
        const selector = elm.getAttribute('data-target');
        if (selector === 'href' && elm instanceof HTMLAnchorElement) {
            return elm.href;
        }
        const isItself = selector === 'myself';
        const object = isItself ? elm : document.querySelector(selector);
        if (!object) return null;
        return object.value !== undefined ? object.value : object.innerText;
    }

    static moveOver(elmToMove, target, direction)
    {
        if (!direction) direction = 'top';
        const off = this.getOffset(target);

        let left = (off.left - elmToMove.offsetWidth/2 + target.offsetWidth/2);
        if (left + elmToMove.offsetWidth > window.innerWidth - 10) {
            left = target.offsetLeft + target.offsetWidth - elmToMove.offsetWidth;
        }
        if (left < 0) {
            left = target.offsetLeft;
        }
        elmToMove.style.left = left + 'px';


        if (direction === 'top') {
            elmToMove.style.top  = (off.top - elmToMove.offsetHeight - 8) + 'px';
        }
        if (direction !== 'top' || elmToMove.offsetTop - window.scrollY < 0)
        {
            elmToMove.style.top = (off.top + target.offsetHeight + 7) + 'px';
        }
    }

    /**
     * @param cname {string}
     * @param value {string}
     * @param expDays {number}
     */
    static setCookie(cname, value, expDays) {
        const d = new Date();
        d.setTime(d.getTime() + (expDays * 24 * 60 * 60 * 1000));
        let expires = "expires=" + d.toUTCString();
        document.cookie = `${cname}=${value};${expires};SameSite=None;Secure;path=/`;
    }

    /**
     * @return {{}}
     */
    static getCookies() {
        let cooks = {};
        document.cookie.split(';').map(n => {
            const kv = n.split('=').map(e => e.trim());
            cooks[kv[0]] = kv[1];
        });
        return cooks;
    }

    /**
     * @see https://www.w3schools.com/js/js_cookies.asp
     * @param cname
     * @return {string}
     */
    static getCookie(cname) {
        let name = cname + "=";
        let ca = document.cookie.split(';');
        for(let i = 0; i < ca.length; i++) {
            let c = ca[i].trim();
            if (c.indexOf(name) === 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    static parseElements(className, callback) {
        const classProcessed = className + '-processed';
        document.querySelectorAll(`.${className}:not(.${classProcessed})`)
            .forEach(elm => {
                elm.classList.add(classProcessed);
                callback(elm);
            });
    }
}
export class LocalNotifier {
    /**
     *
     * @type {HTMLElement}
     */
    static #localNotifier = null;
    static get() {
        if (!this.#localNotifier) {
            this.#init();
        }
        return this.#localNotifier;
    }
    /**
     *
     * @param target {HTMLElement}
     * @param contentHTML {string}
     * @param expireInMillis {number} if not "falsey", will disappear after N milliseconds.
     * @param icon {string} "fa-check" or "fa-clone"...
     */
    static show(target, contentHTML, expireInMillis, icon) {
        const localNotifier = this.get();
        localNotifier.classList.remove('hidden');
        localNotifier.innerText = contentHTML;
        localNotifier.prepend(MA.createElement('i',{className:"mr-2 fa fa-fw "+icon},{}));
        if (expireInMillis) {
            const time = new Date().getTime();
            const expireAt = time + expireInMillis;
            localNotifier.setAttribute('data-expire', expireAt);
            localNotifier.setAttribute('data-from', time);
        }
        MA.moveOver(localNotifier, target);
    }
    static #init() {
        this.#localNotifier = MA.createElement('div', {
            className: 'pop-over localNotifier px-3 py-2 hidden'
        },{});
        document.body.append(this.#localNotifier);
    }
}
export class Clipboard {
    static copyToClipboard(text, callback) {
        navigator.clipboard.writeText(text).then(
            () => callback ? callback(null) : null,
            (err) => callback ? callback(err) : null
        );
    }

    /**
     * - Find all element with `.copy` class.
     * - Add 'click' listener
     * - On click, copy target content to clipboard
     *
     * Attributes:
     * - data-text : Specify the text to be used in the tooltip.
     *
     * @see MA.getTargetText()
     * @todo To manage the error case.
     */
    static parseCopiable() {
        document.querySelectorAll('.copy:not(.copy-processed)').forEach((elm) => {
            elm.classList.add('copy-processed');
            elm.addEventListener('click', ev => {
                ev.preventDefault();
                Clipboard.copyToClipboard(
                    MA.getTargetText(elm),
                    (err) => {
                        elm.querySelector('.state-success')?.classList.remove('hidden');
                        elm.querySelector('.state-normal')?.classList.add('hidden');
                        setTimeout(() => {
                            elm.querySelector('.state-success')?.classList.add('hidden');
                            elm.querySelector('.state-normal')?.classList.remove('hidden');
                        },2000);
                        const text = elm.hasAttribute('data-text') ? elm.getAttribute('data-text') : 'Copied!';
                        LocalNotifier.show(elm, err ? err : text, 2000, "fa-regular fa-clone");
                    }
                );
            })
        });
    }
}
export function closeButtonEvent(elm) {
    const dialog = elm.closest('.dialog');
    const menuSM = elm.closest('.menu-sm');
    if (dialog) {
        dialog.classList.add('closed');
        return;
    }
    if (menuSM) {
        menuSM.classList.remove('menu-active');
        return;
    }
    const box = elm.closest('.box');
    if (box) {
        // box.setAttribute('data-from', new Date().getTime().toString());
        // box.setAttribute('data-expire', (new Date().getTime() + 2500).toString());
        // box.setAttribute('data-style', 'slideUp,fadeOut');
        //
        box.style.height = box.offsetHeight + 'px';
        setTimeout(() => box.classList.add('box-closed'), 50);
        setTimeout(() => MA.removeElement(box), 1000);
    }
    return elm;
}
export function parseCloseButtons() {
    MA.parseElements('close-box-btn',
        elm => elm.addEventListener('click', ev => {
            ev.preventDefault();
            closeButtonEvent(elm);
        })
    );
}

export function parsePopupButtons() {
    MA.parseElements('pop-trigger', (elm) => {
        elm.addEventListener('click', ev => {
            ev.preventDefault();
            ev.stopPropagation();

            /*
            const list = new List();
            list.addItem({title:"Log in with StackOverflow", subTitle:"Using StackExchange API", icon: 'fa-brands fa-stack-overflow'});
            list.addItem({title:"Log in with GitHub", subTitle:"", icon: 'fa-brands fa-github'});
            list.addItem({title:"Log in with Google", subTitle:"", icon: 'fa-brands fa-google'});
            */
            const targetElm = document.querySelector(elm.getAttribute('data-target'));
            targetElm.classList.remove('hidden');
            PopOver.show(elm, targetElm);
        });
    });
}

export class Theme {
    static get() {
        return MA.getCookie('theme');
    }
    static applyCurrent() {
        let oldTheme = this.get();
        if (oldTheme === 'dark') document.body.classList.add('dark-theme');
        else document.body.classList.remove('dark-theme');
    }
    static toggle() {
        let oldTheme = this.get();
        let newTheme = oldTheme === "dark" ? "" : "dark";
        MA.setCookie("theme", newTheme, 30);
        this.applyCurrent();
    }
    static initButtons() {
        MA.parseElements('toggle-theme', elm => {
            elm.addEventListener('click', event => {
                event.preventDefault();
                elm.blur();
                this.toggle();
            });
        });
    }
}
export class MagiCron {
    static #callbacks = [
        MagiCron.expirer
    ];
    static #intervalId = null;
    static #interval = 1000;
    static append(callback) {
        this.#callbacks.push(callback);
        return this;
    }

    /**
     * @param milliseconds {number}
     * @return {MagiCron}
     */
    static setInterval(milliseconds) {
        this.#interval = milliseconds;
        return this;
    }

    /**
     * @return {MagiCron}
     */
    static stop() {
        if (this.#intervalId) {
            window.clearInterval(this.#intervalId);
        }
        return this;
    }

    /**
     *
     * @return {MagiCron}
     */
    static run() {
        this.stop();
        this.#intervalId = window.setInterval(
            () => this.#callbacks.map(val => val()),
            this.#interval);
        return this;
    }

    static expirer() {
        document.querySelectorAll('[data-expire]:not(.hidden)').forEach(elm => {
            if (!elm.hasAttribute('data-expire')) {
                return;
            }
            const styles = elm.hasAttribute('data-style')
                ? elm.getAttribute('data-style').split(',')
                : ['fadeOut'];
            const expireAt = elm.getAttribute('data-expire');
            const created = elm.getAttribute('data-from');
            const time = new Date().getTime();
            if (time > expireAt) {
                elm.classList.add('hidden');
                return;
            }
            if (styles.indexOf('fadeOut') !== -1) {
                //elm.style.opacity = (1 - (time - created) / (expireAt - created)).toString();
            }
        });
    }
}
