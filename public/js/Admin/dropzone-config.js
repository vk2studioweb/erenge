/*
 * Execução enquanto pag. estiver carregando
 * 08/2018
 * Vk2 Studio Web
 */

$(document).ready(function () {
    if ($("#my-dropzone").length) {

        // Desabilita auto-discover para evitar dupla inicialização
        Dropzone.autoDiscover = false;

        var drop    = $("#preview-thumb").html();
        let formUrl = $("#my-dropzone").data("url") ?? null;
        let gallery = $("#my-dropzone").data("gallery") ?? null;

        if (formUrl !== null) {

            if (gallery) {
                let myDropzone = new Dropzone("#my-dropzone", {
                    url: formUrl,
                    chunking: true,
                    method: "POST",
                    maxFilesize: 210000000,
                    chunkSize: 2000000,
                    timeout: 0,
                    sending: function(file, xhr, formData) {
                        xhr.setRequestHeader('X-File-Name', encodeURIComponent(file.name));
                    },
                    success: (file, response) => {
                        if (file.previewElement) {
                            file.previewElement.classList.add("dz-success");
                        }
                        $("#main-list-files").append(`
                            <li data-select="false">
                                <img src="${response.data.imgUrl}"/>
                                <div class="menu-image" data-id="${response.data.idUpload}"
                                    data-link="${response.data.imgUrl}" data-active="true">
                                    <span class="item-menu-image information-image ui-admin-information-circle">Informações</span>
                                    <span class="item-menu-image new-image ui-admin-visible-opened-eye-interface-option">Abrir em Aba</span>
                                    <span class="item-menu-image link-image ui-admin-link">Gerar Link</span>
                                    <span class="item-menu-image dowload-image ui-admin-download-interface-sign">Fazer Dowload</span>
                                    <span class="item-menu-image delete-image ui-admin-recycle-bin-outline">Deletar</span>
                                </div>
                            </li>
                        `);
                        setTimeout(() => {
                            $(file.previewElement).fadeOut();
                        }, 2000);
                    },
                    queuecomplete: function(file) {
                        if (file.status === 'success') {
                            location.reload();
                        }
                    },
                });

            } else {
                let myDropzone = new Dropzone("#my-dropzone", {
                    url: formUrl,
                    chunking: true,
                    method: "POST",
                    maxFilesize: 400000000,
                    chunkSize: 2000000,
                    parallelChunkUploads: false,
                    previewTemplate: drop,
                    addRemoveLinks: false,
                    dictRemoveFile: "Remove file",
                    dictFileTooBig: "File is too large",
                    timeout: 0,
                    sending: function(file, xhr, formData) {
                        xhr.setRequestHeader('X-File-Name', encodeURIComponent(file.name));
                    },
                    success: (file, response) => {
                        if (file.previewElement) {
                            file.previewElement.classList.add("dz-success");
                        }
                        setTimeout(() => {
                            $(file.previewElement).fadeOut();
                        }, 2000);
                    },
                    queuecomplete: function(file) {
                        if (file.status === 'success') {
                            location.reload();
                        }
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