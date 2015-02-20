jQuery(document).ready(function ($) {
    var AAIVU_Upload = {
        init:function () {
            window.aaivuUploadCount = typeof(window.aaivuUploadCount) == 'undefined' ? 0 : window.aaivuUploadCount;
            this.maxFiles = parseInt(aaivu_upload.number);

            $('#aaivu-upload-imagelist').on('click', 'a.action-delete', this.removeUploads);

            this.attach();
            this.hideUploader();
        },
        attach:function () {
            // wordpress plupload if not found
            if (typeof(plupload) === 'undefined') {
                return;
            }

            if (aaivu_upload.upload_enabled !== '1') {
                return
            }

            var uploader = new plupload.Uploader(aaivu_upload.plupload);

            $('#aaivu-uploader').click(function (e) {
                uploader.start();
                // To prevent default behavior of a tag
                e.preventDefault();
            });

            //initilize  wp plupload
            uploader.init();

            uploader.bind('FilesAdded', function (up, files) {
                $.each(files, function (i, file) {
                    $('#aaivu-upload-imagelist').append(
                        '<div id="' + file.id + '">' +
                            file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
                            '</div>');
                });

                up.refresh(); // Reposition Flash/Silverlight
                uploader.start();
            });

            uploader.bind('UploadProgress', function (up, file) {
                $('#' + file.id + " b").html(file.percent + "%");
            });

            // On erro occur
            uploader.bind('Error', function (up, err) {
                $('#aaivu-upload-imagelist').append("<div>Error: " + err.code +
                    ", Message: " + err.message +
                    (err.file ? ", File: " + err.file.name : "") +
                    "</div>"
                );

                up.refresh(); // Reposition Flash/Silverlight
            });

            uploader.bind('FileUploaded', function (up, file, response) {
                var result = $.parseJSON(response.response);
                $('#' + file.id).remove();
                if (result.success) {
                    window.aaivuUploadCount += 1;
                    $('#aaivu-upload-imagelist ul').append(result.html);

                    AAIVU_Upload.hideUploader();
                }
            });


        },

        hideUploader:function () {

            if (AAIVU_Upload.maxFiles !== 0 && window.aaivuUploadCount >= AAIVU_Upload.maxFiles) {
                $('#aaivu-uploader').hide();
            }
        },

        removeUploads:function (e) {
            e.preventDefault();

            if (confirm(aaivu_upload.confirmMsg)) {

                var el = $(this),
                    data = {
                        'attach_id':el.data('upload_id'),
                        'nonce':aaivu_upload.remove,
                        'action':'aaivu_delete'
                    };

                $.post(aaivu_upload.ajaxurl, data, function () {
                    el.parent().remove();

                    window.aaivuUploadCount -= 1;
                    if (AAIVU_Upload.maxFiles !== 0 && window.aaivuUploadCount < AAIVU_Upload.maxFiles) {
                        $('#aaivu-uploader').show();
                    }
                });
            }
        }

    };

    AAIVU_Upload.init();
});

