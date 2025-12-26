import EditorJS from "@editorjs/editorjs";
import Header from "@editorjs/header";
import Image from "@editorjs/image";
import List from "@editorjs/list";

export default class Editor {
    editor;
    constructor(holderid, path, formid, attr) {
        if (!document.getElementById(holderid)) return;
        this.token = document.querySelector(`input[name=_token]`);
        const dataElement = document.getElementById(attr);
        this.token = this.token.getAttribute('value');
        this.attr = attr;
        this.formid = formid;
        this.editor = new EditorJS({
            holder: holderid,
            inlineToolbar: true,
            tools: {
                header: Header,
                image: {
                    class: Image,
                    config: {
                        additionalRequestHeaders: {
                            "X-CSRF-TOKEN": this.token
                        },
                        endpoints: {
                            byFile: `/${path}/images/upload`,
                            byUrl: `${path}/images/fetchUrl`
                        }
                    }
                },
                list: List,
            },
            data: JSON.parse(dataElement.getAttribute('value'))
        });
    }

    save() {
        this.editor.save().then((data) => {
            const form = document.getElementById(this.formid);
            const textElement = document.getElementById(this.attr);
            textElement.setAttribute('value', JSON.stringify(data));
            form.submit();
        });
    }
}