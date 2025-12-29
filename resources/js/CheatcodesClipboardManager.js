export default class CheatcodesClipboardManager
{
    section;
    constructor()
    {
        this.section = document.getElementById('cheatcodes');
        if (!this.section) return;
        this.main();
    }

    main()
    {
        const cheatcodeSections = this.section.querySelectorAll('div[id]');
        Array.from(cheatcodeSections).forEach((cheatcodeSection) => {
            const code = cheatcodeSection.querySelector('code');
            const copyButton = cheatcodeSection.querySelector('button[name]');
            if (!code) {
                throw Error('Could not find Cheatcode');
            }
            if (!copyButton) {
                throw Error('Could not find Copybutton');
            }
            copyButton.addEventListener('click', () => navigator.clipboard.writeText(code.innerText));
        });
    }
}