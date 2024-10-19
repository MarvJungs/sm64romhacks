import EditorJS from "@editorjs/editorjs";
import Header from '@editorjs/header';
import List from "@editorjs/list";
import Embed from "@editorjs/embed";

document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('createCheat');
    if (!form) return;

    const descriptionEditor = new EditorJS({
        holder: "editor-description",
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
            }
        }
    });

    const cheatcodeEditor = new EditorJS({
        holder: "editor-cheat"
    });

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        Promise.all([
            descriptionEditor.save().then((outputData) => {
                document.getElementById('description').value = JSON.stringify(outputData.blocks);
            }),
            cheatcodeEditor.save().then((outputData) => {
                document.getElementById('code').value = JSON.stringify(outputData.blocks);
            })
        ])
            .then(() => {
                form.submit();
            })
            .catch((error) => {
                console.error('Saving failed: ', error)
            });
    });
});