import {Baz, Box} from "./baz.js";
import {closeButtonEvent, Cookies, LocalNotifier, MA} from "./ma.js";

Baz.init();

MA.parseElements('btn-response',
    elm => elm.addEventListener('click',
        event => document.getElementById('frame-viewer').style.width = elm.getAttribute('data-width')
    )
)

MA.parseElements('btn-action', elm =>
    elm.addEventListener('click', event => {
        event.preventDefault();
        const action = elm.getAttribute('data-action');
        console.log(action);
        switch (action) {
            case 'GDPR-accept':
                Cookies.setCookie('GDPR', 'all', 360);
                closeButtonEvent(elm);
                break;
            case 'GDPR-reject':
                Cookies.setCookie('GDPR', 'none', 360);
                closeButtonEvent(elm);
                break;
            case 'GDPR-setup':
                /*localStorage.setItem('GDPR', 'none');*/
                /*closeButtonEvent(elm);*/
                break;
        }
    })
);

export class CookieInfo {
    name = '';
    details = '';
    required = false;
    options = [];

    constructor(name,required,details,options) {
        this.name = name;
        this.required = required;
        this.details = details;
        this.options = options;
    }
}

export function ParseCookieRemovers() {
    MA.parseElements('cookie-remover', elm => {
        elm.addEventListener('click', event => {
            event.preventDefault();
            console.log(elm.getAttribute('data-cookie'));
            Cookies.remove(elm.getAttribute('data-cookie'));
            LocalNotifier.show(elm, 'Cookie marked as expired.\nRefresh the page to apply changes.', 2000, "fa fa-info");
        });
    });
}

ParseCookieRemovers();

MA.parseElements('cookie-list', elm =>
{
    const cooks = Cookies.getCookies();

    const cooksInfo = {};
    cooksInfo['GDPR'] = new CookieInfo('GDPR', true,
        'This cookie store your choice about cookie acceptation (General Data Protection Regulation).',[
        {value: "#undefined", info: 'No decision was validated (same as "none").'},
        {value: "all", info: 'All cookies are accepted.'},
        {value: "none", info: 'All non-required cookies are rejected.'},
    ]);
    cooksInfo['theme'] = new CookieInfo('theme', false,
        'This cookie store your choice about theme selection (day/night theme).', [
        {value: "#undefined", info: 'No decision was validated (day theme by default).'},
        {value: "", info: 'Day theme.'},
        {value: "dark", info: 'Dark theme.'},
    ]);


    let content = MA.createElement('div',{},{});

    function makeBox(cookInfo, z) {
        if (!z) return;
        const box = new Box();
        const cookieExists = typeof cooks[z] !== 'undefined';
        let options = `<table class="table"><caption>Possible values</caption>`
            + cookInfo.options.map(e => {
                return `<tr>
                <td>${e.value === '#undefined' ? `<i>not set</i>` : `<code>"${e.value}"</code>`}</td>
                <td>${(e.value === '#undefined' && !cookieExists) || (cooks[z] === e.value) ? '<i class="fa fa-check"></i> selected' : ''}</td>
                <td>${e.info}</td>
            </tr>`;
            }).join('')
            + `</table>`;

        box.setTitleHTML(`
            <b>${z}</b>
            <span class="tag ${cookInfo.required ? 'info' : ''}">${cookInfo.required ? 'required' : 'optional'}</span>
            <div class="subtext">${cookInfo.details}</div>
            `)
            .setBodyClass('p')
            .setBodyHTML(/*`<p>${cookInfo.details}</p>` + */options)
            // .setFooterClass('p', 'no-background')
            // .setFooterHTML(`<div>Current value : <code>"${cooks[z]}"</code></div>`)
            //.addOption(MA.createElement('span', {
            //    className: 'header-item ' + (cookInfo.required ? 'text-danger' : ''),
            //    innerText: cookInfo.required ? 'required' : 'optional'
            //}, {}))
            .appendTo(content);

        if (cookieExists) {

            box.addOption(MA.createElement('a', {
                className: 'header-item cookie-remover ' + (cookInfo.required ? 'text-danger' : ''),
                href: "#",
                innerHTML: '<i class="fa fa-trash-alt"></i>'
            }, {
                "data-cookie": z
            }));

        }
    }

    for (let z in cooks) {
        makeBox(cooksInfo[z], z);
    }
    for (let z in cooksInfo) {
        if (cooks[z] === undefined) {
            makeBox(cooksInfo[z], z);
        }
    }

    elm.innerHTML = '<h3>Cookies</h3>'
    elm.appendChild(content);
    ParseCookieRemovers();
});