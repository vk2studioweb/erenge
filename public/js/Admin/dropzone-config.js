/*
 * Execução enquanto pag. estiver carregando
 * 08/2018
 * Vk2 Studio Web
 */

$(document).ready(function () {
    if ($("#my-dropzone").length) {
        var total_photos_counter = 0;
        var name = "";
        var drop = $("#preview-thumb").html();
        let formUrl = $("#my-dropzone").data("url") ?? null;
        let gallery = $("#my-dropzone").data("gallery") ?? null;
        Dropzone.options.fileDropZone = false;

        if (formUrl !== null) {
            
            if (gallery) {
                let myDropzone = new Dropzone("#my-dropzone", {
                    url: formUrl,
                    chunking: true,
                    method: "POST",
                    maxFilesize: 210000000,
                    chunkSize: 16000000,
                    // Se true, os chunks individuais são enviados simultaneamente
                    parallelChunkUploads: false,
                    previewTemplate: drop,
                    addRemoveLinks: false,
                    dictRemoveFile: "Remove file",
                    dictFileTooBig: "Image is larger than 200MB",
                    timeout: 0,
                    success: (file, response) => {
                        if (file.previewElement) {
                            file.previewElement.classList.add("dz-success");
                        }
                        let responseData = response.data;
                        $("#main-list-files").append(`
              <li data-select="false">
                <img src="${response.data.imgUrl}"/>

                <div class="menu-image" data-id="${response.data.idUpload}"
                    data-link="${response.data.imgUrl}" data-active="true">
                    <span
                        class="item-menu-image information-image ui-admin-information-circle">Informações</span>
                    <span class="item-menu-image new-image ui-admin-visible-opened-eye-interface-option">Abrir
                        em
                        Aba</span>
                    <span class="item-menu-image link-image ui-admin-link">Gerar Link</span>
                    <span class="item-menu-image dowload-image ui-admin-download-interface-sign">Fazer
                        Dowload</span>
                    <span class="item-menu-image delete-image ui-admin-recycle-bin-outline">Deletar</span>
                </div>
                </li>
              `);

                        setTimeout(() => {
                            $(file.previewElement).fadeOut();
                        }, 2000);
                    },
                    queuecomplete: function queuecomplete(file) {
                        return false;
                    },
                });
            } else {
                console.log(formUrl);
                let myDropzone = new Dropzone("#my-dropzone", {
                    url: formUrl,
                    chunking: true,
                    method: "POST",
                    maxFilesize: 400000000,
                    chunkSize: 2000000,
                    // Se true, os chunks individuais são enviados simultaneamente
                    parallelChunkUploads: false,
                    previewTemplate: drop,
                    addRemoveLinks: false,
                    dictRemoveFile: "Remove file",
                    dictFileTooBig: "Image is larger than 200MB",
                    timeout: 0,
                    success: (file, response) => {
                        if (file.previewElement) {
                            file.previewElement.classList.add("dz-success");
                        }
                        let responseData = response.data;
                        setTimeout(() => {
                            $(file.previewElement).fadeOut();
                        }, 2000);
                    },
                    queuecomplete: function queuecomplete(file) {
                        return false;
                    },
                });
            }
        } else {
            let myDropzone = new Dropzone(".dropzone", {
                uploadMultiple: false,
                parallelUploads: 2,
                maxFilesize: 21000000,
                previewTemplate: drop,
                addRemoveLinks: false,
                dictRemoveFile: "Remove file",
                dictFileTooBig: "Image is larger than 20MB",
                timeout: 0,
            });
        }
    }
});
