export class MA {
    static version() {
        return {
            major: 0, minor: 1, revision: 0
        };
    }

    /**
     * @param elm {element}
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
        const off = MA.getOffset(target);
        const localNotifier = this.get();
        localNotifier.classList.remove('hidden');
        localNotifier.innerText = contentHTML;
        localNotifier.prepend(MA.createElement('i',{className:"mr-2 fa fa-fw "+icon},{}));
        localNotifier.style.top = (off.top - localNotifier.offsetHeight - 8) + 'px';
        localNotifier.style.left = (off.left - localNotifier.offsetWidth/2 + target.offsetWidth/2) + 'px';
        localNotifier.style.opacity = 1;
        if (expireInMillis) {
            const time = new Date().getTime();
            const expireAt = time + expireInMillis;
            localNotifier.setAttribute('data-expire', expireAt);
            localNotifier.setAttribute('data-from', time);
        }
    }
    static #init() {
        this.#localNotifier = MA.createElement('div', {
            className: 'localNotifier px-3 py-2 hidden'
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
    static parseCopiable() {

        document.querySelectorAll('.copy:not(.copy-processed)').forEach((elm) => {
            elm.classList.add('copy-processed');
            elm.addEventListener('click', ev => {
                ev.preventDefault();
                const out = elm.querySelector('.copy-out');
                Clipboard.copyToClipboard(
                    MA.getTargetText(elm),
                    (err) => {
                        const text = elm.hasAttribute('data-text') ? elm.getAttribute('data-text') : 'Copied!';
                        LocalNotifier.show(elm, err ? err : text, 2000, "fa-regular fa-clone");
                    }
                );
            })
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
    static setInterval(milliseconds) {
        this.#interval = milliseconds;
        return this;
    }
    static run() {
        this.#intervalId = window.setInterval(() => {
            this.#callbacks.map((val, idx, arr) => {
                val();
            });
        }, this.#interval);
    }
    static expirer() {
        document.querySelectorAll('[data-expire]:not(.hidden)').forEach(elm => {
            console.log("1")
            if (elm.hasAttribute('data-expire')) {
                const expireAt = elm.getAttribute('data-expire');
                const created  = elm.getAttribute('data-from');
                const time     = new Date().getTime();
                if (time > expireAt) {
                    elm.classList.add('hidden');
                    return;
                }
                elm.style.opacity = 1 - (time - created) / (expireAt - created);
            }
        });
    }
}