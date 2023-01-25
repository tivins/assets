import {Clipboard, LocalNotifier, MA, MagiCron} from "/assets/ma.js";

console.debug(MA.version());

MagiCron.setInterval(100).run();
Clipboard.parseCopiable();

export function getLoader()
{
    return `<div class="subtext"><i class="fa-solid fa-circle-notch fa-spin mr-2"></i>Loading&hellip;</div>`;
}