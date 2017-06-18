var PictureCrop = {

    settings: {
        formId: "editProfilePictureForm",
        currentForm: null,
        userId: null,
        file: null,
        rotate: null,
        imageCoordinates: null,
        minWidth: 300,
        minHeight: 300,
        //maxWidth: 500,
        maxHeight: 1700
    },
    init: function () {
        //console.lo
        this.bindUIActions();
    },


    imageCrop: function () {

        var $image = jQuery(".image-crop > img");

        $image.on({
            'build.cropper': function (e) {
                //console.log(e.type);
            },
            'built.cropper': function (e) {
                //console.log(e.type);
            },
            'cropstart.cropper': function (e) {
                //console.log(e.type, e.action);
            },
            'cropmove.cropper': function (e) {
                //console.log(e.type, e.action);
            },
            'cropend.cropper': function (e) {
                //console.log(e.type, e.action);
            },
            'crop.cropper': function (e) {
                //console.log(e.rotate, e.x, e.y, e.width, e.height);
                PictureCrop.settings.imageCoordinates = [e.x, e.y, e.width, e.height];
                PictureCrop.settings.rotate = e.rotate;
            },
            'zoom.cropper': function (e) {
                console.log(e.ratio);
                PictureCrop.settings.zoom = e.ratio;
            }
        }).cropper({
            fillColor: '#FFFFFF',
            highlight: true,
            // responsive: false,
            resizable: true,
            zoomable: true,
            rotatable: true,
            multiple: true,
            preview: ".img-preview",
            minContainerWidth: 500,
            minContainerHeight: 600,
            //autoCropArea: 1,

            done: function (data) {
                // Output the result data for cropping image.
            },
            built: function () {
                var canvasData = $image.cropper('getCanvasData', {fillColor: '#FFFFFF'});
                var cropBoxData = $image.cropper('getCropBoxData', {fillColor: '#FFFFFF'});
                var imageData = $image.cropper('getImageData', {fillColor: '#FFFFFF'});
            },
            crop: function (e) {
                //console.log(e.rotate, e.x, e.y, e.width, e.height);
                //console.log(e);
                PictureCrop.settings.imageCoordinates = [e.x, e.y, e.width, e.height];
                PictureCrop.settings.rotate = e.rotate;
            }
        });

        var $inputImage = $("#inputImage");

        if (window.FileReader) {
            $inputImage.change(function () {
                var fileReader = new FileReader(),
                    files = this.files,
                    file;

                if (!files.length) {
                    return;
                }

                file = files[0];
                PictureCrop.settings.file = file;

                if (/^image\/\w+$/.test(file.type)) {
                    fileReader.readAsDataURL(file);
                    fileReader.onload = function () {
                        $inputImage.val("");

                        $image.cropper("reset", true).cropper("replace", this.result);
                    };
                } else {
                    showMessage("Please choose an image file.");
                }
            });
        } else {
            $inputImage.addClass("hide");
        }

        $("#zoomIn").click(function () {
            $image.cropper("zoom", 0.1);
        });

        $("#zoomOut").click(function () {
            $image.cropper("zoom", -0.1);
        });

        $("#rotateLeft").click(function () {
            $image.cropper("rotate", 3);
        });

        $("#rotateRight").click(function () {
            $image.cropper("rotate", -3);
        });

        $("#setDrag").click(function () {
            $image.cropper("setDragMode", "crop");
        });
    },

    /*
     * --------------------------------
     * UPLOAD HANDLERS
     * --------------------------------
     */
    bindUIActions: function () {
        jQuery("#resetCrop").unbind().click(this.resetImage);
        jQuery("#removeImage").unbind().click(this.removeProfilePicture);

        PictureCrop.imageCrop();
    },

    addProfilePictureSuccess: function (response) {
        jQuery(".edit-profile-picture").cropper('destroy');
        jQuery('#editProfilePictureModal').modal('hide');
        MainOE.displayGeneralSuccess("Photo updated successfully!");
        PictureCrop.loadProfilePicture();
    },

    loadProfilePicture: function () {
        MainOE.displayAjaxLoaderStep++;
        MainOE.doAjaxGet(OE.urls.loadProfilePicture + '?id=' + PictureCrop.getUserId(),
            PictureCrop.loadProfilePictureSuccess);
    },

    loadProfilePictureSuccess: function (data) {
        var newImage = $(data).attr('src', $(data).attr('src') + '?' + Math.random().toString());
        jQuery(".edit-profile-picture").replaceWith(newImage.prop('outerHTML'));
        jQuery("#image").replaceWith(newImage.prop('outerHTML'));
        PictureCrop.bindUIActions();
        PictureCrop.imageCrop();
    },



    resetImage: function (event) {
        event.preventDefault();
        $(".image-crop > img").cropper("reset", true);
    },

    removeProfilePicture: function (event) {
        event.preventDefault();
        jQuery(".edit-profile-picture").cropper('destroy');
    }
};

