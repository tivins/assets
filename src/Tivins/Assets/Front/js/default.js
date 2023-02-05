import {Baz} from "./baz.js";
import {closeButtonEvent, MA} from "./ma.js";

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
                MA.setCookie('GDPR', 'all', 360);
                closeButtonEvent(elm);
                break;
            case 'GDPR-reject':
                MA.setCookie('GDPR', 'none', 360);
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
    name;
    details;
    required=false;
}


MA.parseElements('cookie-list', elm =>
{
    const cooks = MA.getCookies();
    const cookInfo = [];


    let html = `<table class="table">`;
    html += `<tr><th>Name</th><th>Type</th><th>Value</th></tr>`;
    for (let z in cooks) {
        let details = '';
        if (z === 'GDPR') {
            details = `This cookie store your choice about cookie acceptation.
            <ul>
                <li>"all": All cookies are accepted.</li>
                <li>"none": All non-require cookies are rejected.</li>
            </ul>
            `
        }
        html += `<div class="box my"><code>${z}</code><div><div class="tag">required</div></div><div>"${cooks[z]}"</div><div>${details}</div></div>`;
    }
    html += `<table>`;
    elm.innerHTML = html;
});