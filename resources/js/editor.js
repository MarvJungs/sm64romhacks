import EditorJS from "@editorjs/editorjs";
import Header from '@editorjs/header';
import List from "@editorjs/list";
import Embed from "@editorjs/embed";
import Table from '@editorjs/table';

export default class Editor {
    constructor(form_id, editor_container_id, datafield_id) {
        this.form = document.getElementById(form_id);

        if(!this.form) return;
        

        this.dataField = document.getElementById(datafield_id);
        this.data = !this.dataField.value ? null : JSON.parse(this.dataField.value);
        this.editor = new EditorJS({
            holder: editor_container_id,
            tools: {
                header: {
                    class: Header,
                    inlineToolbar: ["link"]
                },
                list: {
                    class: List,
                    inlineToolbar: true
                },
                embed: {
                    class: Embed,
                    inlineToolbar: false,
                    config: {
                        services: {
                            youtube: true,
                            coub: true
                        }
                    }
                },
                table: {
                    class: Table,
                    inlineToolbar: true
                }
            },
            data: {
                blocks: this.data
            }
        });

        this.setSubmitEventListener();
    }

    setSubmitEventListener() {
        this.form.addEventListener('submit', (event) => {
            event.preventDefault();

            this.editor.save()
            .then((outputData) => {
                this.dataField.value = JSON.stringify(outputData.blocks);
            })
            .then(() => {
                this.form.submit();
            })
            .catch((error) => {
                console.error('Saving failed: ', error);
            });
        });
    }
}