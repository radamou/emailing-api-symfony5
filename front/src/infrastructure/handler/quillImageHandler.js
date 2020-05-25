import {getUrl} from "../../config";

export const configureQuill = quill => {
    const imageHandler = () => {
        const input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.click();

        input.onchange = () => {
            const file = input.files[0];

            // file type is only image.
            if (/^image\//.test(file.type)) {
                saveToServer(file, quill);
            } else {
                alert('Seules les images peuvent être insérées.');
            }
        };
    };

    function saveToServer(file, quill) {
        const fd = new FormData();
        fd.append('image', file);

        const token = localStorage.getItem('token');
        const xhr = new XMLHttpRequest();
        xhr.open('POST', `${getUrl().secureUrl}/api/upload-image`, true);
        xhr.setRequestHeader('Authorization', `Bearer ${token}`);

        xhr.onload = () => {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                const {success} = response;

                if(false === success) {
                    if('MaxSize' === response.errorType) {
                        alert('La taill du fichier est trop grosse');
                    }

                    if('badFIleFormat' === response.errorType) {
                        alert('Seules les images sont acceptées (png, jpeg, gif, icon)');
                    }
                }

                if(true === success) {
                    const range = quill.getSelection();
                    quill.insertEmbed(range.index, 'image', response.url);
                }

            }
        };

        xhr.send(fd);
    }

    quill.getModule('toolbar').addHandler('image', imageHandler);
};


