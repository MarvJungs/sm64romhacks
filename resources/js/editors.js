import Editor from './editor';

document.addEventListener('DOMContentLoaded', function () {
    const eventEditor = new Editor('eventForm', 'editor-description', 'description');
    const hackEditor = new Editor('hackForm', 'editor-description', 'description');
    const newsEditor = new Editor('newsForm', 'editor-text', 'text');
    const cheatEditor = new Editor('cheatForm', 'editor-description', 'description');
});