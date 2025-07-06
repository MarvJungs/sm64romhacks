import './bootstrap';
import '@popperjs/core';
// import '/node_modules/bootstrap/dist/js/bootstrap.min.js';
// import { Dropdown } from 'bootstrap';
import Tooltips from './Tooltips';
import Editor from './Editor';
import Time from './time';
import HacksTable from './hacksTable';
import RomPatcher from './rompatcher';
import PillButton from './pillButton';
import FuckYou from './FuckYou';
import MegapackFilter from './MegapackFilter';

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
const newsPostsSubmitButton = document.getElementById('submissionButton');
if (newsPostsSubmitButton) {
    newsPostsSubmitButton.addEventListener('click', function () {
        newsEditor.save();
    });
}

const hacksdescriptionEditor = new Editor('editor', 'hacks', 'manageRomhack', 'romhack.description');
console.log(hacksdescriptionEditor);
const hackSubmissionButton = document.getElementById('submissionButton');
if (hackSubmissionButton) {
    hackSubmissionButton.addEventListener('click', () => {
        hacksdescriptionEditor.save();
    });
}

const time = new Time();
time.run();

// document.addEventListener('mousemove', function (e) {
//     console.log(e.clientX, e.clientY);
// })

const hacksTable = new HacksTable();
hacksTable.main();

const patcher = new RomPatcher();
patcher.main();

const tooltipsmanager = new Tooltips();
tooltipsmanager.main();

const tagButtons = new PillButton({id: 'manageRomhack', inputid: 'romhack[tag]'});
const authorButtons = new PillButton({id: 'manageRomhack', inputid: 'romhack[version][author][name]'});
const vauthorButtons = new PillButton({id: 'manageVersion', inputid: 'version[author][name]'})

tagButtons.main();
authorButtons.main();
vauthorButtons.main();

const megapackFilter = new MegapackFilter();
megapackFilter.main();