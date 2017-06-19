var App = {
    table: null,
    init: function () {


        toastr.options = {
            "closeButton": true,
            "debug": false,
            "progressBar": false,
            "preventDuplicates": true,
            "onclick": null,
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn"
        };
        App.initDatatable();
    },

    initDatatable: function () {
        App.table = $('#products').DataTable({
            ajax: {
                url: 'get-products'
            },
            columnDefs: [{
                targets: 2,
                orderable: false
            }]
        });
    },

    createProduct: function () {
        $.ajax({
            type: "POST",
            url: 'add-product',
            data: $('#addProductForm').serialize(),
            success: App.createProductSuccess,
            error: App.generalError
        });

    },

    createProductSuccess: function () {
        jQuery('#addProductModal').modal('hide');
        App.table.ajax.reload();
        $('#name').val("");
        toastr.success('Product added');
    },

    generalError: function () {
        toastr.error('There was an error. Try again');
    },

    deleteProduct: function (id) {
        $.ajax({
            type: "GET",
            url: 'delete-product',
            data: {
                id: id
            },
            success: App.deleteProductSuccess,
            error: App.generalError
        });
    },

    deleteProductSuccess: function () {
        App.table.ajax.reload();
        toastr.success('Product deleted');
    },

    editProductModal: function (id) {
        $.ajax({
            type: "GET",
            url: 'get-edit-product-modal',
            data: {
                id: id
            },
            success: App.editProductModalSuccess,
            error: App.generalError
        });
    },

    editProductModalSuccess: function (data) {
        $('#editProductModal').replaceWith(data);
        PictureCrop.init();
        $('#editProductModal').modal('show');
    },

    editProduct: function (id) {
        $.ajax({
            type: "POST",
            url: 'edit-product',
            data: $('#editProductForm').serialize(),
            success: App.editProductSuccess,
            error: App.generalError
        });
    },

    editProductSuccess: function () {
        jQuery('#editProductModal').modal('hide');
        App.table.ajax.reload();
        toastr.success('Product edited');
    },

    getImageDataSuccess: function (response) {
        console.log(response);
        if (response.target != 'nutrition') {
            $("[name='" + response.target + "']").val(response.text);
        }
    }


};
$(document).ready(function () {
    App.init();

    $('#addProduct').click(function (e) {

        if ($('#name').val() != "") {
            App.createProduct();
        } else {
            e.stopPropagation();
        }
    });

    $("#addProductForm").submit(function (e) {
        return false;
    });

    $("#editProductForm").submit(function (e) {
        return false;
    });

});


$(document).on('click', '.data-table-actions.delete', function () {
    var id = $(this).attr('data-id');
    if (confirm('Are you sure you want to delete the item?')) {
        App.deleteProduct(id);
    }
});

$(document).on('click', '.data-table-actions.edit', function () {
    var id = $(this).attr('data-id');
    App.editProductModal(id);
});

$(document).on('click', '.get-data-picture', function (e) {
    e.preventDefault();
    e.stopPropagation();

    var formData = new FormData();

    console.log(PictureCrop.settings.file);
    if (PictureCrop.settings.file) {
        formData.append('file', PictureCrop.settings.file);
        //PictureCrop.settings.file = "";
    }
    formData.append('coordinates[x]', PictureCrop.settings.imageCoordinates[0]);
    formData.append('coordinates[y]', PictureCrop.settings.imageCoordinates[1]);
    formData.append('coordinates[w]', PictureCrop.settings.imageCoordinates[2]);
    formData.append('coordinates[h]', PictureCrop.settings.imageCoordinates[3]);
    formData.append('rotate', PictureCrop.settings.rotate);
    formData.append('_token', $('#token').val());
    formData.append('target', $(this).attr('data-fortarget'));
    formData.append('id', $('#id').val());

    jQuery.ajax({
        url: 'get-image-data',
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: App.getImageDataSuccess,
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            toastr.error("Error: error on sending the image. Make sure you select an image and try again");
        }
    });

});

$(document).on('click', '.tab-content h4', function (e) {
    e.preventDefault();

    if (!$(this).hasClass('get-data-picture')) {
        var arrow = $(this).find('.arrow');
        var getDta = $(this).find('.get-data-picture');


        if (arrow.hasClass('glyphicon-chevron-right')) {
            arrow.removeClass('glyphicon-chevron-right');
            arrow.addClass('glyphicon-chevron-down');
            getDta.show();
        } else {
            arrow.removeClass('glyphicon-chevron-down');
            arrow.addClass('glyphicon-chevron-right');
            getDta.hide();

        }
    }


});

$(document).on('click', '#editProduct', function () {
    App.editProduct();
});

