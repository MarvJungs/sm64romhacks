import './bootstrap';
import '@popperjs/core';
import Tooltips from './Tooltips';
import Editor from './Editor';
import Time from './time';
import HacksTable from './hacksTable';
import RomPatcher from './rompatcher';
import PillButton from './pillButton';
import MegapackFilter from './MegapackFilter';
import Schedule from './Schedule';
import CheatcodesClipboardManager from './CheatcodesClipboardManager';
import CurrentTimeService from './CurrentTimeService';
import CarouselManager from './CarouselManager';
import ModalsManager from './ModalsManager';

const hiddenButtons = document.querySelectorAll('button[type=hidden]');
hiddenButtons.forEach(button => {
    const toggle = button.getAttribute('data-bs-toggle');
    if (toggle)
    {
        const target = button.getAttribute('data-bs-target');
        if (target && document.querySelector(target))
        {
            button.click();
            return;
        }
    }
});

const newsEditor = new Editor('newsEditor', 'newsposts', 'createNewspost', 'text');
const eventsEditor = new Editor('eventsEditor', 'events', 'manageEvent', 'description');
const carouselManager = new CarouselManager();
const modalsManager = new ModalsManager();

const newsPostsSubmitButton = document.getElementById('newsSubmitButton');
const eventSubmitButton = document.getElementById('eventSubmitButton');
if (newsPostsSubmitButton) {
    newsPostsSubmitButton.addEventListener('click', () => newsEditor.save());
}

if (eventSubmitButton) {
    eventSubmitButton.addEventListener('click', () => eventsEditor.save());
}

const hacksdescriptionEditor = new Editor('editor', 'hacks', 'manageRomhack', 'romhack.description');
const hackSubmissionButton = document.getElementById('submissionButton');
if (hackSubmissionButton) {
    hackSubmissionButton.addEventListener('click', () => hacksdescriptionEditor.save());
}

const time = new Time();
time.run();

const schedule = new Schedule();
const cheatcodesClipboardManager = new CheatcodesClipboardManager();
const currentTimeService = new CurrentTimeService();

const hacksTable = new HacksTable();
hacksTable.main();

const patcher = new RomPatcher();
patcher.main();

const tooltipsmanager = new Tooltips();
tooltipsmanager.main();

const tagButtons = new PillButton({id: 'manageRomhack', inputid: 'romhack[tag][name]'});
const authorButtons = new PillButton({id: 'manageRomhack', inputid: 'romhack[version][author][name]'});
const vauthorButtons = new PillButton({id: 'manageVersion', inputid: 'version[author][name]'});
const roleButtons = new PillButton({id: 'manageRoles', inputid: 'roles'});

tagButtons.main();
authorButtons.main();
vauthorButtons.main();
roleButtons.main();

const megapackFilter = new MegapackFilter();
megapackFilter.main();