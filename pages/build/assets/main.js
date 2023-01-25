import {Clipboard, LocalNotifier, MA, MagiCron} from "/assets/ma.js";

console.debug(MA.version());
/*
MagiCron.append(() => {
    document.querySelectorAll('[data-expire]').forEach(elm => {
        const expire = elm.getAttribute('data-expire');
        if (new Date().getTime() > expire) {
            elm.classList.add('hidden');
        }
    });
}).run();*/
MagiCron.setInterval(100).run();

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