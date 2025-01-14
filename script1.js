$(document).ready(function() {
    var table = $('#showTable').DataTable({
        dropdownParent: $("#editModal"),
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dom: 'lBfrtip',
        buttons: [
        "copy",
        "csv",
        "excel", {
            extend: 'print',
            customize: function(win) {
                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table')
                    .before('<h1 style="text-align:center;">REPORT ON THE OFFICE EQUIPMENT</h1>'+
                             '<p style="text-align:center;">___________________________________</p>'+
                             '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                             '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                             '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                $(win.document.body).find('table')
                    .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                        '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                        '</tr>' +
                        '</table>');
            },
            orientation: 'landscape',
       
               exportOptions: {
             columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
            }

       
             }
    ],
        ajax: {
            url: "getdata.php",
            type: "post",
            data: {list: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        lengthMenu: [
            [10, 25, 50, 100000000],
            [10, 25, 50, 'ALL']
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        },
    });

$('#showTable').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    $.ajax({
        url: 'getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
         success: function(response) {
                if (response.trim() !== "") {
                    var data = JSON.parse(response);
                    
                    // Populate the modal with the data
                    
                    var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                    $("#asset").append(assetOption).trigger("change");
                    var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                    $("#subasset").append(subOption).trigger("change");
                    $('#modal-input1').val(data[0].description);
                    $('#modal-input2').val(data[0].property_no);
                    $('#modal-input3').val(data[0].unit_meas);
                    $('#modal-input4').val(data[0].unit_val);
                    $('#modal-input5').val(data[0].qty_property_card);
                    $('#modal-input6').val(data[0].qty_physical_count);
                    $('#modal-input7').val(data[0].shortage_qty);
                    $('#modal-input8').val(data[0].shortage_value);
                    var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                    $('select.edit_personnel').append(officerOption).trigger('change');
                    $('#modal-input10').val(data[0].remarks);
    
    
                   
                    $('#editmodalbuild1').modal('show');
    
                    $('#saveChanges').off('click').on('click', function() {
                        $.ajax({
                            url: 'function.php',
                            type: 'POST',
                            data: {
                                updatebuild1: true,
                                id: id,
                                asset: $('#asset').val(),
                                subasset: $('#subasset').val(),
                                description: $('#modal-input1').val(),
                                property_no: $('#modal-input2').val(),
                                unit_meas: $('#modal-input3').val(),
                                unit_val: $('#modal-input4').val().replace('₱', ''), 
                                qty_property_card: $('#modal-input5').val(),
                                qty_physical_count: $('#modal-input6').val(),
                                shortage_qty: $('#modal-input7').val(),
                                shortage_value: $('#modal-input8').val(),
                                account_officer: $('select.edit_personnel').val(),
                                remarks: $('#modal-input10').val(),
                            },
                            success: function(response) {
                                if (response.trim() === "Updated Successfully") {
                                    $('#editmodalbuild1').modal('hide');
                                    Swal.fire(
                                        'Updated!',
                                        'File has been updated successfully.',
                                        'success'
                                    );
                                    table.ajax.reload();
                                } else {
                                    Swal.fire(
                                        'Failed!',
                                        'Failed to update file. Select Personnel',
                                        'error'
                                    );
                                }
                            },
                        });
                    });
                }
            },
        });
    });
    

    $('#showTable').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'function.php',
                    type: 'POST',
                    data: {
                        delete: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });

});

//data1.php
$(document).ready(function() {
    var table = $('#showTable1').DataTable({
        dropdownParent: $("#editModal"),
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dom: 'lBfrtip',
        buttons: [
        "copy",
        "csv",
        "excel", {
            extend: 'print',
            customize: function(win) {
                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table')
                    .before('<h1 style="text-align:center;">Report on Agricultural & Forestry Equipment</h1>'+
                             '<p style="text-align:center;">___________________________________</p>'+
                             '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                             '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                             '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                $(win.document.body).find('table')
                    .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                        '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                        '</tr>' +
                        '</table>');
            },
            orientation: 'landscape',
       
               exportOptions: {
             columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
            }

       
             }
    ],
        ajax: {
            url: "getdata.php",
            type: "post",
            data: {list1: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
        
    });


$('#showTable1').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: 'getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                
                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                $("#asset").append(assetOption).trigger("change");
                var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                $("#subasset").append(subOption).trigger("change");
                $('#modal-input1').val(data[0].description);
                $('#modal-input2').val(data[0].property_no);
                $('#modal-input3').val(data[0].unit_meas);
                $('#modal-input4').val(data[0].unit_val);
                $('#modal-input5').val(data[0].qty_property_card);
                $('#modal-input6').val(data[0].qty_physical_count);
                $('#modal-input7').val(data[0].shortage_qty);
                $('#modal-input8').val(data[0].shortage_value);
                var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                $('select.edit_personnel').append(officerOption).trigger('change');
                $('#modal-input10').val(data[0].remarks);



               
                $('#editmodalbuild1').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: 'function.php',
                        type: 'POST',
                        data: {
                            updatebuild1: true,
                            id: id,
                            asset: $('#asset').val(),
                                subasset: $('#subasset').val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editmodalbuild1').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file. Select Personnel',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});



    $('#showTable1').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'function.php',
                    type: 'POST',
                    data: {
                        delete1: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });

});

//data2.php
$(document).ready(function() {
    var table = $('#showTable2').DataTable({
        dropdownParent: $("#editModal"),
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dom: 'lBfrtip',
        buttons: [
        "copy",
        "csv",
        "excel", {
            extend: 'print',
            customize: function(win) {
                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table')
                    .before('<h1 style="text-align:center;">REPORT ON ICT EQUIPMENT</h1>'+
                             '<p style="text-align:center;">___________________________________</p>'+
                             '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                             '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                             '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                $(win.document.body).find('table')
                    .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                        '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                        '</tr>' +
                        '</table>');
            },
            orientation: 'landscape',
       
               exportOptions: {
             columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
            }

       
             }
    ],
        ajax: {
            url: "getdata.php",
            type: "post",
            data: {list2: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#showTable2').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: 'getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);

                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                $("#asset").append(assetOption).trigger("change");
                var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                $("#subasset").append(subOption).trigger("change");
                $('#modal-input1').val(data[0].description);
                $('#modal-input2').val(data[0].property_no);
                $('#modal-input3').val(data[0].unit_meas);
                $('#modal-input4').val(data[0].unit_val);
                $('#modal-input5').val(data[0].qty_property_card);
                $('#modal-input6').val(data[0].qty_physical_count);
                $('#modal-input7').val(data[0].shortage_qty);
                $('#modal-input8').val(data[0].shortage_value);
                var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                $('select.edit_personnel').append(officerOption).trigger('change');
                $('#modal-input10').val(data[0].remarks);

               
                $('#editmodalbuild1').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: 'function.php',
                        type: 'POST',
                        data: {
                            updatebuild1: true,
                            id: id,
                            asset: $('#asset').val(),
                                subasset: $('#subasset').val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editmodalbuild1').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file. Select Personnel',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});


    $('#showTable2').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'function.php',
                    type: 'POST',
                    data: {
                        delete2: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });

});

//data3.php
$(document).ready(function() {
    var table = $('#showTable3').DataTable({
        dropdownParent: $("#editModal"),
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dom: 'lBfrtip',
        buttons: [
        "copy",
        "csv",
        "excel", {
            extend: 'print',
            customize: function(win) {
                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table')
                    .before('<h1 style="text-align:center;">Report on Machinery Equipment</h1>'+
                             '<p style="text-align:center;">___________________________________</p>'+
                             '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                             '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                             '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                $(win.document.body).find('table')
                    .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                        '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                        '</tr>' +
                        '</table>');
            },
            orientation: 'landscape',
       
               exportOptions: {
             columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
            }

       
             }
    ],
        ajax: {
            url: "getdata.php",
            type: "post",
            data: {list3: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#showTable3').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: 'getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                

                 var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                    $("#asset").append(assetOption).trigger("change");
                    var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                    $("#subasset").append(subOption).trigger("change");
                    $('#modal-input1').val(data[0].description);
                    $('#modal-input2').val(data[0].property_no);
                    $('#modal-input3').val(data[0].unit_meas);
                    $('#modal-input4').val(data[0].unit_val);
                    $('#modal-input5').val(data[0].qty_property_card);
                    $('#modal-input6').val(data[0].qty_physical_count);
                    $('#modal-input7').val(data[0].shortage_qty);
                    $('#modal-input8').val(data[0].shortage_value);
                    var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                    $('select.edit_personnel').append(officerOption).trigger('change');
                    $('#modal-input10').val(data[0].remarks);
    


               
                $('#editmodalbuild1').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: 'function.php',
                        type: 'POST',
                        data: {
                            updatebuild1: true,
                            id: id,
                            asset: $('#asset').val(),
                                subasset: $('#subasset').val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editmodalbuild1').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file. Select Personnel',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});


    $('#showTable3').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'function.php',
                    type: 'POST',
                    data: {
                        delete3: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });

});

//data4.php
$(document).ready(function() {
    var table = $('#showTable4').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dom: 'lBfrtip',
        buttons: [
        "copy",
        "csv",
        "excel", {
            extend: 'print',
            customize: function(win) {
                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table')
                    .before('<h1 style="text-align:center;">Report on School Sports Equipment</h1>'+
                             '<p style="text-align:center;">___________________________________</p>'+
                             '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                             '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                             '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                $(win.document.body).find('table')
                    .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                        '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                        '</tr>' +
                        '</table>');
            },
            orientation: 'landscape',
       
               exportOptions: {
             columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
            }

       
             }
    ],
        ajax: {
            url: "getdata.php",
            type: "post",
            data: {list4: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#showTable4').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: 'getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                
                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                $("#asset").append(assetOption).trigger("change");
                var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                $("#subasset").append(subOption).trigger("change");
                $('#modal-input1').val(data[0].description);
                $('#modal-input2').val(data[0].property_no);
                $('#modal-input3').val(data[0].unit_meas);
                $('#modal-input4').val(data[0].unit_val);
                $('#modal-input5').val(data[0].qty_property_card);
                $('#modal-input6').val(data[0].qty_physical_count);
                $('#modal-input7').val(data[0].shortage_qty);
                $('#modal-input8').val(data[0].shortage_value);
                var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                $('select.edit_personnel').append(officerOption).trigger('change');
                $('#modal-input10').val(data[0].remarks);



               
                $('#editmodalbuild1').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: 'function.php',
                        type: 'POST',
                        data: {
                            updatebuild1: true,
                            id: id,
                            asset: $('#asset').val(),
                                subasset: $('#subasset').val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editmodalbuild1').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file. Select Personnel',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});


    $('#showTable4').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'function.php',
                    type: 'POST',
                    data: {
                        delete4: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });

});

//data5.php
$(document).ready(function() {
    var table = $('#showTable5').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dom: 'lBfrtip',
        buttons: [
        "copy",
        "csv",
        "excel", {
            extend: 'print',
            customize: function(win) {
                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table')
                    .before('<h1 style="text-align:center;">Report on Technical Scientific Equipment</h1>'+
                             '<p style="text-align:center;">___________________________________</p>'+
                             '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                             '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                             '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                $(win.document.body).find('table')
                    .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                        '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                        '</tr>' +
                        '</table>');
            },
            orientation: 'landscape',
       
               exportOptions: {
             columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
            }

       
             }
    ],
        ajax: {
            url: "getdata.php",
            type: "post",
            data: {list5: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#showTable5').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: 'getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                
                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                $("#asset").append(assetOption).trigger("change");
                var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                $("#subasset").append(subOption).trigger("change");
                $('#modal-input1').val(data[0].description);
                $('#modal-input2').val(data[0].property_no);
                $('#modal-input3').val(data[0].unit_meas);
                $('#modal-input4').val(data[0].unit_val);
                $('#modal-input5').val(data[0].qty_property_card);
                $('#modal-input6').val(data[0].qty_physical_count);
                $('#modal-input7').val(data[0].shortage_qty);
                $('#modal-input8').val(data[0].shortage_value);
                var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                $('select.edit_personnel').append(officerOption).trigger('change');
                $('#modal-input10').val(data[0].remarks);



               
                $('#editmodalbuild1').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: 'function.php',
                        type: 'POST',
                        data: {
                            updatebuild1: true,
                            id: id,
                            asset: $('#asset').val(),
                                subasset: $('#subasset').val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editmodalbuild1').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file. Select Personnel',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});



    $('#showTable5').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'function.php',
                    type: 'POST',
                    data: {
                        delete5: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });

});

//land.php

$(document).ready(function() {
    $("button.saveland1").on("click", function(event) {
        event.preventDefault();
  
        var requiredFilled = true;
        $("#addland input, #addland select").each(function() {
            if ($(this).prop("required")) {
                if ($(this).is('select') && $(this).val() === null) {
                    requiredFilled = false;
                    $(this).addClass("is-invalid");
                } else if ($(this).val() === "") {
                    requiredFilled = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            }
        });
  
        if (requiredFilled) {
            $.ajax({
                url: "save_function.php",
                type: "POST",
                data: $("#addland").serialize() + "&save_land=true",
                success: function(response) {
                    try {
                        response = JSON.parse(response);
                        if (response.success === 1) { 
                            Swal.fire({
                                icon: "success",
                                title: "Asset Successfully Saved!",
                                showConfirmButton: true
                            }).then(() => {
                                $("#addland")[0].reset();
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: response.error || "An unknown error occurred."
                            });
                        }
                    } catch (e) {
                        Swal.fire({
                            title: "Error!",
                            text: "Failed to parse JSON response: " + e,
                            icon: "error"
                        });
                    }
                },
            });
        }
    });
});


$(document).ready(function() {
    $("button.saveland").on("click", function(event) {
        event.preventDefault();
  
        var requiredFilled = true;
        $("#addland input, #addland select").each(function() {
            if ($(this).prop("required")) {
                if ($(this).is('select') && $(this).val() === null) {
                    requiredFilled = false;
                    $(this).addClass("is-invalid");
                } else if ($(this).val() === "") {
                    requiredFilled = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            }
        });
  
        if (requiredFilled) {
            $.ajax({
                url: "save_function.php",
                type: "POST",
                data: $("#addland").serialize() + "&save_land=true",
                success: function(response) {
                    try {
                        response = JSON.parse(response);
                        if (response.success === 1) { 
                            Swal.fire({
                                icon: "success",
                                title: "Asset Successfully Saved!",
                                showConfirmButton: true
                            }).then(() => {
                            location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: response.error || "An unknown error occurred."
                            });
                        }
                    } catch (e) {
                        Swal.fire({
                            title: "Error!",
                            text: "Failed to parse JSON response: " + e,
                            icon: "error"
                        });
                    }
                },
            });
        }
    });
});

$(document).ready(function() {
    var table = $('#showLand').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dom: 'lBfrtip',
        buttons: [
        "copy",
        "csv",
        "excel", {
            extend: 'print',
            customize: function(win) {
                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table')
                    .before('<h1 style="text-align:center;">Report on Land Properties</h1>'+
                             '<p style="text-align:center;">___________________________________</p>'+
                             '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                             '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                             '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                $(win.document.body).find('table')
                    .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                        '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                        '</tr>' +
                        '</table>');
            },
            orientation: 'landscape',
       
               exportOptions: {
             columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
            }

       
             }
    ],
        ajax: {
            url: "getdata.php",
            type: "post",
            data: {land: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "land_area"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "titled"},
            {"data": "remarks"},
            {"data": "school_office"},
            {"data": "date_acquired"},
            {"data": "date"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1   delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#showLand').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: 'getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                Swal.fire({
                    title: 'Edit Data',
                    html: '<input id="swal-input1" class="swal2-input" value="' + data[0].description + '">'+
                    '<input id="swal-input2" class="swal2-input" value="' + data[0].property_no + '">' +
                    '<input id="swal-input3" class="swal2-input" value="' + data[0].land_area + '">' +
                    '<input id="swal-input4" class="swal2-input" value="₱' + data[0].unit_val + '">' +
                    '<input id="swal-input5" class="swal2-input" value="' + data[0].titled +'">'+
                    '<input id="swal-input6" class="swal2-input" value="' + data[0].remarks +'">'+
                    '<input id="swal-input7" class="swal2-input" value="' + data[0].school_office +'">'+
                    '<input id="swal-input8" class="swal2-input" value="' + data[0].date +'">',
                    focusConfirm: false,
                    confirmButtonText: 'Update',
                    preConfirm: () => {
                        const value1 = document.getElementById('swal-input1').value;
                        const value2 = document.getElementById('swal-input2').value;
                        const value3 = document.getElementById('swal-input3').value;
                        const value4 = document.getElementById('swal-input4').value.replace('₱', ''); 
                        const value5 = document.getElementById('swal-input5').value;
                        const value6 = document.getElementById('swal-input6').value;
                        const value7 = document.getElementById('swal-input7').value;
                        const value8 = document.getElementById('swal-input8').value;

                        return [value1,value2,value3,value4,value5,value6,value7,value8];
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        const [value1, value2, value3, value4, value5, value6, value7, value8] = result.value;
                        $.ajax({
                            url: 'function.php',
                            type: 'POST',
                            data: {
                                updateland: true,
                                id: id,
                                description: value1,
                                property_no: value2,
                                land_area: value3,
                                unit_val: value4,
                                titled: value5,
                                remarks: value6,
                                school_office: value7,
                                date: value8,
                              
                            },
                            success: function(response) {
                                if (response.trim() === "Updated Successfully") {
                                    Swal.fire(
                                        'Updated!',
                                        'File has been updated successfully.',
                                        'success'
                                    );
                                    table.ajax.reload();
                                } else {
                                    Swal.fire(
                                        'Failed!',
                                        'Failed to update file.',
                                        'error'
                                    );
                                }
                            },
                           
                        });
                    }
                });
            } 
        },

    });
})


    $('#showLand').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'function.php',
                    type: 'POST',
                    data: {
                        deleteland: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });

});


//build1.php
$(document).ready(function() {
    $("button.saveoffice").on("click", function(event) {
        event.preventDefault();
  
        var requiredFilled = true;
        $("#saveoffice input, #saveoffice select").each(function() {
            if ($(this).prop("required")) {
                if ($(this).is('select') && $(this).val() === null) {
                    requiredFilled = false;
                    $(this).addClass("is-invalid");
                } else if ($(this).val() === "") {
                    requiredFilled = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            }
        });
  
        if (requiredFilled) {
            $.ajax({
                url: "save_function.php",
                type: "POST",
                data: $("#saveoffice").serialize() + "&save_office=true",
                success: function(response) {
                    try {
                        response = JSON.parse(response);
                        if (response.success === 1) {
                            Swal.fire({
                                icon: "success",
                                title: "Asset Successfully Saved!",
                                showConfirmButton: true
                            }).then(() => {
                               location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: "Failed to Save Data"
                            });
                        }
                    } catch (e) {
                        Swal.fire({
                            title: "Error!",
                            text: "Failed to parse JSON response: " + e,
                            icon: "error"
                        });
                    }
                },
            });
        }else{
            toastr.error("Please fill up the required form!");
        }
    });
});

$(document).ready(function() {
    var table = $('#showBuild').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dom: 'lBfrtip',
        buttons: [
        "copy",
        "csv",
        "excel", {
            extend: 'print',
            customize: function(win) {
                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table')
                    .before('<h1 style="text-align:center;">Report on Office Building</h1>'+
                             '<p style="text-align:center;">___________________________________</p>'+
                             '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                             '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                             '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                $(win.document.body).find('table')
                    .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                        '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                        '</tr>' +
                        '</table>');
            },
            orientation: 'landscape',
       
               exportOptions: {
             columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
            }

       
             }
    ],
        ajax: {
            url: "getdata.php",
            type: "post",
            data: {build1: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });

    $('#showBuild').on('click', '.update-btn', function() {
        var id = $(this).data('update');
        console.log(id);    
        $.ajax({
            url: 'getdata.php',
            type: 'POST',
            data: {
                getdata: true,
                id: id
            },
            success: function(response) {
                if (response.trim() !== "") {
                    var data = JSON.parse(response);
                    
                    var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                    $("#asset").append(assetOption).trigger("change");
                    var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                    $("#subasset").append(subOption).trigger("change");
                    $('#modal-input1').val(data[0].description);
                    $('#modal-input2').val(data[0].property_no);
                    $('#modal-input3').val(data[0].unit_meas);
                    $('#modal-input4').val(data[0].unit_val);
                    $('#modal-input5').val(data[0].qty_property_card);
                    $('#modal-input6').val(data[0].qty_physical_count);
                    $('#modal-input7').val(data[0].shortage_qty);
                    $('#modal-input8').val(data[0].shortage_value);
                    var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                    $('select.edit_personnel').append(officerOption).trigger('change');
                    $('#modal-input10').val(data[0].remarks);
    
                   
                    $('#editmodalbuild1').modal('show');
    
                    $('#saveChanges').off('click').on('click', function() {
                        $.ajax({
                            url: 'function.php',
                            type: 'POST',
                            data: {
                                updatebuild1: true,
                                id: id,
                                asset: $('#asset').val(),
                                subasset: $('#subasset').val(),
                                description: $('#modal-input1').val(),
                                property_no: $('#modal-input2').val(),
                                unit_meas: $('#modal-input3').val(),
                                unit_val: $('#modal-input4').val().replace('₱', ''), 
                                qty_property_card: $('#modal-input5').val(),
                                qty_physical_count: $('#modal-input6').val(),
                                shortage_qty: $('#modal-input7').val(),
                                shortage_value: $('#modal-input8').val(),
                                account_officer: $('select.edit_personnel').val(),
                                remarks: $('#modal-input10').val(),
                            },
                            success: function(response) {
                                if (response.trim() === "Updated Successfully") {
                                    $('#editmodalbuild1').modal('hide');
                                    Swal.fire(
                                        'Updated!',
                                        'File has been updated successfully.',
                                        'success'
                                    );
                                    table.ajax.reload();
                                } else {
                                    Swal.fire(
                                        'Failed!',
                                        'Failed to update file. Select Personnel',
                                        'error'
                                    );
                                }
                            },
                        });
                    });
                }
            },
        });
    });
    


    $('#showBuild').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'function.php',
                    type: 'POST',
                    data: {
                        deletebuild1: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });

});




//build3.php
$(document).ready(function() {
    $("button.saveschool").on("click", function(event) {
        event.preventDefault();
  
        var requiredFilled = true;
        $("#saveschool input, #saveschool select").each(function() {
            if ($(this).prop("required")) {
                if ($(this).is('select') && $(this).val() === null) {
                    requiredFilled = false;
                    $(this).addClass("is-invalid");
                } else if ($(this).val() === "") {
                    requiredFilled = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            }
        });
  
        if (requiredFilled) {
            $.ajax({
                url: "save_function.php",
                type: "POST",
                data: $("#saveschool").serialize() + "&saveschool=true",
                success: function(response) {
                    try {
                        response = JSON.parse(response);
                        if (response.success === 1) { 
                            Swal.fire({
                                icon: "success",
                                title: "Asset Successfully Saved!",
                                showConfirmButton: true
                            }).then(() => {
                            location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: response.error || "An unknown error occurred."
                            });
                        }
                    } catch (e) {
                        Swal.fire({
                            title: "Error!",
                            text: "Failed to parse JSON response: " + e,
                            icon: "error"
                        });
                    }
                },
            });
        }else{
            toastr.error("Please fill up the required form!");
        }
    });
});

$(document).ready(function() {
    var table = $('#showBuild3').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dom: 'lBfrtip',
        buttons: [
        "copy",
        "csv",
        "excel", {
            extend: 'print',
            customize: function(win) {
                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table')
                    .before('<h1 style="text-align:center;">Report on Other Structure</h1>'+
                             '<p style="text-align:center;">___________________________________</p>'+
                             '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                             '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                             '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                $(win.document.body).find('table')
                    .after('<table style="margin-top:80px; width:100%; text-align:center;">' + 
                        '<tr>' +
                        '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                        '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                        '</tr>' +
                        '</table>');
            },
            orientation: 'landscape',
       
               exportOptions: {
             columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
            }

       
             }
    ],
        ajax: {
            url: "getdata.php",
            type: "post",
            data: {build3: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#showBuild3').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: 'getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                
                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                $("#asset").append(assetOption).trigger("change");
                var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                $("#subasset").append(subOption).trigger("change");
                $('#modal-input1').val(data[0].description);
                $('#modal-input2').val(data[0].property_no);
                $('#modal-input3').val(data[0].unit_meas);
                $('#modal-input4').val(data[0].unit_val);
                $('#modal-input5').val(data[0].qty_property_card);
                $('#modal-input6').val(data[0].qty_physical_count);
                $('#modal-input7').val(data[0].shortage_qty);
                $('#modal-input8').val(data[0].shortage_value);
                var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                $('select.edit_personnel').append(officerOption).trigger('change');
                $('#modal-input10').val(data[0].remarks);


               
                $('#editmodalbuild1').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: 'function.php',
                        type: 'POST',
                        data: {
                            updatebuild1: true,
                            id: id,
                            asset: $('#asset').val(),
                                subasset: $('#subasset').val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editmodalbuild1').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file. Select Personnel',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});


    $('#showBuild3').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'function.php',
                    type: 'POST',
                    data: {
                        deletebuild3: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });
});


//build2.php
$(document).ready(function() {
    $("button.saveothers").on("click", function(event) {
        event.preventDefault();
  
        var requiredFilled = true;
        $("#saveothers input, #saveothers select").each(function() {
            if ($(this).prop("required")) {
                if ($(this).is('select') && $(this).val() === null) {
                    requiredFilled = false;
                    $(this).addClass("is-invalid");
                } else if ($(this).val() === "") {
                    requiredFilled = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            }
        });
  
        if (requiredFilled) {
            $.ajax({
                url: "save_function.php",
                type: "POST",
                data: $("#saveothers").serialize() + "&saveothers=true",
                success: function(response) {
                    try {
                        response = JSON.parse(response);
                        if (response.success === 1) { 
                            Swal.fire({
                                icon: "success",
                                title: "Asset Successfully Saved!",
                                showConfirmButton: true
                            }).then(() => {
                            location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: response.error || "An unknown error occurred."
                            });
                        }
                    } catch (e) {
                        Swal.fire({
                            title: "Error!",
                            text: "Failed to parse JSON response: " + e,
                            icon: "error"
                        });
                    }
                },
            });
        }else{
            toastr.error("Please fill up the required form!");
        }
    });
});


$(document).ready(function() {
    var table = $('#showBuild2').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dom: 'lBfrtip',
        buttons: [
        "copy",
        "csv",
        "excel", {
            extend: 'print',
            customize: function(win) {
                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table')
                    .before('<h1 style="text-align:center;">Report on School Buildings</h1>'+
                             '<p style="text-align:center;">___________________________________</p>'+
                             '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                             '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                             '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                $(win.document.body).find('table')
                    .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                        '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                        '</tr>' +
                        '</table>');
            },
            orientation: 'landscape',
       
               exportOptions: {
             columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
            }

       
             }
    ],
        ajax: {
            url: "getdata.php",
            type: "post",
            data: {build2: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#showBuild2').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: 'getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                
                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                $("#asset").append(assetOption).trigger("change");
                var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                $("#subasset").append(subOption).trigger("change");
                $('#modal-input1').val(data[0].description);
                $('#modal-input2').val(data[0].property_no);
                $('#modal-input3').val(data[0].unit_meas);
                $('#modal-input4').val(data[0].unit_val);
                $('#modal-input5').val(data[0].qty_property_card);
                $('#modal-input6').val(data[0].qty_physical_count);
                $('#modal-input7').val(data[0].shortage_qty);
                $('#modal-input8').val(data[0].shortage_value);
                var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                $('select.edit_personnel').append(officerOption).trigger('change');
                $('#modal-input10').val(data[0].remarks);


               
                $('#editmodalbuild1').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: 'function.php',
                        type: 'POST',
                        data: {
                            updatebuild2: true,
                            id: id,
                            asset: $('#asset').val(),
                                subasset: $('#subasset').val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editmodalbuild1').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file. Select Personnel ',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});


    $('#showBuild2').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'function.php',
                    type: 'POST',
                    data: {
                        deletebuild2: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });
});





//rpcppe.php
$(document).ready(function () {
    $(".select2-container").css("margin-bottom", "10px");

    var totalUnitVal = 0;

    // Define the table variable in the outer scope
    var table = $('#showTable_rpcsp').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: true,
        autoWidth: true,
        dom: 'lBfrtip',
        buttons: [
            "copy",
            "csv",
            "excel", {
                extend: 'print',
                customize: function (win) {
                    $(win.document.body).css('font-size', '10pt');
                    var formattedTotal = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'PHP',
                        minimumFractionDigits: 2
                    }).format(totalUnitVal);

                    $(win.document.body).find('table')
                        .before('<h1 style="text-align:center;">REPORT ON THE PHYSICAL COUNT OF SEMI EXPENDABLE PROPERTY</h1>' +
                            '<p style="text-align:center;">___________________________________</p>' +
                            '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>' +
                            '<p><b>Fund Cluster:</b> <span>_________________</span></p>' +
                            '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');

                    $(win.document.body).find('table tbody').append(
                        '<tr>' +
                        '<td colspan="4" style="text-align:right; font-weight:bold;">Total Unit Value:</td>' +
                        '<td style="font-weight:bold;">' + formattedTotal + '</td>' +
                        '<td colspan="7"></td>' +
                        '</tr>'
                    );

                    $(win.document.body).find('table').after(
                        '<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style="text-align:center;">Certified Corrected by:____________________<br>' +
                        '<span style="font-weight:bold; font-size:14px;">Signature over Printed Name of Inventory Committee Chair and Members</span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br>' +
                        '<span style="font-weight:bold; font-size:14px;">Signature over Printed Name of Head of Agency/Entity or Authorized Representative</span></td>' +
                        '<td style="text-align:center;">Verified by:_______________________<br>' +
                        '<span style="font-weight:bold; font-size:14px;">Signature over Printed Name of COA Representative</span></td>' +
                        '</tr>' +
                        '</table>'
                    );
                },
                orientation: 'landscape',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]
                }
            }
        ],
        ajax: {
            url: "getdata.php",
            type: "POST",
            data: function (e) {
                e.rpcsp = true;
                e.category = $('select.category').val();
                e.value_range = $('select.value').val();
                return e;
            },
            error: function (xhr, status, error) {
                console.log("Ajax request failed: " + xhr.responseText);
            }
        },
        columns: [
            { "data": "article_id" },
            {
                "data": null,
                "render": function (data, type, row) {
                    return '<div class="row">' +
                        '<div class="col">' + row.description + "  " +
                        '<strong>Model:</strong> ' + row.model +
                        '</div>' +
                        '<div class="col">' +
                        '<strong>SN:</strong> ' + row.asset_sn +
                        '</div>' +
                        '</div>';
                }
            },
            { "data": "property_no" },
            { "data": "unit_meas" },
            {
                "data": "unit_val",
                "render": function (data, type, row) {
                    var formattedValue = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'PHP',
                        minimumFractionDigits: 2
                    }).format(data);

                    return formattedValue;
                }
            },
            { "data": "qty_property_card" },
            { "data": "qty_physical_count" },
            { "data": "shortage_qty" },
            { "data": "shortage_value" },
            { "data": "date_acquired" },
            { "data": "remarks" },
            { "data": "fullname" },
        ],
        lengthMenu: [
            [10, 25, 50, 100000000],
            [10, 25, 50, 'ALL']
        ],
        drawCallback: function () {
            var api = this.api();

            totalUnitVal = api.column(4, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);

            var formattedTotal = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'PHP',
                minimumFractionDigits: 2
            }).format(totalUnitVal);

            $('#totalUnitMeas').html('Total: ' + formattedTotal);
        }
    });

   
    $("select.category, select.value").on('change', function () {
        var selectedCategory = $('select.category').val();
        var valueRange = $('select.value').val();

      
        table.ajax.url('getdata.php?rpcsp=true&category=' + selectedCategory + '&value_range=' + valueRange).load();
    });






//     $('#showTable_rpcppe').on('click', '.delete-btn', function() {
//         var id = $(this).data('delete');
//         Swal.fire({
//             title: 'Are you sure?',
//             text: "You want to delete it?",
//             icon: 'warning',
//             showCancelButton: true,
//             confirmButtonColor: '#3085d6',
//             cancelButtonColor: '#d33',
//             confirmButtonText: 'Yes, delete it!'
//         }).then((result) => {
//             if (result.isConfirmed) {
//                 $.ajax({
//                     url: 'function.php',
//                     type: 'POST',
//                     data: {
//                         rpcppe1: true,
//                         id: id
//                     },
//                     success: function(response) {
//                         if (response.trim() === "Deleted Successfully") {
//                             Swal.fire(
//                                 'Deleted!',
//                                 'File has been deleted successfully.',
//                                 'success'
//                             );
//                             table.ajax.reload();
//                         } else {
//                             Swal.fire(
//                                 'Failed!',
//                                 'Failed to delete file.',
//                                 'error'
//                             );
//                         }
//                     },
//                 });
//             }
//         });
//     });

});


//rpci.php
    $(document).ready(function() {
        $("select.category").select2({
            placeholder: "Sort by:",
            theme:"bootstrap4",
            
            ajax: {
                url: 'fetch1.php',
                dataType: 'json',
                type: 'POST',
                delay: 250,
                data: function(params) {
                    return {
                        term: params.term,
                        category: true,
                    };
                },
                processResults: function(returnedData) {
                    var mappedData = $.map(returnedData.data, function(fetch) {
                        return {
                            id: fetch.id,
                            text: fetch.sub_category
                        };
                    });
                    return {
                        results: mappedData
                    };
                },
                cache: true
            },
            minimumInputLength: 0,
            templateResult: formatCategory,
            templateSelection: formatCategorySelection
        });
        
        function formatCategory(category) {
            if (!category.id) {
                return category.text;
            }
            var $category = $(
                '<span>' + category.text + '</span>'
            );
            return $category;
        }
        
        function formatCategorySelection(category) {
            return category.text;
        }
        $(".select2-container").css("margin-bottom", "10px");
        var table = $('#showTable_rpcppe').DataTable({
            serverSide: true,
            responsive: true,
            lengthChange: true,
            autoWidth: true,
            dom: 'lBfrtip',
            buttons: [
                "copy", 
                "csv", 
                "excel", 
                {
                    extend: 'print',
                    customize: function(win) {
                        $(win.document.body).css('font-size', '10pt');
                        var formattedTotal = new Intl.NumberFormat('en-US', {
                            style: 'currency',
                            currency: 'PHP',
                            minimumFractionDigits: 2
                        }).format(totalUnitVal);
                    
                        $(win.document.body).find('table')
                            .before('<h1 style="text-align:center;">REPORT ON THE PHYSICAL COUNT OF PROPERTY, PLANT AND EQUIPMENT</h1>'+
                                    '<p style="text-align:center;">___________________________________</p>'+
                                    '<p style="text-align:center; margin-top:-1em">(Type of Inventory Item)</p>'+
                                    '<p style="text-align:center; margin-top:-1em">As at June, 2023</p>'+
                                    '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                                    '<p><b>For which _______________________________,_______________________________,_______________________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                    
                                    $(win.document.body).find('table tbody').append(
                                        '<tr>' +
                                        '<td colspan="4" style="text-align:right; font-weight:bold;">Total Unit Value:</td>' +
                                        '<td style="font-weight:bold;">' + formattedTotal + '</td>' +
                                        '<td colspan="7"></td>' +
                                        '</tr>'
                                    );

                            $(win.document.body).find('table')
                            .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                                '<tr>' +
                                '<td style="width:30%;">Certified Corrected by:____________________________<br><span style="font-weight:bold; margin-top:-1em; margin-left:5.5em;"><b>Signature over Printed Name of Inventory <span style="margin-left:5.5em;"> Commitee Chair and Members</b></span></span></td>' +
                                '<td style="width:30%;">Approved by:_____________________________<br><span style="font-weight:bold; margin-top:-1em; margin-left:5.5em;"><b>Signature over Printed Name of Head of <span style="margin-left:5.5em;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                                '<td style="width:30%;">Verified by:____________________________<br><span style="font-weight:bold; margin-top:-1em; margin-left:6em; justify-content:center; align-items:center;"><b>Signature over Printed Name of COA <span  style="margin-left:5.5em;">Representative</span></b></span></td>' +
                                '</tr>' +
                                '</table>');
                    },
                    orientation: 'landscape'
                }
            ],
            ajax: {
                url: "getdata.php",
                type: "post",
                data: function(r) {
                    r.rpcppe = true;
                    r.category = $('select.category').val();
                    return r;
                },
                error: function(thrown) {
                    console.log("Ajax request failed: " + thrown);
                }
            },
            columns: [  
                {"data": "article_id"},
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return '<div class="row">' + 
                                '<div class="col">' + row.description + "  " +
                                    '<strong>Model:</strong> ' + row.model +
                                '</div>' +
                                '<div class="col">' +
                                    '<strong>SN:</strong> ' + row.asset_sn +
                                '</div>' +
                            '</div>';
                    }
                },
                {"data": "stock_no"},
                {"data": "unit_meas"},
                {
                    "data": "unit_val",
                    "render": function(data, type, row) {
                        var formattedValue = new Intl.NumberFormat('en-US', {
                            style: 'currency',
                            currency: 'PHP',
                            minimumFractionDigits: 2
                        }).format(data);
                        
                        return formattedValue;
                    }
                }, 
                {"data": "qty_property_card"},
                {"data": "qty_physical_count"},
                {"data": "shortage_qty"},
                {"data": "shortage_value"},
                {"data": "remarks"},
                {"data": "fullname"},
            ],
            drawCallback: function () {
                var api = this.api();
                
                totalUnitVal = api.column(4, { page: 'current' }).data().reduce(function (a, b) {
                    return a + parseFloat(b);
                }, 0);
            
                var formattedTotal = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'PHP',
                    minimumFractionDigits: 2
                }).format(totalUnitVal);
            
                $('#totalUnitMeas').html('Total: ' + formattedTotal);
            },
            
            lengthMenu: [[10, 25, 50, 100000000], [10, 25, 50, "All"]] 
            });

            table.on('length.dt', function (e, settings, len) {
            console.log('New page length: '+len);
        });

        $("select.category, select.value").on('change', function () {
            var selectedCategory = $('select.category').val();

            table.ajax.url('getdata.php?rpcppe=true&category=' + selectedCategory).load();
        });
        




// $('#showTable_rpci').on('click', '.update-btn', function() {
//     var id = $(this).data('update');
//     console.log(id);    
//     $.ajax({
//         url: 'getdata.php',
//         type: 'POST',
//         data: {
//             getdata: true,
//             id: id
//         },
//         success: function(response) {
//             if (response.trim() !== "") {
//                 var data = JSON.parse(response);
//                 Swal.fire({
//                     title: 'Edit Data',
//                     html: '<input id="swal-input1" class="swal2-input" value="' + data[0].description + '">'+
//                     '<input id="swal-input2" class="swal2-input" value="' + data[0].property_no + '">' +
//                     '<input id="swal-input3" class="swal2-input" value="' + data[0].unit_meas + '">'+ 
//                     '<input id="swal-input4" class="swal2-input" value="₱' + data[0].unit_val + '">' +
//                     '<input id="swal-input5" class="swal2-input" value="' + data[0].qty_property_card +'">'+
//                     '<input id="swal-input6" class="swal2-input" value="' + data[0].qty_physical_count +'">'+
//                     '<input id="swal-input7" class="swal2-input" value="' + data[0].shortage_qty +'">'+
//                     '<input id="swal-input8" class="swal2-input" value="' + data[0].shortage_value +'">'+
//                     '<input id="swal-input9" class="swal2-input" value="' + data[0].remarks +'">',
//                     focusConfirm: false,
//                     confirmButtonText: 'Update',
//                     preConfirm: () => {
//                         const value1 = document.getElementById('swal-input1').value;
//                         const value2 = document.getElementById('swal-input2').value;
//                         const value3 = document.getElementById('swal-input3').value;
//                         const value4 = document.getElementById('swal-input4').value.replace('₱', ''); 
//                         const value5 = document.getElementById('swal-input5').value;
//                         const value6 = document.getElementById('swal-input6').value;
//                         const value7 = document.getElementById('swal-input7').value;
//                         const value8 = document.getElementById('swal-input8').value;
//                         const value9 = document.getElementById('swal-input9').value;
//                         return [value1,value2,value3,value4,value5,value6,value7,value8,value9];
//                     },
//                 }).then((result) => {
//                     if (result.isConfirmed) {
//                         const [value1, value2, value3, value4, value5, value6, value7, value8, value9] = result.value;
//                         $.ajax({
//                             url: 'function.php',
//                             type: 'POST',
//                             data: {
//                                 rpci: true,
//                                 id: id,
//                                 description: value1,
//                                 property_no: value2,
//                                 unit_meas: value3,
//                                 unit_val: value4,
//                                 qty_property_card: value5,
//                                 qty_physical_count: value6,
//                                 shortage_qty: value7,
//                                 shortage_value: value8,
//                                 remarks: value9,
//                             },
//                             success: function(response) {
//                                 if (response.trim() === "Updated Successfully") {
//                                     Swal.fire(
//                                         'Updated!',
//                                         'File has been updated successfully.',
//                                         'success'
//                                     );
//                                     table.ajax.reload();
//                                 } else {
//                                     Swal.fire(
//                                         'Failed!',
//                                         'Failed to update file.',
//                                         'error'
//                                     );
//                                 }
//                             },
                           
//                         });
//                     }
//                 });
//             } 
//         },

//     });
// })


    // $('#showTable_rpci').on('click', '.delete-btn', function() {
    //     var id = $(this).data('delete');
    //     Swal.fire({
    //         title: 'Are you sure?',
    //         text: "You want to delete it?",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Yes, delete it!'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             $.ajax({
    //                 url: 'function.php',
    //                 type: 'POST',
    //                 data: {
    //                     rpci1: true,
    //                     id: id
    //                 },
    //                 success: function(response) {
    //                     if (response.trim() === "Deleted Successfully") {
    //                         Swal.fire(
    //                             'Deleted!',
    //                             'File has been deleted successfully.',
    //                             'success'
    //                         );
    //                         table.ajax.reload();
    //                     } else {
    //                         Swal.fire(
    //                             'Failed!',
    //                             'Failed to delete file.',
    //                             'error'
    //                         );
    //                     }
    //                 },
    //             });
    //         }
    //     });
    // });

});

//transportation.php
$(document).ready(function() {
    var table = $('#showTable_transport').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dom: 'lBfrtip',
        buttons: [
            "copy", 
            "csv", 
            "excel", 
            {
                extend: 'print',
                customize: function(win) {
                    $(win.document.body).css('font-size', '10pt');
                    $(win.document.body).find('table')
                        .before('<h1 style="text-align:center;">Report on Transportation and Equipment</h1>'+
                                 '<p style="text-align:center;">___________________________________</p>'+
                                 '<p style="text-align:center; margin-top:-1em">(Type of Inventory Item)</p>'+
                                 '<p style="text-align:center; margin-top:-1em">As at June, 2023</p>'+
                                 '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                                 '<p><b>For which _______________________________,_______________________________,_______________________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                    $(win.document.body).find('table')
                        .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                            '<tr>' +
                            '<td style="width:30%;">Certified Corrected by:____________________________<br><span style="font-weight:bold; margin-top:-1em; margin-left:5.5em;"><b>Signature over Printed Name of Inventory <span style="margin-left:5.5em;"> Commitee Chair and Members</b></span></span></td>' +
                            '<td style="width:30%;">Approved by:_____________________________<br><span style="font-weight:bold; margin-top:-1em; margin-left:5.5em;"><b>Signature over Printed Name of Head of <span style="margin-left:5.5em;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                            '<td style="width:30%;">Verified by:____________________________<br><span style="font-weight:bold; margin-top:-1em; margin-left:6em; justify-content:center; align-items:center;"><b>Signature over Printed Name of COA <span  style="margin-left:5.5em;">Representative</span></b></span></td>' +
                            '</tr>' +
                            '</table>');
                },
                orientation: 'landscape'
            }
        ],
        ajax: {
            url: "getdata.php",
            type: "post",
            data: {transport: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#showTable_transport').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: 'getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                
                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                    $("#asset").append(assetOption).trigger("change");
                    var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                    $("#subasset").append(subOption).trigger("change");
                    $('#modal-input1').val(data[0].description);
                    $('#modal-input2').val(data[0].property_no);
                    $('#modal-input3').val(data[0].unit_meas);
                    $('#modal-input4').val(data[0].unit_val);
                    $('#modal-input5').val(data[0].qty_property_card);
                    $('#modal-input6').val(data[0].qty_physical_count);
                    $('#modal-input7').val(data[0].shortage_qty);
                    $('#modal-input8').val(data[0].shortage_value);
                    var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                    $('select.edit_personnel').append(officerOption).trigger('change');
                    $('#modal-input10').val(data[0].remarks);
    

               
                $('#editmodalbuild1').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: 'function.php',
                        type: 'POST',
                        data: {
                            updatebuild1: true,
                            id: id,
                            asset: $('#asset').val(),
                                subasset: $('#subasset').val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editmodalbuild1').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file. Select Personnel',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});



    $('#showTable_transport').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'function.php',
                    type: 'POST',
                    data: {
                        transport1: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });
});

//book.php
$(document).ready(function() {
    var table = $('#showTable_books').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dom: 'lBfrtip',
        buttons: [
            "copy", 
            "csv", 
            "excel", 
            {
                extend: 'print',
                customize: function(win) {
                    $(win.document.body).css('font-size', '10pt');
                    $(win.document.body).find('table')
                        .before('<h1 style="text-align:center;">Report on Books</h1>'+
                                 '<p style="text-align:center;">___________________________________</p>'+
                                 '<p style="text-align:center; margin-top:-1em">(Type of Inventory Item)</p>'+
                                 '<p style="text-align:center; margin-top:-1em">As at June, 2023</p>'+
                                 '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                                 '<p><b>For which _______________________________,_______________________________,_______________________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                    $(win.document.body).find('table')
                        .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                            '<tr>' +
                            '<td style="width:30%;">Certified Corrected by:____________________________<br><span style="font-weight:bold; margin-top:-1em; margin-left:5.5em;"><b>Signature over Printed Name of Inventory <span style="margin-left:5.5em;"> Commitee Chair and Members</b></span></span></td>' +
                            '<td style="width:30%;">Approved by:_____________________________<br><span style="font-weight:bold; margin-top:-1em; margin-left:5.5em;"><b>Signature over Printed Name of Head of <span style="margin-left:5.5em;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                            '<td style="width:30%;">Verified by:____________________________<br><span style="font-weight:bold; margin-top:-1em; margin-left:6em; justify-content:center; align-items:center;"><b>Signature over Printed Name of COA <span  style="margin-left:5.5em;">Representative</span></b></span></td>' +
                            '</tr>' +
                            '</table>');
                },
                orientation: 'landscape'
            }
        ],
        ajax: {
            url: "getdata.php",
            type: "post",
            data: {books: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#showTable_books').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: 'getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                
                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                $("#asset").append(assetOption).trigger("change");
                var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                $("#subasset").append(subOption).trigger("change");
                $('#modal-input1').val(data[0].description);
                $('#modal-input2').val(data[0].property_no);
                $('#modal-input3').val(data[0].unit_meas);
                $('#modal-input4').val(data[0].unit_val);
                $('#modal-input5').val(data[0].qty_property_card);
                $('#modal-input6').val(data[0].qty_physical_count);
                $('#modal-input7').val(data[0].shortage_qty);
                $('#modal-input8').val(data[0].shortage_value);
                var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                $('select.edit_personnel').append(officerOption).trigger('change');
                $('#modal-input10').val(data[0].remarks);


               
                $('#editmodalbuild1').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: 'function.php',
                        type: 'POST',
                        data: {
                            updatebuild1: true,
                            id: id,
                            asset: $('#asset').val(),
                                subasset: $('#subasset').val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editmodalbuild1').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file. Select Personnel',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});



    $('#showTable_books').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'function.php',
                    type: 'POST',
                    data: {
                        books1: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });
});

//furniture.php
$(document).ready(function() {
    var table = $('#showTable_furniture').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dom: 'lBfrtip',
        buttons: [
            "copy", 
            "csv", 
            "excel", 
            {
                extend: 'print',
                customize: function(win) {
                    $(win.document.body).css('font-size', '10pt');
                    $(win.document.body).find('table')
                        .before('<h1 style="text-align:center;">Report on Furniture and Fixture</h1>'+
                                 '<p style="text-align:center;">___________________________________</p>'+
                                 '<p style="text-align:center; margin-top:-1em">(Type of Inventory Item)</p>'+
                                 '<p style="text-align:center; margin-top:-1em">As at June, 2023</p>'+
                                 '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                                 '<p><b>For which _______________________________,_______________________________,_______________________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                    $(win.document.body).find('table')
                        .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                            '<tr>' +
                            '<td style="width:30%;">Certified Corrected by:____________________________<br><span style="font-weight:bold; margin-top:-1em; margin-left:5.5em;"><b>Signature over Printed Name of Inventory <span style="margin-left:5.5em;"> Commitee Chair and Members</b></span></span></td>' +
                            '<td style="width:30%;">Approved by:_____________________________<br><span style="font-weight:bold; margin-top:-1em; margin-left:5.5em;"><b>Signature over Printed Name of Head of <span style="margin-left:5.5em;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                            '<td style="width:30%;">Verified by:____________________________<br><span style="font-weight:bold; margin-top:-1em; margin-left:6em; justify-content:center; align-items:center;"><b>Signature over Printed Name of COA <span  style="margin-left:5.5em;">Representative</span></b></span></td>' +
                            '</tr>' +
                            '</table>');
                },
                orientation: 'landscape'
            }
        ],
        ajax: {
            url: "getdata.php",
            type: "post",
            data: {furniture: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#showTable_furniture').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: 'getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                
                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                    $("#asset").append(assetOption).trigger("change");
                    var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                    $("#subasset").append(subOption).trigger("change");
                    $('#modal-input1').val(data[0].description);
                    $('#modal-input2').val(data[0].property_no);
                    $('#modal-input3').val(data[0].unit_meas);
                    $('#modal-input4').val(data[0].unit_val);
                    $('#modal-input5').val(data[0].qty_property_card);
                    $('#modal-input6').val(data[0].qty_physical_count);
                    $('#modal-input7').val(data[0].shortage_qty);
                    $('#modal-input8').val(data[0].shortage_value);
                    var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                    $('select.edit_personnel').append(officerOption).trigger('change');
                    $('#modal-input10').val(data[0].remarks);
    

               
                $('#editmodalbuild1').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: 'function.php',
                        type: 'POST',
                        data: {
                            updatebuild1: true,
                            id: id,
                            asset: $('#asset').val(),
                                subasset: $('#subasset').val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editmodalbuild1').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file. Select Personnel',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});


    $('#showTable_furniture').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'function.php',
                    type: 'POST',
                    data: {
                        furniture1: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });
});

//others.php


$(document).ready(function() {
    var table = $('#showTable_others').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dom: 'lBfrtip',
        buttons: [
            "copy", 
            "csv", 
            "excel", 
            {
                extend: 'print',
                customize: function(win) {
                    $(win.document.body).css('font-size', '10pt');
                    $(win.document.body).find('table')
                        .before('<h1 style="text-align:center;">Report on Other Property Plants and Equipment</h1>'+
                                 '<p style="text-align:center;">___________________________________</p>'+
                                 '<p style="text-align:center; margin-top:-1em">(Type of Inventory Item)</p>'+
                                 '<p style="text-align:center; margin-top:-1em">As at June, 2023</p>'+
                                 '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                                 '<p><b>For which _______________________________,_______________________________,_______________________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                    $(win.document.body).find('table')
                        .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                            '<tr>' +
                            '<td style="width:30%;">Certified Corrected by:____________________________<br><span style="font-weight:bold; margin-top:-1em; margin-left:5.5em;"><b>Signature over Printed Name of Inventory <span style="margin-left:5.5em;"> Commitee Chair and Members</b></span></span></td>' +
                            '<td style="width:30%;">Approved by:_____________________________<br><span style="font-weight:bold; margin-top:-1em; margin-left:5.5em;"><b>Signature over Printed Name of Head of <span style="margin-left:5.5em;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                            '<td style="width:30%;">Verified by:____________________________<br><span style="font-weight:bold; margin-top:-1em; margin-left:6em; justify-content:center; align-items:center;"><b>Signature over Printed Name of COA <span  style="margin-left:5.5em;">Representative</span></b></span></td>' +
                            '</tr>' +
                            '</table>');
                },
                orientation: 'landscape'
            }
        ],
        ajax: {
            url: "getdata.php",
            type: "post",
            data: {others: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#showTable_others').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: 'getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                
                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                $("#asset").append(assetOption).trigger("change");
                var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                $("#subasset").append(subOption).trigger("change");
                $('#modal-input1').val(data[0].description);
                $('#modal-input2').val(data[0].property_no);
                $('#modal-input3').val(data[0].unit_meas);
                $('#modal-input4').val(data[0].unit_val);
                $('#modal-input5').val(data[0].qty_property_card);
                $('#modal-input6').val(data[0].qty_physical_count);
                $('#modal-input7').val(data[0].shortage_qty);
                $('#modal-input8').val(data[0].shortage_value);
                var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                $('select.edit_personnel').append(officerOption).trigger('change');
                $('#modal-input10').val(data[0].remarks);


               
                $('#editmodalbuild1').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: 'function.php',
                        type: 'POST',
                        data: {
                            updatebuild1: true,
                            id: id,
                            asset: $('#asset').val(),
                                subasset: $('#subasset').val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editmodalbuild1').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file. Select Personnel',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});



    $('#showTable_others').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'function.php',
                    type: 'POST',
                    data: {
                        others1: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });
});


$("select.selectasset").select2({
    theme: "bootstrap4",
    placeholder: "Select Category",
    ajax: {
        url: 'fetch1.php',
        dataType: 'json',
        type: 'POST',
        delay: 250,
        data: function(params) {
            return {
                term: params.term,
                asset1: true,
            };
        },
        processResults: function(returnedData) {
            var mappedData = $.map(returnedData.data, function(fetch) {
                return {
                    id: fetch.id,
                    text: fetch.category
                };
            });
            return {
                results: mappedData
            };
        },
        cache: true
    },
    minimumInputLength: 0,
    templateResult: formatCategory,
    templateSelection: formatCategorySelection
});

// function formatCategory(category) {
//     if (!category.id) {
//         return category.text;
//     }
//     var $category = $('<span>' + category.text + '</span>');
//     return $category;
// }

// function formatCategorySelection(category) {
//     return category.text;
// }

// $("select.asset2").select2({
//     placeholder: "Select Sub Category",
//     theme: "bootstrap4",
//     minimumInputLength: 0
// });

// $("select.asset1").on('change', function() {
//     var selectedCategoryId = $(this).val();
//     $("select.select2").empty(); 
//     if (selectedCategoryId) {
    
//         $("select.asset2").select2({
//             placeholder: "Select Sub Category",
//             theme: "bootstrap4",
//             minimumInputLength: 0,
//             ajax: {
//                 url: 'fetch1.php',
//                 dataType: 'json',
//                 type: 'POST',
//                 delay: 250,
//                 data: function(params) {
//                     return {
//                         term: params.term,
//                         fetch2: true,
//                         category_id: selectedCategoryId 
//                     };
//                 },
//                 processResults: function(returnedData) {
//                     var mappedData = $.map(returnedData.data, function(fetch) {
//                         return {
//                             id: fetch.id,
//                             text: fetch.sub_category
//                         };
//                     });
//                     return {
//                         results: mappedData
//                     };
//                 },
//                 cache: true
//             }
//         });
//     }
// });

$("select.asset_type_school").select2({
    theme: "bootstrap4",
    placeholder: "Asset Type",
    ajax: {
        url: '../fetch1.php',
        dataType: 'json',
        type: 'POST',
        delay: 250,
        data: function(params) {
            return {
                term: params.term,
                asset1: true,
                category_id: params.term 
            };
        },
        processResults: function(returnedData) {
            var mappedData = $.map(returnedData.data, function(fetch) {
                return {
                    id: fetch.id,
                    text: fetch.category
                };
            });
            return {
                results: mappedData
            };
        },
        cache: true
    },
    minimumInputLength: 0,
    templateResult: formatCategory,
    templateSelection: formatCategorySelection
});


$("select.sub_asset_type_school").select2({
    placeholder: "Sub Asset",
    theme: "bootstrap4",
    ajax: {
        url: '../fetch1.php',
        dataType: 'json',
        type: 'POST',
        delay: 250,
        data: function(params) {
            var selectedCategoryId = $('select.asset_type_school').val(); 
            return {
                term: params.term,
                asset2: true,
                category_id: selectedCategoryId 
            };
        },
        processResults: function(returnedData) {
            var mappedData = $.map(returnedData.data, function(fetch) {
                return {
                    id: fetch.id,
                    text: fetch.sub_category
                };
            });
            return {
                results: mappedData
            };
        },
        cache: true
    },
    minimumInputLength: 0,
    templateResult: formatCategory,
    templateSelection: formatCategorySelection
});

function formatCategory(category) {
    if (!category.id) {
        return category.text;
    }
    var $category = $(
        '<span>' + category.text + '</span>'
    );
    return $category;
}

function formatCategorySelection(category) {
    return category.text;
}

$("select.asset_type").select2({
    theme: "bootstrap4",
    placeholder: "Asset Type",
    ajax: {
        url: 'fetch1.php',
        dataType: 'json',
        type: 'POST',
        delay: 250,
        data: function(params) {
            return {
                term: params.term,
                asset1: true,
                category_id: params.term 
            };
        },
        processResults: function(returnedData) {
            var mappedData = $.map(returnedData.data, function(fetch) {
                return {
                    id: fetch.id,
                    text: fetch.category
                };
            });
            return {
                results: mappedData
            };
        },
        cache: true
    },
    minimumInputLength: 0,
    templateResult: formatCategory,
    templateSelection: formatCategorySelection
});


$("select.sub_asset_type").select2({
    placeholder: "Sub Asset",
    theme: "bootstrap4",
    dropdownParent: $("#exampleModal1"),
    ajax: {
        url: 'fetch1.php',
        dataType: 'json',
        type: 'POST',
        delay: 250,
        data: function(params) {
            var selectedCategoryId = $('select.asset_type').val(); 
            return {
                term: params.term,
                asset2: true,
                category_id: selectedCategoryId 
            };
        },
        processResults: function(returnedData) {
            var mappedData = $.map(returnedData.data, function(fetch) {
                return {
                    id: fetch.id,
                    text: fetch.sub_category
                };
            });
            return {
                results: mappedData
            };
        },
        cache: true
    },
    minimumInputLength: 0,
    templateResult: formatCategory,
    templateSelection: formatCategorySelection
});

function formatCategory(category) {
    if (!category.id) {
        return category.text;
    }
    var $category = $(
        '<span>' + category.text + '</span>'
    );
    return $category;
}

function formatCategorySelection(category) {
    return category.text;
}
//


$("select.land_sch").select2({
    theme:"bootstrap4",
    placeholder: "Asset Type",
    ajax: {
        url: '../fetch1.php',
        dataType: 'json',
        type: 'POST',
        delay: 250,
        data: function(params) {
            return {
                term: params.term,
                land: true,
            };
        },
        processResults: function(returnedData) {
            var mappedData = $.map(returnedData.data, function(fetch) {
                return {
                    id: fetch.id,
                    text: fetch.category
                };
            });
            return {
                results: mappedData
            };
        },
        cache: true
    },
    minimumInputLength: 0,
    templateResult: formatCategory,
    templateSelection: formatCategorySelection
});


$("select.land").select2({
    theme:"bootstrap4",
    placeholder: "Asset Type",
    ajax: {
        url: 'fetch1.php',
        dataType: 'json',
        type: 'POST',
        delay: 250,
        data: function(params) {
            return {
                term: params.term,
                land: true,
            };
        },
        processResults: function(returnedData) {
            var mappedData = $.map(returnedData.data, function(fetch) {
                return {
                    id: fetch.id,
                    text: fetch.category
                };
            });
            return {
                results: mappedData
            };
        },
        cache: true
    },
    minimumInputLength: 0,
    templateResult: formatCategory,
    templateSelection: formatCategorySelection
});

function formatCategory(category) {
    if (!category.id) {
        return category.text;
    }
    var $category = $(
        '<span>' + category.text + '</span>'
    );
    return $category;
}

function formatCategorySelection(category) {
    return category.text;
}

$("select.land1").select2({
    placeholder: "Sub Asset",
    theme:"bootstrap4",
    ajax: {
        url: 'fetch1.php',
        dataType: 'json',
        type: 'POST',
        delay: 250,
        data: function(params) {
            return {
                term: params.term,
                land1: true,
            };
        },
        processResults: function(returnedData) {
            var mappedData = $.map(returnedData.data, function(fetch) {
                return {
                    id: fetch.id,
                    text: fetch.sub_category
                };
            });
            return {
                results: mappedData
            };
        },
        cache: true
    },
    minimumInputLength: 0,
    templateResult: formatCategory,
    templateSelection: formatCategorySelection
});

function formatCategory(category) {
    if (!category.id) {
        return category.text;
    }
    var $category = $(
        '<span>' + category.text + '</span>'
    );
    return $category;
}

function formatCategorySelection(category) {
    return category.text;
}




$("select.asset1").select2({
    theme:"bootstrap4",
    placeholder: "Select rzcccvblvvAsset Type",
    ajax: {
        url: 'fetch1.php',
        dataType: 'json',
        type: 'POST',
        delay: 250,
        data: function(params) {
            return {
                term: params.term,
                fetch3: true,
            };
        },
        processResults: function(returnedData) {
            var mappedData = $.map(returnedData.data, function(fetch) {
                return {
                    id: fetch.id,
                    text: fetch.category
                };
            });
            return {
                results: mappedData
            };
        },
        cache: true
    },
    minimumInputLength: 0,
    templateResult: formatCategory,
    templateSelection: formatCategorySelection
});

$("select.asset2").select2({
    theme:"bootstrap4",
    placeholder: "Select Sub-Asset Type",
    ajax: {
        url: 'fetch1.php',
        dataType: 'json',
        type: 'POST',
        delay: 250,
        data: function(params) {
            return {
                term: params.term,
                fetch3: true,
            };
        },
        processResults: function(returnedData) {
            var mappedData = $.map(returnedData.data, function(fetch) {
                return {
                    id: fetch.id,
                    text: fetch.category
                };
            });
            return {
                results: mappedData
            };
        },
        cache: true
    },
    minimumInputLength: 0,
    templateResult: formatCategory,
    templateSelection: formatCategorySelection
});


$("select.build1").select2({
    theme:"bootstrap4",
    placeholder: "Asset Type",
    ajax: {
        url: 'fetch1.php',
        dataType: 'json',
        type: 'POST',
        delay: 250,
        data: function(params) {
            return {
                term: params.term,
                fetch3: true,
            };
        },
        processResults: function(returnedData) {
            var mappedData = $.map(returnedData.data, function(fetch) {
                return {
                    id: fetch.id,
                    text: fetch.category
                };
            });
            return {
                results: mappedData
            };
        },
        cache: true
    },
    minimumInputLength: 0,
    templateResult: formatCategory,
    templateSelection: formatCategorySelection
});

function formatCategory(category) {
    if (!category.id) {
        return category.text;
    }
    var $category = $(
        '<span>' + category.text + '</span>'
    );
    return $category;
}

function formatCategorySelection(category) {
    return category.text;
}

$("select.build2").select2({
    placeholder: "Sub Asset",
    theme:"bootstrap4",
    ajax: {
        url: 'fetch1.php',
        dataType: 'json',
        type: 'POST',
        delay: 250,
        data: function(params) {
            return {
                term: params.term,
                fetch4: true,
            };
        },
        processResults: function(returnedData) {
            var mappedData = $.map(returnedData.data, function(fetch) {
                return {
                    id: fetch.id,
                    text: fetch.sub_category
                };
            });
            return {
                results: mappedData
            };
        },
        cache: true
    },
    minimumInputLength: 0,
    templateResult: formatCategory,
    templateSelection: formatCategorySelection
});

function formatCategory(category) {
    if (!category.id) {
        return category.text;
    }
    var $category = $(
        '<span>' + category.text + '</span>'
    );
    return $category;
}

function formatCategorySelection(category) {
    return category.text;
}



$("select.transport1").select2({
    theme:"bootstrap4",
    placeholder: "Asset Type",
    ajax: {
        url: 'fetch1.php',
        dataType: 'json',
        type: 'POST',
        delay: 250,
        data: function(params) {
            return {
                term: params.term,
                fetch5: true,
            };
        },
        processResults: function(returnedData) {
            var mappedData = $.map(returnedData.data, function(fetch) {
                return {
                    id: fetch.id,
                    text: fetch.category
                };
            });
            return {
                results: mappedData
            };
        },
        cache: true
    },
    minimumInputLength: 0,
    templateResult: formatCategory,
    templateSelection: formatCategorySelection
});

function formatCategory(category) {
    if (!category.id) {
        return category.text;
    }
    var $category = $(
        '<span>' + category.text + '</span>'
    );
    return $category;
}

function formatCategorySelection(category) {
    return category.text;
}

$("select.transport2").select2({
    placeholder: "Sub Asset",
    theme:"bootstrap4",
    ajax: {
        url: 'fetch1.php',
        dataType: 'json',
        type: 'POST',
        delay: 250,
        data: function(params) {
            return {
                term: params.term,
                fetch6: true,
            };
        },
        processResults: function(returnedData) {
            var mappedData = $.map(returnedData.data, function(fetch) {
                return {
                    id: fetch.id,
                    text: fetch.sub_category
                };
            });
            return {
                results: mappedData
            };
        },
        cache: true
    },
    minimumInputLength: 0,
    templateResult: formatCategory,
    templateSelection: formatCategorySelection
});

function formatCategory(category) {
    if (!category.id) {
        return category.text;
    }
    var $category = $(
        '<span>' + category.text + '</span>'
    );
    return $category;
}

function formatCategorySelection(category) {
    return category.text;
}



$("select.book1").select2({
    theme:"bootstrap4",
    placeholder: "Asset Type",
    ajax: {
        url: 'fetch1.php',
        dataType: 'json',
        type: 'POST',
        delay: 250,
        data: function(params) {
            return {
                term: params.term,
                fetch7: true,
            };
        },
        processResults: function(returnedData) {
            var mappedData = $.map(returnedData.data, function(fetch) {
                return {
                    id: fetch.id,
                    text: fetch.category
                };
            });
            return {
                results: mappedData
            };
        },
        cache: true
    },
    minimumInputLength: 0,
    templateResult: formatCategory,
    templateSelection: formatCategorySelection
});

function formatCategory(category) {
    if (!category.id) {
        return category.text;
    }
    var $category = $(
        '<span>' + category.text + '</span>'
    );
    return $category;
}

function formatCategorySelection(category) {
    return category.text;
}

$("select.book2").select2({
    placeholder: "Sub Asset",
    theme:"bootstrap4",
    ajax: {
        url: 'fetch1.php',
        dataType: 'json',
        type: 'POST',
        delay: 250,
        data: function(params) {
            return {
                term: params.term,
                fetch8: true,
            };
        },
        processResults: function(returnedData) {
            var mappedData = $.map(returnedData.data, function(fetch) {
                return {
                    id: fetch.id,
                    text: fetch.sub_category
                };
            });
            return {
                results: mappedData
            };
        },
        cache: true
    },
    minimumInputLength: 0,
    templateResult: formatCategory,
    templateSelection: formatCategorySelection
});

function formatCategory(category) {
    if (!category.id) {
        return category.text;
    }
    var $category = $(
        '<span>' + category.text + '</span>'
    );
    return $category;
}

function formatCategorySelection(category) {
    return category.text;
}





$("select.others1").select2({
    theme:"bootstrap4",
    placeholder: "Asset Type",
    ajax: {
        url: 'fetch1.php',
        dataType: 'json',
        type: 'POST',
        delay: 250,
        data: function(params) {
            return {
                term: params.term,
                fetch9: true,
            };
        },
        processResults: function(returnedData) {
            var mappedData = $.map(returnedData.data, function(fetch) {
                return {
                    id: fetch.id,
                    text: fetch.category
                };
            });
            return {
                results: mappedData
            };
        },
        cache: true
    },
    minimumInputLength: 0,
    templateResult: formatCategory,
    templateSelection: formatCategorySelection
});

function formatCategory(category) {
    if (!category.id) {
        return category.text;
    }
    var $category = $(
        '<span>' + category.text + '</span>'
    );
    return $category;
}

function formatCategorySelection(category) {
    return category.text;
}

$("select.others2").select2({
    placeholder: "Sub Asset",
    theme:"bootstrap4",
    ajax: {
        url: 'fetch1.php',
        dataType: 'json',
        type: 'POST',
        delay: 250,
        data: function(params) {
            return {
                term: params.term,
                fetch10: true,
            };
        },
        processResults: function(returnedData) {
            var mappedData = $.map(returnedData.data, function(fetch) {
                return {
                    id: fetch.id,
                    text: fetch.sub_category
                };
            });
            return {
                results: mappedData
            };
        },
        cache: true
    },
    minimumInputLength: 0,
    templateResult: formatCategory,
    templateSelection: formatCategorySelection
});

function formatCategory(category) {
    if (!category.id) {
        return category.text;
    }
    var $category = $(
        '<span>' + category.text + '</span>'
    );
    return $category;
}

function formatCategorySelection(category) {
    return category.text;
}




    
document.addEventListener('DOMContentLoaded', function () {
    var currentLocation = location.href;
    var menuItem = document.querySelectorAll('#sidebarNav .nav-link');
    var menuLength = menuItem.length;
    for (var i = 0; i < menuLength; i++) {
      if (menuItem[i].href === currentLocation) {
        menuItem[i].classList.add('active');
        if (menuItem[i].closest('.nav-treeview')) {
          menuItem[i].closest('.nav-treeview').parentNode.querySelector('.nav-link').classList.add('active');
        }
      }
    }
  });






$(document).ready(function() {
    $("button.save_asset").on("click", function(event) {
        event.preventDefault();
  
        var requiredFilled = true;
        $("#save_asset input, #save_asset select").each(function() {
            if ($(this).prop("required")) {
                if ($(this).is('select') && $(this).val() === null) {
                    requiredFilled = false;
                    $(this).addClass("is-invalid");
                } else if ($(this).val() === "") {
                    requiredFilled = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            }
        });
  
        if (requiredFilled) {
            $.ajax({
                url: "save_function.php",
                type: "POST",
                data: $("#save_asset").serialize() + "&save_asset=true",
                success: function(response) {
                    try {
                        response = JSON.parse(response);
                        if (response.success = 1) {
                            Swal.fire({
                                icon: "success",
                                title: "Asset Successfully Saved!",
                                showConfirmButton: true
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: response.error || "An unknown error occurred."
                            });
                        }
                    } catch (e) {
                        Swal.fire({
                            title: "Error!",
                            text: "Failed to parse JSON response: " + e,
                            icon: "error"
                        });
                    }
                },
            });
        }
    });
});



$(document).ready(function() {
    $("button.save_asset_school").on("click", function(event) {
        event.preventDefault();
  
        var requiredFilled = true;
        $("#save_asset input, #save_asset select").each(function() {
            if ($(this).prop("required")) {
                if ($(this).is('select') && $(this).val() === null) {
                    requiredFilled = false;
                    $(this).addClass("is-invalid");
                } else if ($(this).val() === "") {
                    requiredFilled = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            }
        });
  
        if (requiredFilled) {
            $.ajax({
                url: "../save_function.php",
                type: "POST",
                data: $("#save_asset").serialize() + "&save_asset=true",
                success: function(response) {
                    try {
                        response = JSON.parse(response);
                        if (response.success = 1) {
                            Swal.fire({
                                icon: "success",
                                title: "Asset Successfully Saved!",
                                showConfirmButton: true
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: response.error || "An unknown error occurred."
                            });
                        }
                    } catch (e) {
                        Swal.fire({
                            title: "Error!",
                            text: "Failed to parse JSON response: " + e,
                            icon: "error"
                        });
                    }
                },
            });
        }
    });
});



$(document).ready(function () {
    $("button.savecategory").on("click", function (event) {
        event.preventDefault();

        let fileInput = document.querySelector("#addcategory input[type='file']");
        if (fileInput.files.length === 0) {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "Please select a file to upload."
            });
            return;
        }

        let file = fileInput.files[0];
        let reader = new FileReader();

        reader.onload = function (e) {
            let data = new Uint8Array(e.target.result);
            let workbook = XLSX.read(data, { type: 'array' });
            let sheetName = workbook.SheetNames[0];
            let worksheet = workbook.Sheets[sheetName];
            let rows = XLSX.utils.sheet_to_json(worksheet, { header: 1 });

     
            let asset = $("select.selectasset").val();
            let payload = { asset: asset, rows: rows };
            $.ajax({
                url: "save_cat.php",
                type: "POST",
                data: JSON.stringify(payload),
                success: function(response) {
                    try {
                        response = typeof response === "string" ? JSON.parse(response) : response;
                        if (response.success === 1){
                            Swal.fire({
                                icon: "success",
                                title: "Asset Successfully Saved!",
                                showConfirmButton: true
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: response.error || "An unknown error occurred."
                            });
                        }
                    } catch (e) {
                        Swal.fire({
                            icon: "error",
                            title: "Error! " + e,
                            showConfirmButton: true
                        });
                    }
                },
            });
        };

        reader.onerror = function () {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "Failed to read the file. Please try again."
            });
        };

        reader.readAsArrayBuffer(file);
    });
});



$(document).ready(function() {
    $("button.save_asset1").on("click", function(event) {
        event.preventDefault();
  
        var requiredFilled = true;
        $("#save_asset input, #save_asset select").each(function() {
            if ($(this).prop("required")) {
                if ($(this).is('select') && $(this).val() === null) {
                    requiredFilled = false;
                    $(this).addClass("is-invalid");
                } else if ($(this).val() === "") {
                    requiredFilled = false;
                    $(this).addClass("is-invalid");
                } else {
                    $(this).removeClass("is-invalid");
                }
            }
        });
  
        if (requiredFilled) {
            $.ajax({
                url: "save_function.php",
                type: "POST",
                data: $("#save_asset").serialize() + "&save_asset=true",
                success: function(response) {
                    try {
                        response = JSON.parse(response);
                        if (response.success = 1) {
                            Swal.fire({
                                icon: "success",
                                title: "Asset Successfully Saved!",
                                showConfirmButton: true
                            }).then(() => {
                                $("#save_asset")[0].reset(); 

                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: response.error || "An unknown error occurred."
                            });
                        }
                    } catch (e) {
                        Swal.fire({
                            title: "Error!",
                            text: "Failed to parse JSON response: " + e,
                            icon: "error"
                        });
                    }
                },
            });
        }
    });
});


$(document).ready(function() {
    // Initialize Select2
    $("select.schools").select2({
        placeholder: "Select Schools",
        theme: "bootstrap4",
        ajax: {
            url: 'fetch1.php',
            dataType: 'json',
            type: 'POST',
            delay: 250,
            data: function(params) {
                return {
                    term: params.term,
                    select_Schools: true,
                };
            },
            processResults: function(returnedData) {
                var mappedData = $.map(returnedData.results, function(fetch) {
                    return {
                        id: fetch.id,
                        text: fetch.office_name +' '+ ('(' + fetch.office_id +')')
                    };
                });
                return {
                    results: mappedData
                };
            },
            cache: true
        }
    }).on('select2:select', function(e) {
        var selectedOfficeId = e.params.data.id;
        var selectedOfficeName = e.params.data.text;
        var selectedOfficeName4 = e.params.data.text;
        var selectedOfficeName1 = e.params.data.text;
        var selectedOfficeName2 = e.params.data.text;
        var selectedOfficeName3 = e.params.data.text;
        var selectedOfficeNameL = e.params.data.text;
        var selectedOfficeNameg = e.params.data.text;
        $("#selectedOfficeId").val(selectedOfficeId); 
        $("#selectedOfficeId1").val(selectedOfficeId); 
        $("select.accountable").data("selectedOfficeId", selectedOfficeId);
        fetchData(selectedOfficeId);
        console.log(selectedOfficeId);
        $("#school_name").text("of " + selectedOfficeName);
        $("#selected_school").text("School Name: "+"("+ selectedOfficeName1 +")");
        $("#selected_school1").text("School Name: "+"("+ selectedOfficeNameL +")");
        $("#school_name1").text("of " + selectedOfficeName2);
        $("#school_name2").text("of " + selectedOfficeName3);
        $("#school_name3").text("of " + selectedOfficeName4);
        $("#graph_school_name").text("Data of " + selectedOfficeNameg);

        // Store the selected school ID in localStorage, scoped by user ID
        localStorage.setItem(`selectedSchoolId_${userId}`, selectedOfficeId);
        localStorage.setItem(`selectedSchoolName_${userId}`, selectedOfficeName);
    });

    // Retrieve the selected school ID from localStorage, scoped by user ID
    var selectedSchoolId = localStorage.getItem(`selectedSchoolId_${userId}`);
    var selectedSchoolName = localStorage.getItem(`selectedSchoolName_${userId}`);

    if (selectedSchoolId) {
        // Pre-select the stored school in the dropdown
        var option = new Option(selectedSchoolName, selectedSchoolId, true, true);
        $("select.schools").append(option).trigger('change');

        $("select.schools").trigger({
            type: 'select2:select',
            params: {
                data: {
                    id: selectedSchoolId,
                    text: selectedSchoolName
                }
            }
        });
    }
});



function fetchData(selectedOfficeId) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'chartfunction.php', true); 
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            var data = JSON.parse(xhr.responseText);
            updateChart('aoassetchart', data); 
        } 
    };
    xhr.onerror = function() {
        console.error('Failed to fetch data');
    };
    xhr.send("selectedOfficeId=" + selectedOfficeId);
}



$("select.accountable").select2({
    placeholder: "Select Accountable",
    theme: "bootstrap4",
    dropdownParent: $("#exampleModal1"),
    ajax: {
        url: 'fetch1.php',
        dataType: 'json',
        type: 'POST',
        delay: 250,
        data: function(params) {
            return {
                term: params.term, 
                accountable_Employee: true, 
            };
        },
        processResults: function(returnedData) {
   
            var mappedData = $.map(returnedData.result, function(fetch) {
                return {
                    id: fetch.hris_code, 
                    text: fetch.employee 
                };
            });
       
            return {
                results: mappedData
            };
        },
        cache: true
    }
});

$("select.schools").on('select2:select', function(e) {
    var selectedSchool = e.params.data.id;  

    if (selectedSchool) {
        $("#addAssetBtn").prop('disabled', false);
        $("#addAssetBtn1").prop('disabled', false);
    } else {
        $("#addAssetBtn").prop('disabled', true);
        $("#addAssetBtn1").prop('disabled', true);
    }
});



$("#addAssetBtn").on('mouseover', function() {
    if ($(this).prop('disabled')) {
        toastr.error("Please select a school first.");
    }
});

$("#addAssetBtn1").on('mouseover', function() {
    if ($(this).prop('disabled')) {
        toastr.error("Please select a school first.");
    }
});



$(document).ready(function() {
    var table = $('#historical').DataTable({
        dropdownParent: $("#editModalAo"),
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dom: 'lBfrtip',
        buttons: [
            "copy", 
            "csv", 
            "excel", 
            {
                extend: 'print',
                customize: function(win) {
                    $(win.document.body).css('font-size', '10pt');
                    $(win.document.body).find('table')
                        .before('<h1 style="text-align:center;">Report on Other Property Plants and Equipment</h1>'+
                                 '<p style="text-align:center;">___________________________________</p>'+
                                 '<p style="text-align:center; margin-top:-1em">(Type of Inventory Item)</p>'+
                                 '<p style="text-align:center; margin-top:-1em">As at June, 2023</p>'+
                                 '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                                 '<p><b>For which _______________________________,_______________________________,_______________________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                    $(win.document.body).find('table')
                        .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                            '<tr>' +
                            '<td style="width:30%;">Certified Corrected by:____________________________<br><span style="font-weight:bold; margin-top:-1em; margin-left:5.5em;"><b>Signature over Printed Name of Inventory <span style="margin-left:5.5em;"> Commitee Chair and Members</b></span></span></td>' +
                            '<td style="width:30%;">Approved by:_____________________________<br><span style="font-weight:bold; margin-top:-1em; margin-left:5.5em;"><b>Signature over Printed Name of Head of <span style="margin-left:5.5em;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                            '<td style="width:30%;">Verified by:____________________________<br><span style="font-weight:bold; margin-top:-1em; margin-left:6em; justify-content:center; align-items:center;"><b>Signature over Printed Name of COA <span  style="margin-left:5.5em;">Representative</span></b></span></td>' +
                            '</tr>' +
                            '</table>');
                },
                orientation: 'landscape'
            }
        ],
        ajax: {
            url: "getdata.php",
            type: "post",
            data: {historical: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#historical').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: 'getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                
                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                $("#asset").append(assetOption).trigger("change");
                var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                $("#subasset").append(subOption).trigger("change");
                $('#modal-input1').val(data[0].description);
                $('#modal-input2').val(data[0].property_no);
                $('#modal-input3').val(data[0].unit_meas);
                $('#modal-input4').val(data[0].unit_val);
                $('#modal-input5').val(data[0].qty_property_card);
                $('#modal-input6').val(data[0].qty_physical_count);
                $('#modal-input7').val(data[0].shortage_qty);
                $('#modal-input8').val(data[0].shortage_value);
                var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                $('select.edit_personnel').append(officerOption).trigger('change');
                $('#modal-input10').val(data[0].remarks);


               
                $('#editmodalbuild1').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: 'function.php',
                        type: 'POST',
                        data: {
                            updatebuild1: true,
                            id: id,
                            asset: $('#asset').val(),
                                subasset: $('#subasset').val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editmodalbuild1').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file. Select Personnel',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});



    $('#historical').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'function.php',
                    type: 'POST',
                    data: {
                        historicaldel: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });
});


$("select.select_account").select2({
    placeholder: "Select Accountable",
    theme: "bootstrap4",
    dropdownParent: $("#exampleModal1"),
    ajax: {
        url: 'fetch1.php',
        dataType: 'json',
        type: 'POST',
        delay: 250,
        data: function(params) {
            return {
                term: params.term,
                accountable_Employee: true,
            };
        },
        processResults: function(returned) {
            var mappedData = $.map(returned.result, function(fetch) {
                return {
                    id: fetch.hris_code,
                    text: fetch.employee + " - (" + fetch.office_name + ")"
                };
            });
            return {
                results: mappedData
            };
        },
        cache: true
    },
    minimumInputLength: 0
});


$("select.select_account_school").select2({
    placeholder: "Select Accountable",
    theme: "bootstrap4",
    dropdownParent: $("#exampleModal1"),
    ajax: {
        url: '../fetch1.php',
        dataType: 'json',
        type: 'POST',
        delay: 250,
        data: function(params) {
            return {
                term: params.term,
                accountable_Employee: true,
            };
        },
        processResults: function(returned) {
            var mappedData = $.map(returned.result, function(fetch) {
                return {
                    id: fetch.hris_code,
                    text: fetch.employee + ' - (' + fetch.office_name + ')'
                };
            });
            return {
                results: mappedData
            };
        },
        cache: true
    },
    minimumInputLength: 0
});


$("select.edit_personnel").select2({
    placeholder: "Select Accountable",
    theme: "bootstrap4",
    dropdownParent: $("#editmodalbuild1"),
    ajax: {
        url: 'fetch1.php',
        dataType: 'json',
        type: 'POST',
        delay: 250,
        data: function(params) {
            return {
                term: params.term, 
                accountable_Employee: true, 
            };
        },
        processResults: function(returnedData) {
   
            var mappedData = $.map(returnedData.result, function(fetch) {
                return {
                    id: fetch.hris_code, 
                    text: fetch.employee + ' - (' + fetch.office_name + ')',
                };
            });
       
            return {
                results: mappedData
            };
        },
        cache: true
    }
});




$("select.edit_personnel_school").select2({
    placeholder: "Select Accountable",
    theme: "bootstrap4",
    dropdownParent: $("#editModal"),
    ajax: {
        url: '../fetch1.php',
        dataType: 'json',
        type: 'POST',
        delay: 250,
        data: function(params) {
            return {
                term: params.term, 
                accountable_Employee: true, 
            };
        },
        processResults: function(returnedData) {
   
            var mappedData = $.map(returnedData.result, function(fetch) {
                return {
                    id: fetch.hris_code, 
                    text: fetch.employee + ' - (' + fetch.office_name + ')'
                };
            });
       
            return {
                results: mappedData
            };
        },
        cache: true
    }
});


$(document).ready(function () {
    var table = $('#fundSourceTable').DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        columns: [
            { "data": "description" },
            { "data": "property_no" },
            { "data": "unit_meas" },
            { 
                "data": "unit_val", 
                "render": function (data) {
                    return '₱' + data;
                } 
            },
            { "data": "qty_property_card" },
            { "data": "qty_physical_count" },
            { "data": "shortage_qty" },
            { "data": "shortage_value" },
            { "data": "date_acquired" },
            { "data": "remarks" },
            { "data": "fullname" },
        ],
    });


    function initializeButtonState() {
        const newDataAvailable = localStorage.getItem("newDataAvailable");
        if (newDataAvailable === "true") {
            $("#notificationButton").removeClass("btn-secondary").addClass("btn-primary").prop("disabled", false);
        } else {
            $("#notificationButton").removeClass("btn-primary").addClass("btn-secondary").prop("disabled", true);
        }
    }

    initializeButtonState();

    function fetchNewData() {
        $.ajax({
            url: 'getnewdata.php',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.data) {
                    table.clear().draw();
                    table.rows.add(response.data).draw();
                    markNotificationsViewed();
                } else {
                    console.error("Error fetching new data:", response.error);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching new data:", error);
            }
        });
    }

    function markNotificationsViewed() {
        $.post('marknotification.php', function () {
            $("#notificationButton")
                .removeClass("btn-primary")
                .addClass("btn-secondary")
                .prop("disabled", true);

            // Update localStorage to reflect no new data
            localStorage.setItem("newDataAvailable", "false");
        }).fail(function (xhr, status, error) {
            console.error("Error marking notifications as viewed:", error);
        });
    }

    function checkForNewData() {
        $.get('checknewData.php', function (response) {
            if (response.newData) {
                $("#notificationButton")
                    .removeClass("btn-secondary")
                    .addClass("btn-primary")
                    .prop("disabled", false);

                // Update localStorage to reflect new data available
                localStorage.setItem("newDataAvailable", "true");
            }
        }, 'json').fail(function (xhr, status, error) {
            console.error("Error checking for new data:", error);
        });
    }

    $("#notificationButton").on("click", function () {
        if (!$(this).prop("disabled")) {
            fetchNewData();
            $("#fundSourceModal").modal("show");
        }
    });


    setInterval(checkForNewData, 3600000);
});




$("select.packages").select2({
    theme: "bootstrap4",
    placeholder: "Select Package",
    ajax: {
        url: 'fetch1.php',
        dataType: 'json',
        type: 'POST',
        delay: 250,
        data: function(params) {
            return {
                term: params.term,
                packages: true,
            };
        },
        processResults: function(returnedData) {
            var mappedData = $.map(returnedData.data, function(fetch) {
                return {
                    id: fetch.id,
                    text: fetch.package_name
                };
            });
            return {
                results: mappedData
            };
        },
        cache: true
    },
    minimumInputLength: 0,
    templateResult: formatCategory,
    templateSelection: formatCategorySelection
});

function formatCategory(package_name) {
    if (!package_name.id) {
        return package_name.text;
    }
    var $package_name = $('<span>' + package_name.text + '</span>');
    return $package_name;
}

function formatCategorySelection(package_name) {
    return package_name.text;
}

$(document).ready(function() {

    function populateDcpBatch() {
        var currentYear = new Date().getFullYear(); 
        var startYear = 2010; 
        var $dcpBatchSelect = $('#dcp_batch');


        $dcpBatchSelect.empty();


        for (var year = startYear; year <= currentYear; year++) {
            $dcpBatchSelect.append($('<option></option>').val(year).html('Batch ' + year));
        }
    }

    populateDcpBatch();

    $('#dcp_batch').hide();

    $('select[name="packages"]').change(function() {
        var selectedValue = $(this).val();

        if (selectedValue === '1') {
            $('#dcp_batch').show();
        } else {
            dcp_batch = null;
            $('#dcp_batch').hide();
        }
    });
});



//AO_ACCOUNT

$(document).ready(function() {
    if ($('#brand').length && $('#model').length && $('#sn').length) {
        $('#model').show();
        $('#brand').show();
        $('#sn').show();
        $('#b1').hide();
        $('#b2').hide();
        $('#b3').hide();
        $('#b4').hide();
    }

    $('select[name="select1"]').change(function() {
        var selectedValue = $(this).val();

        if (selectedValue === '1') {
            if ($('#model').length) {
                $('#model').hide();
                $('#brand').hide();
                $('#sn').hide();
                $('#b1').show();
                $('#b2').show();
                $('#b3').show();
                $('#b4').show();
                $('#h1').hide();
                $('#h2').hide();
                $('#h3').hide();
                $('#h4').hide();
            }
        } else {
            if ($('#brand').length && $('#model').length) {
                $('#model').show();
                $('#brand').show();
                $('#sn').show();
                $('#b1').hide();
                $('#b2').hide();
                $('#b3').hide();
                $('#b4').hide();
                $('#h1').show();
                $('#h2').show();
                $('#h3').show();
                $('#h4').show();
            }
        }
    });
});



$(document).ready(function() {

    if ($('#quantity').length && $('#quantity').length) {
        $('#quantity').hide();
        $('#supplier').hide();
    }

    $('select[name="select1"]').change(function() {
        var selectedValue = $(this).val();

        if (selectedValue === '7' || selectedValue === '8') {
            if ($('#quantity').length) {

                $('#quantity').show();
                $('#supplier').show();
            }
        } else {
            if ($('#quantity').length) {

                $('#quantity').hide();
                $('#supplier').hide();
            }
        }
    });


   
       
        $('#quantity').on('input', function () {
            var quantity = $(this).val().trim(); 
            var selectedSubCategoryId = $('select[name="select2"]').val();
    
            if (quantity && selectedSubCategoryId) {
                $.ajax({
                    url: 'fetch1.php',
                    method: 'GET',
                    data: {
                        se_price: true,
                        sub_category_id: selectedSubCategoryId
                    },
                    success: function (response) {
                        try {
                            var parsedResponse = JSON.parse(response);
    
                            if (parsedResponse.data && parsedResponse.data.length > 0) {
                                var price = parsedResponse.data[0].price;
                                var totalPrice = quantity * price; 

                                $('#unit_value').val(totalPrice.toFixed(2)); 
                            } else {
                                $('#unit_value').val(''); 
                                console.warn('No price data found for the selected sub-category.');
                            }
                        } catch (e) {
                            console.error('Error parsing response:', e);
                            $('#unit_value').val(''); 
                        }
                    },
                    error: function () {
                        console.error('Error fetching price.');
                        $('#unit_value').val(''); 
                    }
                });
            } else {
                $('#unit_value').val('');
            }
            }
        
        );
        });

        document.addEventListener('DOMContentLoaded', function () {
            var currentLocation = location.href;
            var menuItem = document.querySelectorAll('#sidebarNav1 .nav-link');
            var menuLength = menuItem.length;
            for (var i = 0; i < menuLength; i++) {
              if (menuItem[i].href === currentLocation) {
                menuItem[i].classList.add('active');
              }
            }
          });



          $(document).ready(function() {
            var table = $('#show_ao_land').DataTable({
                dropdownParent: $("#editModalAo"),
                serverSide: true,
                responsive: true,
                lengthChange: false,
                autoWidth: true,
                dom: 'lBfrtip',
                buttons: [
                "copy",
                "csv",
                "excel", {
                    extend: 'print',
                    customize: function(win) {
                        $(win.document.body).css('font-size', '10pt');
                        $(win.document.body).find('table')
                            .before('<h1 style="text-align:center;">REPORT ON THE LAND/h1>'+
                                     '<p style="text-align:center;">___________________________________</p>'+
                                     '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                                     '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                                     '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                        $(win.document.body).find('table')
                            .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                                '<tr>' +
                                '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                                '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                                '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                                '</tr>' +
                                '</table>');
                    },
                    orientation: 'landscape',
               
                    //    exportOptions: {
                    //  columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
                    // }
        
               
                     }
            ],
                ajax: {
                    url: "getdata.php",
                    type: "post",
                    data: function (d) {
                        d.ao_land = true;
                        d.selectedOfficeId = $("#school").val(); 
                    },
                   
                    error: function(thrown) {
                        console.log("Ajax request failed: " + thrown);
                    }
                },
                columns: [
                    {
                        "data": "description",
                    },
                    {"data": "property_no"},
                    {"data": "remarks"},
                    { "data": "unit_val", 
                  "render": function(data, type, row) {
                      return '₱' + data;
                  } },
                    {"data": "date_titled"},
                    {"data": "date_acquired"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
                ],
                // lengthMenu: [
                //     [10, 25, 50, 100000000],
                //     [10, 25, 50, 'ALL']
                // ],
                drawCallback: function () {
                    var api = this.api();
                    var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                        return a + parseFloat(b);
                    }, 0);
                    $('#totalUnitMeas1').html('Total: ₱' + total.toFixed(2));
                },
                
            });
            $("#school").change(function() {
                table.ajax.reload();
            });


            $('#show_ao_land').on('click', '.update-btn', function() {
                var id = $(this).data('update');
                $.ajax({
                    url: 'getdata.php',
                    type: 'POST',
                    data: {
                        getdata_ao_land: true,
                        id: id
                    },
                     success: function(response) {
                            if (response.trim() !== "") {
                                var data = JSON.parse(response);
                                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                                $("#asset_id").append(assetOption).trigger("change");
                                $('#description').val(data[0].description);
                                $('#property_no').val(data[0].property_no);
                                $('#modal-input3').val(data[0].unit_meas);
                                $('#modal-input4').val(data[0].unit_val);
                                $('#modal-input5').val(data[0].qty_property_card);
                                $('#modal-input6').val(data[0].qty_physical_count);
                                $('#modal-input7').val(data[0].shortage_qty);
                                $('#modal-input8').val(data[0].shortage_value);
                                $('select.accountable_edit').val(data[0].fullname).trigger('change');
                                $('#modal-input10').val(data[0].remarks);
                
                               
                                $('#editModallandAo').modal('show');
                               
                                $('#saveChanges').off('click').on('click', function() {
                                    $.ajax({
                                        url: 'function.php',
                                        type: 'POST',
                                        data: {
                                            update_ao: true,
                                            id: id,
                                       
                                            description: $('#modal-input1').val(),
                                            property_no: $('#modal-input2').val(),
                                            unit_meas: $('#modal-input3').val(),
                                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                                            qty_property_card: $('#modal-input5').val(),
                                            qty_physical_count: $('#modal-input6').val(),
                                            shortage_qty: $('#modal-input7').val(),
                                            shortage_value: $('#modal-input8').val(),
                                            account_officer: $('select.accountable_edit').val(),
                                            remarks: $('#modal-input10').val(),
                                        },
                                        success: function(response) {
                                            if (response.trim() === "Updated Successfully") {
                                                $('#editModalAo').modal('hide');
                                                Swal.fire(
                                                    'Updated!',
                                                    'File has been updated successfully.',
                                                    'success'
                                                );
                                                table.ajax.reload();
                                            } else {
                                                Swal.fire(
                                                    'Failed!',
                                                    'Failed to update file.',
                                                    'error'
                                                );
                                            }
                                        },
                                    });
                                });
                            }
                        },
                    });
                });
                
            
                $('#show_ao_land').on('click', '.delete-btn', function() {
                    var id = $(this).data('delete');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to delete it?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: 'function.php',
                                type: 'POST',
                                data: {
                                    delete: true,
                                    id: id
                                },
                                success: function(response) {
                                    if (response.trim() === "Deleted Successfully") {
                                        Swal.fire(
                                            'Deleted!',
                                            'File has been deleted successfully.',
                                            'success'
                                        );
                                        table.ajax.reload();
                                    } else {
                                        Swal.fire(
                                            'Failed!',
                                            'Failed to delete file.',
                                            'error'
                                        );
                                    }
                                },
                            });
                        }
                    });
                });
            
            });


         
            $(document).ready(function() {
                $("select.sort_ao").select2({
                    placeholder: "Sort by:",
                    theme:"bootstrap4",
                    
                    ajax: {
                        url: 'fetch1.php',
                        dataType: 'json',
                        type: 'POST',
                        delay: 250,
                        data: function(params) {
                            return {
                                term: params.term,
                                category: true,
                            };
                        },
                        processResults: function(returnedData) {
                            var mappedData = $.map(returnedData.data, function(fetch) {
                                return {
                                    id: fetch.id,
                                    text: fetch.sub_category
                                };
                            });
                            return {
                                results: mappedData
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 0,
                    templateResult: formatCategory,
                    templateSelection: formatCategorySelection
                });
                });
                
          $(document).ready(function() {
            var table = $('#show_ao_entry').DataTable({
                dropdownParent: $("#editModalAo"),
                serverSide: true,
                responsive: true,
                lengthChange: false,
                autoWidth: true,
                dom: 'lBfrtip',
                buttons: [
                "copy",
                "csv",
                "excel", {
                    extend: 'print',
                    customize: function(win) {
                        $(win.document.body).css('font-size', '10pt');
                        $(win.document.body).find('table')
                            .before('<h1 style="text-align:center;">REPORT ON THE OFFICE EQUIPMENT</h1>'+
                                     '<p style="text-align:center;">___________________________________</p>'+
                                     '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                                     '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                                     '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                        $(win.document.body).find('table')
                            .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                                '<tr>' +
                                '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                                '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                                '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                                '</tr>' +
                                '</table>');
                    },
                    orientation: 'landscape',
               
                       exportOptions: {
                     columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
                    }
        
               
                     }
            ],
                ajax: {
                    url: "getdata.php",
                    type: "post",
                    data: function (d) {
                        d.ao_user_data = true;
                        d.selectedOfficeId = $("select.schools").val(); 
                        d.sortby = $("select.sort_ao").val(); 
                    },
                    error: function(thrown) {
                        console.log("Ajax request failed: " + thrown);
                    }
                },
                columns: [
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<div class="row">' + 
                                       '<div class="col">' + row.description +
                                           '<strong>Model:</strong> ' + row.model +
                                       '</div>' +
                                       '<div class="col">' +
                                           '<strong>SN:</strong> ' + row.asset_sn +
                                       '</div>' +
                                   '</div>';
                        }
                    },
                    {"data": "property_no"},
                    {"data": "unit_meas"},
                    { "data": "unit_val", 
                  "render": function(data, type, row) {
                      return '₱' + data;
                  } },
                    {"data": "qty_property_card"},
                    {"data": "qty_physical_count"},
                    {"data": "shortage_qty"},
                    {"data": "shortage_value"},
                    {"data": "date_acquired"},
                    {"data": "remarks"},
                    {"data": "fullname"},
                            {
                                "data": null,
                                "render": function(data, type, row) {
                                    return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                            '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                        }   
                    },
                ],
                lengthMenu: [
                    [10, 25, 50, 100000000],
                    [10, 25, 50, 'ALL']
                ],
                drawCallback: function () {
                    var api = this.api();
                    var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                        return a + parseFloat(b);
                    }, 0);
                    $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
                },
            });

            $("select.schools, select.sort_ao").on('change', function () {
                var selectedCategoryId = $('select.selectedCategoryId').val();
                var sortby = $('select.sort_ao').val();
        
              
                table.ajax.url('getdata.php?ao_user_data=true&selectedOfficeId=' + selectedCategoryId +  'sortby' + sortby).load();
            });
        
        
        $('#show_ao_entry').on('click', '.update-btn', function() {
            var id = $(this).data('update');
            $.ajax({
                url: 'getdata.php',
                type: 'POST',
                data: {
                    getdata_ao: true,
                    id: id
                },
                 success: function(response) {
                        if (response.trim() !== "") {
                            var data = JSON.parse(response);

                            var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                            $("#asset_id").append(assetOption).trigger("change");
                        
                            var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                            $("#sub_id").append(subOption).trigger("change");
                            $('#article').val(data[0].article_id);
                            $('#type').val(data[0].asset_type);
                            $('#modal-input1').val(data[0].description);
                            $('#modal-input2').val(data[0].property_no);
                            $('#modal-input3').val(data[0].unit_meas);
                            $('#modal-input4').val(data[0].unit_val);
                            $('#modal-input5').val(data[0].qty_property_card);
                            $('#modal-input6').val(data[0].qty_physical_count);
                            $('#modal-input7').val(data[0].shortage_qty);
                            $('#modal-input8').val(data[0].shortage_value);
                            $('#fund').val(data[0].fund_source);
                            $('#useful_life').val(data[0].useful_life);
                            var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                            $('select.accountable_edit').append(officerOption).trigger('change');
                            $('#modal-input10').val(data[0].remarks);
                            $('#date_ao').val(data[0].date_acquired);
            
                           
                            $('#editModalAo').modal('show');
                           
                            $('#saveChanges').off('click').on('click', function() {
                                $.ajax({
                                    url: 'function.php',
                                    type: 'POST',
                                    data: {
                                        update_ao: true,
                                        id: id,
                                        asset_id: $("#asset_id").val(), 
                                        asset_subid: $("#sub_id").val(), 
                                        // sub_id: $("#sub_id").val(),
                                        article: $('#article').val(),
                                        type: $('#type').val(),
                                        description: $('#modal-input1').val(),
                                        property_no: $('#modal-input2').val(),
                                        unit_meas: $('#modal-input3').val(),
                                        unit_val: $('#modal-input4').val().replace('₱', ''), 
                                        qty_property_card: $('#modal-input5').val(),
                                        qty_physical_count: $('#modal-input6').val(),
                                        shortage_qty: $('#modal-input7').val(),
                                        shortage_value: $('#modal-input8').val(),
                                        fund_source: $('#fund').val(),
                                        useful_life: $('#useful_life').val(),
                                        account_officer: $('select.accountable_edit').val(),
                                        remarks: $('#modal-input10').val(),
                                        date_ao: $('#date_ao').val(),
                                    },
                                    success: function(response) {
                                        if (response.trim() === "Updated Successfully") {
                                            $('#editModalAo').modal('hide');
                                            Swal.fire(
                                                'Updated!',
                                                'File has been updated successfully.',
                                                'success'
                                            );
                                            table.ajax.reload();
                                        } else {
                                            Swal.fire(
                                                'Failed!',
                                                'Failed to update file.',
                                                'error'
                                            );
                                        }
                                    },
                                });
                            });
                        }
                    },
                });
            });
            
        
            $('#show_ao_entry').on('click', '.delete-btn', function() {
                var id = $(this).data('delete');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete it?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'function.php',
                            type: 'POST',
                            data: {
                                delete: true,
                                id: id
                            },
                            success: function(response) {
                                if (response.trim() === "Deleted Successfully") {
                                    Swal.fire(
                                        'Deleted!',
                                        'File has been deleted successfully.',
                                        'success'
                                    );
                                    table.ajax.reload();
                                } else {
                                    Swal.fire(
                                        'Failed!',
                                        'Failed to delete file.',
                                        'error'
                                    );
                                }
                            },
                        });
                    }
                });
            });
        
        });
        

        
        $(document).ready(function() {
            $("select.accountable_edit").select2({
                placeholder: "Select Accountable",
                theme: "bootstrap4",
                dropdownParent: $("#editModalAo"),
                ajax: {
                    url: 'fetch1.php',
                    dataType: 'json',
                    type: 'POST',
                    delay: 250,
                    data: function(params) {
                        var selectedOfficeId = $("select.accountable").data("selectedOfficeId");  
                        return {
                            term: params.term,
                            accountable_personnel: true,
                            selectedOfficeId: selectedOfficeId  
                        };
                    },
                    processResults: function(returnedData) {
                        var mappedData = $.map(returnedData.results, function(fetch) {
                            return {
                                id: fetch.hris_code,
                                text: fetch.employee + ' -(' + fetch.office_name + ')'
                            };
                        });
                        return {
                            results: mappedData
                        };
                    },
                    cache: true
                }
            });
        });



        $(document).ready(function () {
            $("#asset_id").select2({
              placeholder: "Select Asset Type",
              theme: "bootstrap4",
                dropdownParent: $("#editModalAo"),
                ajax: {
                    url: 'fetch1.php',
                    dataType: 'json',
                    type: 'POST',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term,
                            asset1: true,
                            category_id: params.term 
                        };
                    },
                    processResults: function(returnedData) {
                        var mappedData = $.map(returnedData.data, function(fetch) {
                            return {
                                id: fetch.id,
                                text: fetch.category
                            };
                        });
                        return {
                            results: mappedData
                        };
                    },
                    cache: true
                },
            });

          

            $("#sub_id").select2({
              placeholder: "Select Sub Asset",
              theme: "bootstrap4",
              dropdownParent: $("#editModalAo"),
              ajax: {
                url: 'fetch1.php',
                dataType: 'json',
                type: 'POST',
                delay: 250,
                data: function(params) {
                    var selectedCategoryId = $('#asset_id').val(); 
                    return {
                        term: params.term,
                        asset2: true,
                        category_id: selectedCategoryId 
                    };
                },
                processResults: function(returnedData) {
                    var mappedData = $.map(returnedData.data, function(fetch) {
                        return {
                            id: fetch.id,
                            text: fetch.sub_category
                        };
                    });
                    return {
                        results: mappedData
                    };
                },
                cache: true
            },
            minimumInputLength: 0,
            templateResult: formatCategory,
            templateSelection: formatCategorySelection
        });
          
            $("#asset_id").on("change", function () {
              $("#sub_id").val(null).trigger("change"); 
            });
          });





          $(document).ready(function () {
            $("#asset").select2({
              placeholder: "Select Asset Type",
              theme: "bootstrap4",
                dropdownParent: $("#editmodalbuild1"),
                ajax: {
                    url: 'fetch1.php',
                    dataType: 'json',
                    type: 'POST',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term,
                            asset1: true,
                            category_id: params.term 
                        };
                    },
                    processResults: function(returnedData) {
                        var mappedData = $.map(returnedData.data, function(fetch) {
                            return {
                                id: fetch.id,
                                text: fetch.category
                            };
                        });
                        return {
                            results: mappedData
                        };
                    },
                    cache: true
                },
            });

          

            $("#subasset").select2({
              placeholder: "Select Sub Asset",
              theme: "bootstrap4",
              ajax: {
                url: 'fetch1.php',
                dataType: 'json',
                type: 'POST',
                delay: 250,
                data: function(params) {
                    var selectedCategoryId = $('#asset').val(); 
                    return {
                        term: params.term,
                        asset2: true,
                        category_id: selectedCategoryId 
                    };
                },
                processResults: function(returnedData) {
                    var mappedData = $.map(returnedData.data, function(fetch) {
                        return {
                            id: fetch.id,
                            text: fetch.sub_category
                        };
                    });
                    return {
                        results: mappedData
                    };
                },
                cache: true
            },
            minimumInputLength: 0,
            templateResult: formatCategory,
            templateSelection: formatCategorySelection
        });
          
            $("#asset").on("change", function () {
              $("#subasset").val(null).trigger("change"); 
            });
          });
          
          
$(document).ready(function() {
    $("select.category").select2({
        placeholder: "Sort by:",
        theme:"bootstrap4",
        
        ajax: {
            url: 'fetch1.php',
            dataType: 'json',
            type: 'POST',
            delay: 250,
            data: function(params) {
                return {
                    term: params.term,
                    category: true,
                };
            },
            processResults: function(returnedData) {
                var mappedData = $.map(returnedData.data, function(fetch) {
                    return {
                        id: fetch.id,
                        text: fetch.sub_category
                    };
                });
                return {
                    results: mappedData
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        templateResult: formatCategory,
        templateSelection: formatCategorySelection
    });
    
    function formatCategory(category) {
        if (!category.id) {
            return category.text;
        }
        var $category = $(
            '<span>' + category.text + '</span>'
        );
        return $category;
    }
    
    function formatCategorySelection(category) {
        return category.text;
    }
    $(".select2-container").css("margin-bottom", "10px");
    var table = $('#showTable_rpcppe_ao').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: true,
        autoWidth: true,
        dom: 'lBfrtip',
        buttons: [
            "copy", 
            "csv", 
            "excel", 
            {
                extend: 'print',
                customize: function(win) {
                    var sub_category = $('select.category').find(':selected').text();
                    $(win.document.body).css('font-size', '10pt');
                    var formattedTotal = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'PHP',
                        minimumFractionDigits: 2
                    }).format(totalUnitVal);
                
                    $(win.document.body).find('table')
                        .before('<h1 style="text-align:center;">REPORT ON THE PHYSICAL COUNT OF PROPERTY, PLANT AND EQUIPMENT</h1>'+
                               '<p style="text-align:center;">'+'<b>'+ sub_category +'</b>' + '</p>' +
                                '<p style="text-align:center; margin-top:-1em">(Type of Inventory Item)</p>'+
                                '<p style="text-align:center; margin-top:-1em">As at June, 2023</p>'+
                                '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                                '<p><b>For which _______________________________,_______________________________,_______________________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                
                                $(win.document.body).find('table tbody').append(
                                    '<tr>' +
                                    '<td colspan="4" style="text-align:right; font-weight:bold;">Total Unit Value:</td>' +
                                    '<td style="font-weight:bold;">' + formattedTotal + '</td>' +
                                    '<td colspan="7"></td>' +
                                    '</tr>'
                                );

                        $(win.document.body).find('table')
                        .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                            '<tr>' +
                            '<td style="width:30%;">Certified Corrected by:____________________________<br><span style="font-weight:bold; margin-top:-1em; margin-left:5.5em;"><b>Signature over Printed Name of Inventory <span style="margin-left:5.5em;"> Commitee Chair and Members</b></span></span></td>' +
                            '<td style="width:30%;">Approved by:_____________________________<br><span style="font-weight:bold; margin-top:-1em; margin-left:5.5em;"><b>Signature over Printed Name of Head of <span style="margin-left:5.5em;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                            '<td style="width:30%;">Verified by:____________________________<br><span style="font-weight:bold; margin-top:-1em; margin-left:6em; justify-content:center; align-items:center;"><b>Signature over Printed Name of COA <span  style="margin-left:5.5em;">Representative</span></b></span></td>' +
                            '</tr>' +
                            '</table>');
                },
                orientation: 'landscape',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8,9]
                }
            }
        ],
        ajax: {
            url: "getdata.php",
            type: "post",
            data: function(r) {
                r.rpcppe_ao = true;
                r.category = $('select.category').val();
                r.selectedOfficeId = $("select.schools").val(); 
                return r;
            },
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [  
            {"data": "article_id"},
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                            '<div class="col">' + row.description + "  " +
                                '<strong>Model:</strong> ' + row.model +
                            '</div>' +
                            '<div class="col">' +
                                '<strong>SN:</strong> ' + row.asset_sn +
                            '</div>' +
                        '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            {
                "data": "unit_val",
                "render": function(data, type, row) {
                    var formattedValue = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'PHP',
                        minimumFractionDigits: 2
                    }).format(data);
                    
                    return formattedValue;
                }
            }, 
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "remarks"},
            {"data": "fullname"},
        ],
        drawCallback: function () {
            var api = this.api();
            
            totalUnitVal = api.column(4, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
        
            var formattedTotal = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'PHP',
                minimumFractionDigits: 2
            }).format(totalUnitVal);
        
            $('#totalUnitMeas').html('Total: ' + formattedTotal);
        },
        
        lengthMenu: [[10, 25, 50, 100000000], [10, 25, 50, "All"]] 
        });

        table.on('length.dt', function (e, settings, len) {
        console.log('New page length: '+len);
    });

    $("select.category, select.schools").on('change', function () {
        var selectedCategory = $('select.category').val();
        var selectedSchool = $('select.schools').val();

        table.ajax.url('getdata.php?rpcppe_ao=true&category=' + selectedCategory + 'selectedOfficeId=' + selectedSchool).load();
    });
    });
    

    $("select.supplier").select2({
        theme: "bootstrap4",
        placeholder: "Select Supplier",
        ajax: {
            url: 'fetch1.php',
            dataType: 'json',
            type: 'POST',
            delay: 250,
            data: function(params) {
                return {
                    term: params.term,
                    supplier: true
                };
            },
            processResults: function(returnedData) {
                var mappedData = $.map(returnedData.data, function(fetch) {
                    return {
                        id: fetch.id,
                        text: fetch.supplier_name
                    };
                });
                return {
                    results: mappedData
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        templateResult: formatCategory,
        templateSelection: formatCategorySelection
    });
    


    $(document).ready(function () {
        $(".select2-container").css("margin-bottom", "10px");
    
        var totalUnitVal = 0;
    
        // Define the table variable in the outer scope
        var table = $('#showTable_rpcsp_ao').DataTable({
            serverSide: true,
            responsive: true,
            lengthChange: true,
            autoWidth: true,
            dom: 'lBfrtip',
            buttons: [
                "copy",
                "csv",
                "excel", {
                    extend: 'print',
                    customize: function (win) {
                        var sub_category = $('select.category').find(':selected').text();
                        $(win.document.body).css('font-size', '10pt');
                        var formattedTotal = new Intl.NumberFormat('en-US', {
                            style: 'currency',
                            currency: 'PHP',
                            minimumFractionDigits: 2
                        }).format(totalUnitVal);
    
                        $(win.document.body).find('table')
                            .before('<h1 style="text-align:center;">REPORT ON THE PHYSICAL COUNT OF SEMI EXPENDABLE PROPERTY</h1>' +
                                '<p style="text-align:center;">'+'<b>'+ sub_category +'</b>' + '</p>' +
                                '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>' +
                                '<p><b>Fund Cluster:</b> <span>_________________</span></p>' +
                                '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
    
                        $(win.document.body).find('table tbody').append(
                            '<tr>' +
                            '<td colspan="4" style="text-align:right; font-weight:bold;">Total Unit Value:</td>' +
                            '<td style="font-weight:bold;">' + formattedTotal + '</td>' +
                            '<td colspan="7"></td>' +
                            '</tr>'
                        );
    
                        $(win.document.body).find('table').after(
                            '<table style="margin-top:80px; width:100%; text-align:center;">' +
                            '<tr>' +
                            '<td style="text-align:center;">Certified Corrected by:____________________<br>' +
                            '<span style="font-weight:bold; font-size:14px;">Signature over Printed Name of Inventory Committee Chair and Members</span></td>' +
                            '<td style="text-align:center;">Approved by:_____________________________<br>' +
                            '<span style="font-weight:bold; font-size:14px;">Signature over Printed Name of Head of Agency/Entity or Authorized Representative</span></td>' +
                            '<td style="text-align:center;">Verified by:_______________________<br>' +
                            '<span style="font-weight:bold; font-size:14px;">Signature over Printed Name of COA Representative</span></td>' +
                            '</tr>' +
                            '</table>'
                        );
                    },
                    orientation: 'landscape',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]
                    }
                }
            ],
            ajax: {
                url: "getdata.php",
                type: "POST",
                data: function (e) {
                    e.rpcsp_ao = true;
                    e.selectedOfficeId = $("select.schools").val(); 
                    e.category = $('select.category').val();
                    e.value_range = $('select.value').val();
                    return e;
                },
                error: function (xhr, status, error) {
                    console.log("Ajax request failed: " + xhr.responseText);
                }
            },
            columns: [
                { "data": "article_id" },
                {
                    "data": null,
                    "render": function (data, type, row) {
                        return '<div class="row">' +
                            '<div class="col">' + row.description + "  " +
                            '<strong>Model:</strong> ' + row.model +
                            '</div>' +
                            '<div class="col">' +
                            '<strong>SN:</strong> ' + row.asset_sn +
                            '</div>' +
                            '</div>';
                    }
                },
                { "data": "property_no" },
                { "data": "unit_meas" },
                {
                    "data": "unit_val",
                    "render": function (data, type, row) {
                        var formattedValue = new Intl.NumberFormat('en-US', {
                            style: 'currency',
                            currency: 'PHP',
                            minimumFractionDigits: 2
                        }).format(data);
    
                        return formattedValue;
                    }
                },
                { "data": "qty_property_card" },
                { "data": "qty_physical_count" },
                { "data": "shortage_qty" },
                { "data": "shortage_value" },
                { "data": "date_acquired" },
                { "data": "remarks" },
                { "data": "fullname" },
            ],
            lengthMenu: [
                [10, 25, 50, 100000000],
                [10, 25, 50, 'ALL']
            ],
            drawCallback: function () {
                var api = this.api();
    
                totalUnitVal = api.column(4, { page: 'current' }).data().reduce(function (a, b) {
                    return a + parseFloat(b);
                }, 0);
    
                var formattedTotal = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'PHP',
                    minimumFractionDigits: 2
                }).format(totalUnitVal);
    
                $('#totalUnitMeas').html('Total: ' + formattedTotal);
            }
        });
    
       
        $("select.category, select.value").on('change', function () {
            var selectedCategory = $('select.category').val();
            var valueRange = $('select.value').val();
    
          
            table.ajax.url('getdata.php?showTable_rpcsp_ao=true&category=' + selectedCategory + '&value_range=' + valueRange).load();
        });
        });
    


        function confirmLogout() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will be logged out!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("logoutForm").submit();
                }
            });
        }
        



        
$(document).ready(function() {
    var table = $('#showLand_sch').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dom: 'lBfrtip',
        buttons: [
        "copy",
        "csv",
        "excel", {
            extend: 'print',
            customize: function(win) {
                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table')
                    .before('<h1 style="text-align:center;">Report on Land Properties</h1>'+
                             '<p style="text-align:center;">___________________________________</p>'+
                             '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                             '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                             '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                $(win.document.body).find('table')
                    .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                        '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                        '</tr>' +
                        '</table>');
            },
            orientation: 'landscape',
       
               exportOptions: {
             columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
            }

       
             }
    ],
        ajax: {
            url: "../getdata.php",
            type: "post",
            data: {land_sch: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "land_area"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "titled"},
            {"data": "remarks"},
            {"data": "school_office"},
            {"data": "date_acquired"},
            {"data": "date"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1   delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#showLand_sch').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: '../getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                Swal.fire({
                    title: 'Edit Data',
                    html: '<input id="swal-input1" class="swal2-input" value="' + data[0].description + '">'+
                    '<input id="swal-input2" class="swal2-input" value="' + data[0].property_no + '">' +
                    '<input id="swal-input3" class="swal2-input" value="' + data[0].land_area + '">' +
                    '<input id="swal-input4" class="swal2-input" value="₱' + data[0].unit_val + '">' +
                    '<input id="swal-input5" class="swal2-input" value="' + data[0].titled +'">'+
                    '<input id="swal-input6" class="swal2-input" value="' + data[0].remarks +'">'+
                    '<input id="swal-input7" class="swal2-input" value="' + data[0].school_office +'">'+
                    '<input id="swal-input8" class="swal2-input" value="' + data[0].date +'">',
                    focusConfirm: false,
                    confirmButtonText: 'Update',
                    preConfirm: () => {
                        const value1 = document.getElementById('swal-input1').value;
                        const value2 = document.getElementById('swal-input2').value;
                        const value3 = document.getElementById('swal-input3').value;
                        const value4 = document.getElementById('swal-input4').value.replace('₱', ''); 
                        const value5 = document.getElementById('swal-input5').value;
                        const value6 = document.getElementById('swal-input6').value;
                        const value7 = document.getElementById('swal-input7').value;
                        const value8 = document.getElementById('swal-input8').value;

                        return [value1,value2,value3,value4,value5,value6,value7,value8];
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        const [value1, value2, value3, value4, value5, value6, value7, value8] = result.value;
                        $.ajax({
                            url: 'function.php',
                            type: 'POST',
                            data: {
                                updateland: true,
                                id: id,
                                description: value1,
                                property_no: value2,
                                land_area: value3,
                                unit_val: value4,
                                titled: value5,
                                remarks: value6,
                                school_office: value7,
                                date: value8,
                              
                            },
                            success: function(response) {
                                if (response.trim() === "Updated Successfully") {
                                    Swal.fire(
                                        'Updated!',
                                        'File has been updated successfully.',
                                        'success'
                                    );
                                    table.ajax.reload();
                                } else {
                                    Swal.fire(
                                        'Failed!',
                                        'Failed to update file.',
                                        'error'
                                    );
                                }
                            },
                           
                        });
                    }
                });
            } 
        },

    });
})
$('#showLand_sch').on('click', '.delete-btn', function() {
    var id = $(this).data('delete');
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete it?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../function.php',
                type: 'POST',
                data: {
                    deleteland: true,
                    id: id
                },
                success: function(response) {
                    if (response.trim() === "Deleted Successfully") {
                        Swal.fire(
                            'Deleted!',
                            'File has been deleted successfully.',
                            'success'
                        );
                        table.ajax.reload();
                    } else {
                        Swal.fire(
                            'Failed!',
                            'Failed to delete file.',
                            'error'
                        );
                    }
                },
            });
        }
    });
});

})



$(document).ready(function() {
    var table = $('#school_building').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dropdownParent: $("#editModalschool"),
        dom: 'lBfrtip',
        buttons: [
        "copy",
        "csv",
        "excel", {
            extend: 'print',
            customize: function(win) {
                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table')
                    .before('<h1 style="text-align:center;">Report on School Buildings</h1>'+
                             '<p style="text-align:center;">___________________________________</p>'+
                             '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                             '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                             '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                $(win.document.body).find('table')
                    .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                        '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                        '</tr>' +
                        '</table>');
            },
            orientation: 'landscape',
       
               exportOptions: {
             columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
            }

       
             }
    ],
        ajax: {
            url: "../getdata.php",
            type: "post",
            data: {school_building: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#school_building').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: '../getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                
            
             
                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                $("#assetsch").append(assetOption).trigger("change");
                var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                $("#subassetsch").append(subOption).trigger("change");
                $('#modal-input1').val(data[0].description);
                $('#modal-input2').val(data[0].property_no);
                $('#modal-input3').val(data[0].unit_meas);
                $('#modal-input4').val(data[0].unit_val);
                $('#modal-input5').val(data[0].qty_property_card);
                $('#modal-input6').val(data[0].qty_physical_count);
                $('#modal-input7').val(data[0].shortage_qty);
                $('#modal-input8').val(data[0].shortage_value);
                var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                $('select.edit_personnel_school').append(officerOption).trigger('change');
                $('#modal-input10').val(data[0].remarks);

               
                $('#editModalschool').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: '../function.php',
                        type: 'POST',
                        data: {
                            update_school: true,
                            id: id,
                            asset_id: $("#assetsch").val(),
                            sub_category: $("#subassetsch").val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel_school').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editModalschool').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file.',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});


    $('#school_building').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../function.php',
                    type: 'POST',
                    data: {
                        deletebuild2: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });
});



$(document).ready(function() {
    var table = $('#office_building').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dropdownParent: $("#editModalschool"),
        dom: 'lBfrtip',
        buttons: [
        "copy",
        "csv",
        "excel", {
            extend: 'print',
            customize: function(win) {
                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table')
                    .before('<h1 style="text-align:center;">Report on School Buildings</h1>'+
                             '<p style="text-align:center;">___________________________________</p>'+
                             '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                             '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                             '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                $(win.document.body).find('table')
                    .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                        '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                        '</tr>' +
                        '</table>');
            },
            orientation: 'landscape',
       
               exportOptions: {
             columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
            }

       
             }
    ],
        ajax: {
            url: "../getdata.php",
            type: "post",
            data: {office_building: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#office_building').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: '../getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                
               
            
                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                $("#assetsch").append(assetOption).trigger("change");
                var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                $("#subassetsch").append(subOption).trigger("change");
                $('#modal-input1').val(data[0].description);
                $('#modal-input2').val(data[0].property_no);
                $('#modal-input3').val(data[0].unit_meas);
                $('#modal-input4').val(data[0].unit_val);
                $('#modal-input5').val(data[0].qty_property_card);
                $('#modal-input6').val(data[0].qty_physical_count);
                $('#modal-input7').val(data[0].shortage_qty);
                $('#modal-input8').val(data[0].shortage_value);
                var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                $('select.edit_personnel_school').append(officerOption).trigger('change');
                $('#modal-input10').val(data[0].remarks);

               
                $('#editModalschool').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: '../function.php',
                        type: 'POST',
                        data: {
                            update_school: true,
                            id: id,
                            asset_id: $("#assetsch").val(),
                            sub_category: $("#subassetsch").val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel_school').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editModalschool').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file.',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});


    $('#office_building').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../function.php',
                    type: 'POST',
                    data: {
                        deletebuild2: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });
});




$(document).ready(function() {
    var table = $('#others_structure').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dropdownParent: $("#editModalschool"),
        dom: 'lBfrtip',
        buttons: [
        "copy",
        "csv",
        "excel", {
            extend: 'print',
            customize: function(win) {
                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table')
                    .before('<h1 style="text-align:center;">Report on School Buildings</h1>'+
                             '<p style="text-align:center;">___________________________________</p>'+
                             '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                             '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                             '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                $(win.document.body).find('table')
                    .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                        '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                        '</tr>' +
                        '</table>');
            },
            orientation: 'landscape',
       
               exportOptions: {
             columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
            }

       
             }
    ],
        ajax: {
            url: "../getdata.php",
            type: "post",
            data: {others_structure: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#others_structure').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: '../getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                
              
             
                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                $("#assetsch").append(assetOption).trigger("change");
                var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                $("#subassetsch").append(subOption).trigger("change");
                $('#modal-input1').val(data[0].description);
                $('#modal-input2').val(data[0].property_no);
                $('#modal-input3').val(data[0].unit_meas);
                $('#modal-input4').val(data[0].unit_val);
                $('#modal-input5').val(data[0].qty_property_card);
                $('#modal-input6').val(data[0].qty_physical_count);
                $('#modal-input7').val(data[0].shortage_qty);
                $('#modal-input8').val(data[0].shortage_value);
                var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                $('select.edit_personnel_school').append(officerOption).trigger('change');
                $('#modal-input10').val(data[0].remarks);

               
                $('#editModalschool').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: '../function.php',
                        type: 'POST',
                        data: {
                            update_school: true,
                            id: id,
                            asset_id: $("#assetsch").val(),
                            sub_category: $("#subassetsch").val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel_school').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editModalschool').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file.',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});


    $('#others_structure').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../function.php',
                    type: 'POST',
                    data: {
                        deletebuild2: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });
});





$(document).ready(function() {
    var table = $('#historical_building').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dropdownParent: $("#editModalschool"),
        dom: 'lBfrtip',
        buttons: [
        "copy",
        "csv",
        "excel", {
            extend: 'print',
            customize: function(win) {
                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table')
                    .before('<h1 style="text-align:center;">Report on School Buildings</h1>'+
                             '<p style="text-align:center;">___________________________________</p>'+
                             '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                             '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                             '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                $(win.document.body).find('table')
                    .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                        '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                        '</tr>' +
                        '</table>');
            },
            orientation: 'landscape',
       
               exportOptions: {
             columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
            }

       
             }
    ],
        ajax: {
            url: "../getdata.php",
            type: "post",
            data: {historical_building: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#historical_building').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: '../getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                
             
                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                $("#assetsch").append(assetOption).trigger("change");
                var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                $("#subassetsch").append(subOption).trigger("change");
                $('#modal-input1').val(data[0].description);
                $('#modal-input2').val(data[0].property_no);
                $('#modal-input3').val(data[0].unit_meas);
                $('#modal-input4').val(data[0].unit_val);
                $('#modal-input5').val(data[0].qty_property_card);
                $('#modal-input6').val(data[0].qty_physical_count);
                $('#modal-input7').val(data[0].shortage_qty);
                $('#modal-input8').val(data[0].shortage_value);
                var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                $('select.edit_personnel_school').append(officerOption).trigger('change');
                $('#modal-input10').val(data[0].remarks);

               
                $('#editModalschool').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: '../function.php',
                        type: 'POST',
                        data: {
                            update_school: true,
                            id: id,
                            asset_id: $("#assetsch").val(),
                            sub_category: $("#subassetsch").val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel_school').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editModalschool').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file.',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});


    $('#historical_building').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../function.php',
                    type: 'POST',
                    data: {
                        deletebuild2: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });
});




$(document).ready(function() {
    var table = $('#agricultural_equipment').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dropdownParent: $("#editModalschool"),
        dom: 'lBfrtip',
        buttons: [
        "copy",
        "csv",
        "excel", {
            extend: 'print',
            customize: function(win) {
                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table')
                    .before('<h1 style="text-align:center;">Report on School Buildings</h1>'+
                             '<p style="text-align:center;">___________________________________</p>'+
                             '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                             '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                             '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                $(win.document.body).find('table')
                    .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                        '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                        '</tr>' +
                        '</table>');
            },
            orientation: 'landscape',
       
               exportOptions: {
             columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
            }

       
             }
    ],
        ajax: {
            url: "../getdata.php",
            type: "post",
            data: {agircultural_equipment: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#agricultural_equipment').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: '../getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                
               
             
                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                $("#assetsch").append(assetOption).trigger("change");
                var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                $("#subassetsch").append(subOption).trigger("change");
                $('#modal-input1').val(data[0].description);
                $('#modal-input2').val(data[0].property_no);
                $('#modal-input3').val(data[0].unit_meas);
                $('#modal-input4').val(data[0].unit_val);
                $('#modal-input5').val(data[0].qty_property_card);
                $('#modal-input6').val(data[0].qty_physical_count);
                $('#modal-input7').val(data[0].shortage_qty);
                $('#modal-input8').val(data[0].shortage_value);
                var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                $('select.edit_personnel_school').append(officerOption).trigger('change');
                $('#modal-input10').val(data[0].remarks);

               
                $('#editModalschool').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: '../function.php',
                        type: 'POST',
                        data: {
                            update_school: true,
                            id: id,
                            asset_id: $("#assetsch").val(),
                            sub_category: $("#subassetsch").val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel_school').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editModalschool').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file.',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});


    $('#agricultural_equipment').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../function.php',
                    type: 'POST',
                    data: {
                        deletebuild2: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });
});





$(document).ready(function() {
    var table = $('#ict_equipment').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dropdownParent: $("#editModalschool"),
        dom: 'lBfrtip',
        buttons: [
        "copy",
        "csv",
        "excel", {
            extend: 'print',
            customize: function(win) {
                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table')
                    .before('<h1 style="text-align:center;">Report on School Buildings</h1>'+
                             '<p style="text-align:center;">___________________________________</p>'+
                             '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                             '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                             '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                $(win.document.body).find('table')
                    .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                        '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                        '</tr>' +
                        '</table>');
            },
            orientation: 'landscape',
       
               exportOptions: {
             columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
            }

       
             }
    ],
        ajax: {
            url: "../getdata.php",
            type: "post",
            data: {ict_equipment: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#ict_equipment').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: '../getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                
             
               
                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                $("#assetsch").append(assetOption).trigger("change");
                var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                $("#subassetsch").append(subOption).trigger("change");
                $('#modal-input1').val(data[0].description);
                $('#modal-input2').val(data[0].property_no);
                $('#modal-input3').val(data[0].unit_meas);
                $('#modal-input4').val(data[0].unit_val);
                $('#modal-input5').val(data[0].qty_property_card);
                $('#modal-input6').val(data[0].qty_physical_count);
                $('#modal-input7').val(data[0].shortage_qty);
                $('#modal-input8').val(data[0].shortage_value);
                var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                $('select.edit_personnel_school').append(officerOption).trigger('change');
                $('#modal-input10').val(data[0].remarks);

               
                $('#editModalschool').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: '../function.php',
                        type: 'POST',
                        data: {
                            update_school: true,
                            id: id,
                            asset_id: $("#assetsch").val(),
                            sub_category: $("#subassetsch").val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel_school').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editModalschool').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file.',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});


    $('#ict_equipment').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../function.php',
                    type: 'POST',
                    data: {
                        deletebuild2: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });
});





$(document).ready(function() {
    var table = $('#machinery').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dropdownParent: $("#editModalschool"),
        dom: 'lBfrtip',
        buttons: [
        "copy",
        "csv",
        "excel", {
            extend: 'print',
            customize: function(win) {
                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table')
                    .before('<h1 style="text-align:center;">Report on School Buildings</h1>'+
                             '<p style="text-align:center;">___________________________________</p>'+
                             '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                             '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                             '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                $(win.document.body).find('table')
                    .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                        '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                        '</tr>' +
                        '</table>');
            },
            orientation: 'landscape',
       
               exportOptions: {
             columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
            }

       
             }
    ],
        ajax: {
            url: "../getdata.php",
            type: "post",
            data: {machinery: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#machinery').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: '../getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                
              
              
                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                $("#assetsch").append(assetOption).trigger("change");
                var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                $("#subassetsch").append(subOption).trigger("change");
                $('#modal-input1').val(data[0].description);
                $('#modal-input2').val(data[0].property_no);
                $('#modal-input3').val(data[0].unit_meas);
                $('#modal-input4').val(data[0].unit_val);
                $('#modal-input5').val(data[0].qty_property_card);
                $('#modal-input6').val(data[0].qty_physical_count);
                $('#modal-input7').val(data[0].shortage_qty);
                $('#modal-input8').val(data[0].shortage_value);
                var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                $('select.edit_personnel_school').append(officerOption).trigger('change');
                $('#modal-input10').val(data[0].remarks);

               
                $('#editModalschool').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: '../function.php',
                        type: 'POST',
                        data: {
                            update_school: true,
                            id: id,
                            asset_id: $("#assetsch").val(),
                            sub_category: $("#subassetsch").val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel_school').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editModalschool').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file.',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});


    $('#machinery').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../function.php',
                    type: 'POST',
                    data: {
                        deletebuild2: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });
});



$(document).ready(function() {
    var table = $('#office_equipment').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dropdownParent: $("#editModalschool"),
        dom: 'lBfrtip',
        buttons: [
        "copy",
        "csv",
        "excel", {
            extend: 'print',
            customize: function(win) {
                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table')
                    .before('<h1 style="text-align:center;">Report on School Buildings</h1>'+
                             '<p style="text-align:center;">___________________________________</p>'+
                             '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                             '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                             '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                $(win.document.body).find('table')
                    .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                        '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                        '</tr>' +
                        '</table>');
            },
            orientation: 'landscape',
       
               exportOptions: {
             columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
            }

       
             }
    ],
        ajax: {
            url: "../getdata.php",
            type: "post",
            data: {office_equipment: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#office_equipment').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: '../getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                
              
              
                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                $("#assetsch").append(assetOption).trigger("change");
                var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                $("#subassetsch").append(subOption).trigger("change");
                $('#modal-input1').val(data[0].description);
                $('#modal-input2').val(data[0].property_no);
                $('#modal-input3').val(data[0].unit_meas);
                $('#modal-input4').val(data[0].unit_val);
                $('#modal-input5').val(data[0].qty_property_card);
                $('#modal-input6').val(data[0].qty_physical_count);
                $('#modal-input7').val(data[0].shortage_qty);
                $('#modal-input8').val(data[0].shortage_value);
                var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                $('select.edit_personnel_school').append(officerOption).trigger('change');
                $('#modal-input10').val(data[0].remarks);

               
                $('#editModalschool').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: '../function.php',
                        type: 'POST',
                        data: {
                            update_school: true,
                            id: id,
                            asset_id: $("#assetsch").val(),
                            sub_category: $("#subassetsch").val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel_school').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editModalschool').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file.',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});


    $('#office_equipment').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../function.php',
                    type: 'POST',
                    data: {
                        deletebuild2: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });
});




$(document).ready(function() {
    var table = $('#sports_equipment').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dropdownParent: $("#editModalschool"),
        dom: 'lBfrtip',
        buttons: [
        "copy",
        "csv",
        "excel", {
            extend: 'print',
            customize: function(win) {
                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table')
                    .before('<h1 style="text-align:center;">Report on School Buildings</h1>'+
                             '<p style="text-align:center;">___________________________________</p>'+
                             '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                             '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                             '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                $(win.document.body).find('table')
                    .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                        '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                        '</tr>' +
                        '</table>');
            },
            orientation: 'landscape',
       
               exportOptions: {
             columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
            }

       
             }
    ],
        ajax: {
            url: "../getdata.php",
            type: "post",
            data: {sports_equipment: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#sports_equipment').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: '../getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                
              
              
                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                $("#assetsch").append(assetOption).trigger("change");
                var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                $("#subassetsch").append(subOption).trigger("change");
                $('#modal-input1').val(data[0].description);
                $('#modal-input2').val(data[0].property_no);
                $('#modal-input3').val(data[0].unit_meas);
                $('#modal-input4').val(data[0].unit_val);
                $('#modal-input5').val(data[0].qty_property_card);
                $('#modal-input6').val(data[0].qty_physical_count);
                $('#modal-input7').val(data[0].shortage_qty);
                $('#modal-input8').val(data[0].shortage_value);
                var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                $('select.edit_personnel_school').append(officerOption).trigger('change');
                $('#modal-input10').val(data[0].remarks);

               
                $('#editModalschool').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: '../function.php',
                        type: 'POST',
                        data: {
                            update_school: true,
                            id: id,
                            asset_id: $("#assetsch").val(),
                            sub_category: $("#subassetsch").val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel_school').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editModalschool').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file.',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});


    $('#sports_equipment').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../function.php',
                    type: 'POST',
                    data: {
                        deletebuild2: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });
});




$(document).ready(function() {
    var table = $('#technical_equipment').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dropdownParent: $("#editModalschool"),
        dom: 'lBfrtip',
        buttons: [
        "copy",
        "csv",
        "excel", {
            extend: 'print',
            customize: function(win) {
                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table')
                    .before('<h1 style="text-align:center;">Report on School Buildings</h1>'+
                             '<p style="text-align:center;">___________________________________</p>'+
                             '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                             '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                             '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                $(win.document.body).find('table')
                    .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                        '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                        '</tr>' +
                        '</table>');
            },
            orientation: 'landscape',
       
               exportOptions: {
             columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
            }

       
             }
    ],
        ajax: {
            url: "../getdata.php",
            type: "post",
            data: {technical_equipment: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#technical_equipment').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: '../getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                
              
             
                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                $("#assetsch").append(assetOption).trigger("change");
                var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                $("#subassetsch").append(subOption).trigger("change");
                $('#modal-input1').val(data[0].description);
                $('#modal-input2').val(data[0].property_no);
                $('#modal-input3').val(data[0].unit_meas);
                $('#modal-input4').val(data[0].unit_val);
                $('#modal-input5').val(data[0].qty_property_card);
                $('#modal-input6').val(data[0].qty_physical_count);
                $('#modal-input7').val(data[0].shortage_qty);
                $('#modal-input8').val(data[0].shortage_value);
                var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                $('select.edit_personnel_school').append(officerOption).trigger('change');
                $('#modal-input10').val(data[0].remarks);

               
                $('#editModalschool').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: '../function.php',
                        type: 'POST',
                        data: {
                            update_school: true,
                            id: id,
                            asset_id: $("#assetsch").val(),
                            sub_category: $("#subassetsch").val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel_school').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editModalschool').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file.',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});


    $('#technical_equipment').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../function.php',
                    type: 'POST',
                    data: {
                        deletebuild2: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });
});




$(document).ready(function() {
    var table = $('#transportation').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dropdownParent: $("#editModalschool"),
        dom: 'lBfrtip',
        buttons: [
        "copy",
        "csv",
        "excel", {
            extend: 'print',
            customize: function(win) {
                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table')
                    .before('<h1 style="text-align:center;">Report on School Buildings</h1>'+
                             '<p style="text-align:center;">___________________________________</p>'+
                             '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                             '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                             '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                $(win.document.body).find('table')
                    .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                        '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                        '</tr>' +
                        '</table>');
            },
            orientation: 'landscape',
       
               exportOptions: {
             columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
            }

       
             }
    ],
        ajax: {
            url: "../getdata.php",
            type: "post",
            data: {transportation: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#transportation').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: '../getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                
              
              
                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                $("#assetsch").append(assetOption).trigger("change");
                var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                $("#subassetsch").append(subOption).trigger("change");
                $('#modal-input1').val(data[0].description);
                $('#modal-input2').val(data[0].property_no);
                $('#modal-input3').val(data[0].unit_meas);
                $('#modal-input4').val(data[0].unit_val);
                $('#modal-input5').val(data[0].qty_property_card);
                $('#modal-input6').val(data[0].qty_physical_count);
                $('#modal-input7').val(data[0].shortage_qty);
                $('#modal-input8').val(data[0].shortage_value);
                var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                $('select.edit_personnel_school').append(officerOption).trigger('change');
                $('#modal-input10').val(data[0].remarks);

               
                $('#editModalschool').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: '../function.php',
                        type: 'POST',
                        data: {
                            update_school: true,
                            id: id,
                            asset_id: $("#assetsch").val(),
                            sub_category: $("#subassetsch").val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel_school').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editModalschool').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file.',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});


    $('#transportation').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../function.php',
                    type: 'POST',
                    data: {
                        deletebuild2: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });
});





$(document).ready(function() {
    var table = $('#Book').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dropdownParent: $("#editModalschool"),
        dom: 'lBfrtip',
        buttons: [
        "copy",
        "csv",
        "excel", {
            extend: 'print',
            customize: function(win) {
                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table')
                    .before('<h1 style="text-align:center;">Report on School Buildings</h1>'+
                             '<p style="text-align:center;">___________________________________</p>'+
                             '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                             '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                             '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                $(win.document.body).find('table')
                    .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                        '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                        '</tr>' +
                        '</table>');
            },
            orientation: 'landscape',
       
               exportOptions: {
             columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
            }

       
             }
    ],
        ajax: {
            url: "../getdata.php",
            type: "post",
            data: {books1: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#Book').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: '../getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                
             
                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                $("#assetsch").append(assetOption).trigger("change");
                var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                $("#subassetsch").append(subOption).trigger("change");
                $('#modal-input1').val(data[0].description);
                $('#modal-input2').val(data[0].property_no);
                $('#modal-input3').val(data[0].unit_meas);
                $('#modal-input4').val(data[0].unit_val);
                $('#modal-input5').val(data[0].qty_property_card);
                $('#modal-input6').val(data[0].qty_physical_count);
                $('#modal-input7').val(data[0].shortage_qty);
                $('#modal-input8').val(data[0].shortage_value);
                var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                $('select.edit_personnel_school').append(officerOption).trigger('change');
                $('#modal-input10').val(data[0].remarks);

               
                $('#editModalschool').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: '../function.php',
                        type: 'POST',
                        data: {
                            update_school: true,
                            id: id,
                            asset_id: $("#assetsch").val(),
                            sub_category: $("#subassetsch").val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel_school').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editModalschool').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file.',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});


    $('#Book').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../function.php',
                    type: 'POST',
                    data: {
                        deletebuild2: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });
});





$(document).ready(function() {
    var table = $('#furniture').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dropdownParent: $("#editModalschool"),
        dom: 'lBfrtip',
        buttons: [
        "copy",
        "csv",
        "excel", {
            extend: 'print',
            customize: function(win) {
                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table')
                    .before('<h1 style="text-align:center;">Report on School Buildings</h1>'+
                             '<p style="text-align:center;">___________________________________</p>'+
                             '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                             '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                             '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                $(win.document.body).find('table')
                    .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                        '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                        '</tr>' +
                        '</table>');
            },
            orientation: 'landscape',
       
               exportOptions: {
             columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
            }

       
             }
    ],
        ajax: {
            url: "../getdata.php",
            type: "post",
            data: {furniture1: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#furniture').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: '../getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                
            
                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                $("#assetsch").append(assetOption).trigger("change");
                var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                $("#subassetsch").append(subOption).trigger("change");
                $('#modal-input1').val(data[0].description);
                $('#modal-input2').val(data[0].property_no);
                $('#modal-input3').val(data[0].unit_meas);
                $('#modal-input4').val(data[0].unit_val);
                $('#modal-input5').val(data[0].qty_property_card);
                $('#modal-input6').val(data[0].qty_physical_count);
                $('#modal-input7').val(data[0].shortage_qty);
                $('#modal-input8').val(data[0].shortage_value);
                var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                $('select.edit_personnel_school').append(officerOption).trigger('change');
                $('#modal-input10').val(data[0].remarks);

               
                $('#editModalschool').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: '../function.php',
                        type: 'POST',
                        data: {
                            update_school: true,
                            id: id,
                            asset_id: $("#assetsch").val(),
                            sub_category: $("#subassetsch").val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel_school').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editModalschool').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file.',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});


    $('#furniture').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../function.php',
                    type: 'POST',
                    data: {
                        deletebuild2: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });
});



$(document).ready(function() {
    var table = $('#others').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: false,
        autoWidth: true,
        dropdownParent: $("#editModalschool"),
        dom: 'lBfrtip',
        buttons: [
        "copy",
        "csv",
        "excel", {
            extend: 'print',
            customize: function(win) {
                $(win.document.body).css('font-size', '10pt');
                $(win.document.body).find('table')
                    .before('<h1 style="text-align:center;">Report on School Buildings</h1>'+
                             '<p style="text-align:center;">___________________________________</p>'+
                             '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>'+
                             '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                             '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                $(win.document.body).find('table')
                    .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style=" ">Certified Corrected by:____________________<br><span style="font-weight:bold; font-size:14px;  text-align:center;  "><b>Signature over Printed Name of Inventory <span style="margin-left:.5em; font-size:14px;"> Commitee Chair and Members</b></span></span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br><span style="font-weight:bold; font-size:14px; text-align:center;  align-items:center;"><b>Signature over Printed Name of Head of <span style="margin-left:.5em; font-size:14px;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                        '<td style="justify-content:center;">Verified by:_______________________<br><span style="font-weight:bold; font-size:14px; justify-content:center; text-align:center"><b>Signature over Printed Name of COA <span  style="margin-left:.5em; font-size:14px;">Representative</span></b></span></td>' +
                        '</tr>' +
                        '</table>');
            },
            orientation: 'landscape',
       
               exportOptions: {
             columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]  
            }

       
             }
    ],
        ajax: {
            url: "../getdata.php",
            type: "post",
            data: {others1: true},
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                               '<div class="col">' + row.description +
                                   '<strong>Model:</strong> ' + row.model +
                               '</div>' +
                               '<div class="col">' +
                                   '<strong>SN:</strong> ' + row.asset_sn +
                               '</div>' +
                           '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            { "data": "unit_val", 
          "render": function(data, type, row) {
              return '₱' + data;
          } },
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "date_acquired"},
            {"data": "remarks"},
            {"data": "fullname"},
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-primary btn-sm ml-2 ms-1 update-btn" name="update" data-update="' + row.id + '"><span>Edit<i class="fa fa-pen" style="color:yellow"></i></span></button>'+ 
                    '<button class="btn btn-danger btn-sm ml-2 ms-1 delete-btn" name="delete" data-delete="' + row.id + '"><span>Delete <i class="fa fa-trash" style="color:skyblue"></i></span></button>';
                }   
            },
        ],
        drawCallback: function () {
            var api = this.api();
            var total = api.column(3, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#totalUnitMeas').html('Total: ₱' + total.toFixed(2));
        }
    });


$('#others').on('click', '.update-btn', function() {
    var id = $(this).data('update');
    console.log(id);    
    $.ajax({
        url: '../getdata.php',
        type: 'POST',
        data: {
            getdata: true,
            id: id
        },
        success: function(response) {
            if (response.trim() !== "") {
                var data = JSON.parse(response);
                
              
              
                var assetOption = new Option(data[0].category, data[0].asset_id, true, true);
                $("#assetsch").append(assetOption).trigger("change");
                var subOption = new Option(data[0].sub_category, data[0].id, true, true);
                $("#subassetsch").append(subOption).trigger("change");
                $('#modal-input1').val(data[0].description);
                $('#modal-input2').val(data[0].property_no);
                $('#modal-input3').val(data[0].unit_meas);
                $('#modal-input4').val(data[0].unit_val);
                $('#modal-input5').val(data[0].qty_property_card);
                $('#modal-input6').val(data[0].qty_physical_count);
                $('#modal-input7').val(data[0].shortage_qty);
                $('#modal-input8').val(data[0].shortage_value);
                var officerOption = new Option(data[0].fullname, data[0].hris_code, true, true);
                $('select.edit_personnel_school').append(officerOption).trigger('change');
                $('#modal-input10').val(data[0].remarks);

               
                $('#editModalschool').modal('show');

                $('#saveChanges').off('click').on('click', function() {
                    $.ajax({
                        url: '../function.php',
                        type: 'POST',
                        data: {
                            update_school: true,
                            id: id,
                            asset_id: $("#assetsch").val(),
                            sub_category: $("#subassetsch").val(),
                            description: $('#modal-input1').val(),
                            property_no: $('#modal-input2').val(),
                            unit_meas: $('#modal-input3').val(),
                            unit_val: $('#modal-input4').val().replace('₱', ''), 
                            qty_property_card: $('#modal-input5').val(),
                            qty_physical_count: $('#modal-input6').val(),
                            shortage_qty: $('#modal-input7').val(),
                            shortage_value: $('#modal-input8').val(),
                            account_officer: $('select.edit_personnel_school').val(),
                            remarks: $('#modal-input10').val(),
                        },
                        success: function(response) {
                            if (response.trim() === "Updated Successfully") {
                                $('#editModalschool').modal('hide');
                                Swal.fire(
                                    'Updated!',
                                    'File has been updated successfully.',
                                    'success'
                                );
                                table.ajax.reload();
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to update file.',
                                    'error'
                                );
                            }
                        },
                    });
                });
            }
        },
    });
});


    $('#others').on('click', '.delete-btn', function() {
        var id = $(this).data('delete');
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete it?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../function.php',
                    type: 'POST',
                    data: {
                        deletebuild2: true,
                        id: id
                    },
                    success: function(response) {
                        if (response.trim() === "Deleted Successfully") {
                            Swal.fire(
                                'Deleted!',
                                'File has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                'Failed to delete file.',
                                'error'
                            );
                        }
                    },
                });
            }
        });
    });
});



$(document).ready(function() {
    $("select.category_school").select2({
        placeholder: "Sort by:",
        theme:"bootstrap4",
        
        ajax: {
            url: '../fetch1.php',
            dataType: 'json',
            type: 'POST',
            delay: 250,
            data: function(params) {
                return {
                    term: params.term,
                    category: true,
                };
            },
            processResults: function(returnedData) {
                var mappedData = $.map(returnedData.data, function(fetch) {
                    return {
                        id: fetch.id,
                        text: fetch.sub_category
                    };
                });
                return {
                    results: mappedData
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        templateResult: formatCategory,
        templateSelection: formatCategorySelection
    });
    
    function formatCategory(category) {
        if (!category.id) {
            return category.text;
        }
        var $category = $(
            '<span>' + category.text + '</span>'
        );
        return $category;
    }
    
    function formatCategorySelection(category) {
        return category.text;
    }
    $(".select2-container").css("margin-bottom", "10px");
    var table = $('#rpcsp_school').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: true,
        autoWidth: true,
        dom: 'lBfrtip',
        buttons: [
            "copy", 
            "csv", 
            "excel", 
            {
                extend: 'print',
                customize: function(win) {
                    var sub_category = $('select.category_school').find(':selected').text();
                    $(win.document.body).css('font-size', '10pt');
                    var formattedTotal = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'PHP',
                        minimumFractionDigits: 2
                    }).format(totalUnitVal);
                
                    $(win.document.body).find('table')
                        .before('<h1 style="text-align:center;">REPORT ON THE PHYSICAL COUNT OF SEMI EXPENDABLE PROPERTY</h1>'+
                               '<p style="text-align:center;">'+'<b>'+ sub_category +'</b>' + '</p>' +
                                '<p style="text-align:center; margin-top:-1em">(Type of Inventory Item)</p>'+
                                '<p style="text-align:center; margin-top:-1em">As at June, 2023</p>'+
                                '<p><b>Fund Cluster:</b> <span>_________________</span></p>'+
                                '<p><b>For which _______________________________,_______________________________,_______________________________is accountable, having assumed such accountability on (_____________________)</b></p>');
                
                                $(win.document.body).find('table tbody').append(
                                    '<tr>' +
                                    '<td colspan="4" style="text-align:right; font-weight:bold;">Total Unit Value:</td>' +
                                    '<td style="font-weight:bold;">' + formattedTotal + '</td>' +
                                    '<td colspan="7"></td>' +
                                    '</tr>'
                                );

                        $(win.document.body).find('table')
                        .after('<table style="margin-top:80px; width:100%; text-align:center;">' +
                            '<tr>' +
                            '<td style="width:30%;">Certified Corrected by:____________________________<br><span style="font-weight:bold; margin-top:-1em; margin-left:5.5em;"><b>Signature over Printed Name of Inventory <span style="margin-left:5.5em;"> Commitee Chair and Members</b></span></span></td>' +
                            '<td style="width:30%;">Approved by:_____________________________<br><span style="font-weight:bold; margin-top:-1em; margin-left:5.5em;"><b>Signature over Printed Name of Head of <span style="margin-left:5.5em;">Agency/Entity or Authorized Representative</span></b></span></td>' +
                            '<td style="width:30%;">Verified by:____________________________<br><span style="font-weight:bold; margin-top:-1em; margin-left:6em; justify-content:center; align-items:center;"><b>Signature over Printed Name of COA <span  style="margin-left:5.5em;">Representative</span></b></span></td>' +
                            '</tr>' +
                            '</table>');
                },
                orientation: 'landscape',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8,9]
                }
            }
        ],
        ajax: {
            url: "../getdata.php",
            type: "post",
            data: function(r) {
                r.rpcsp_school = true;
                r.category = $('select.category_school').val();
                r.value_range = $('select.value').val();
                return r;
            },
            error: function(thrown) {
                console.log("Ajax request failed: " + thrown);
            }
        },
        columns: [  
            {"data": "article_id"},
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<div class="row">' + 
                            '<div class="col">' + row.description + "  " +
                                '<strong>Model:</strong> ' + row.model +
                            '</div>' +
                            '<div class="col">' +
                                '<strong>SN:</strong> ' + row.asset_sn +
                            '</div>' +
                        '</div>';
                }
            },
            {"data": "property_no"},
            {"data": "unit_meas"},
            {
                "data": "unit_val",
                "render": function(data, type, row) {
                    var formattedValue = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'PHP',
                        minimumFractionDigits: 2
                    }).format(data);
                    
                    return formattedValue;
                }
            }, 
            {"data": "qty_property_card"},
            {"data": "qty_physical_count"},
            {"data": "shortage_qty"},
            {"data": "shortage_value"},
            {"data": "remarks"},
            {"data": "fullname"},
        ],
        drawCallback: function () {
            var api = this.api();
            
            totalUnitVal = api.column(4, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
        
            var formattedTotal = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'PHP',
                minimumFractionDigits: 2
            }).format(totalUnitVal);
        
            $('#totalUnitMeas').html('Total: ' + formattedTotal);
        },
        
        lengthMenu: [[10, 25, 50, 100000000], [10, 25, 50, "All"]] 
        });

        table.on('length.dt', function (e, settings, len) {
        console.log('New page length: '+len);
    });

    $("select.category_school, select.value").on('change', function () {
        var selectedCategory = $('select.category_school').val();
        var value_range = $('select.value').val();

        table.ajax.url('../getdata.php?rpcsp_school=true&category=' + selectedCategory + 'value_range=' + value_range).load();
    });
    });



    //rpcppe school
$(document).ready(function () {
    var totalUnitVal = 0;
    var table = $('#rpcppe_school').DataTable({
        serverSide: true,
        responsive: true,
        lengthChange: true,
        autoWidth: true,
        dom: 'lBfrtip',
        buttons: [
            "copy",
            "csv",
            "excel", {
                extend: 'print',
                customize: function (win) {
                    $(win.document.body).css('font-size', '10pt');
                    var formattedTotal = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'PHP',
                        minimumFractionDigits: 2
                    }).format(totalUnitVal);

                    $(win.document.body).find('table')
                        .before('<h1 style="text-align:center;">REPORT ON THE PHYSICAL COUNT OF SEMI EXPENDABLE PROPERTY</h1>' +
                            '<p style="text-align:center;">___________________________________</p>' +
                            '<p style="text-align:center; margin-top:-1em">(Type of Property, Plant and Equipment)</p>' +
                            '<p><b>Fund Cluster:</b> <span>_________________</span></p>' +
                            '<p><b>For which ________________________,_________________________,_______________________is accountable, having assumed such accountability on (_____________________)</b></p>');

                    $(win.document.body).find('table tbody').append(
                        '<tr>' +
                        '<td colspan="4" style="text-align:right; font-weight:bold;">Total Unit Value:</td>' +
                        '<td style="font-weight:bold;">' + formattedTotal + '</td>' +
                        '<td colspan="7"></td>' +
                        '</tr>'
                    );

                    $(win.document.body).find('table').after(
                        '<table style="margin-top:80px; width:100%; text-align:center;">' +
                        '<tr>' +
                        '<td style="text-align:center;">Certified Corrected by:____________________<br>' +
                        '<span style="font-weight:bold; font-size:14px;">Signature over Printed Name of Inventory Committee Chair and Members</span></td>' +
                        '<td style="text-align:center;">Approved by:_____________________________<br>' +
                        '<span style="font-weight:bold; font-size:14px;">Signature over Printed Name of Head of Agency/Entity or Authorized Representative</span></td>' +
                        '<td style="text-align:center;">Verified by:_______________________<br>' +
                        '<span style="font-weight:bold; font-size:14px;">Signature over Printed Name of COA Representative</span></td>' +
                        '</tr>' +
                        '</table>'
                    );
                },
                orientation: 'landscape',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10]
                }
            }
        ],
        ajax: {
            url: "../getdata.php",
            type: "POST",
            data: function (e) {
                e.rpcppe_school = true;
                e.category = $('select.category_school').val();
                return e;
            },
            error: function (xhr, status, error) {
                console.log("Ajax request failed: " + xhr.responseText);
            }
        },
        columns: [
            { "data": "article_id" },
            {
                "data": null,
                "render": function (data, type, row) {
                    return '<div class="row">' +
                        '<div class="col">' + row.description + "  " +
                        '<strong>Model:</strong> ' + row.model +
                        '</div>' +
                        '<div class="col">' +
                        '<strong>SN:</strong> ' + row.asset_sn +
                        '</div>' +
                        '</div>';
                }
            },
            { "data": "property_no" },
            { "data": "unit_meas" },
            {
                "data": "unit_val",
                "render": function (data, type, row) {
                    var formattedValue = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'PHP',
                        minimumFractionDigits: 2
                    }).format(data);

                    return formattedValue;
                }
            },
            { "data": "qty_property_card" },
            { "data": "qty_physical_count" },
            { "data": "shortage_qty" },
            { "data": "shortage_value" },
            { "data": "date_acquired" },
            { "data": "remarks" },
            { "data": "fullname" },
        ],
        lengthMenu: [
            [10, 25, 50, 100000000],
            [10, 25, 50, 'ALL']
        ],
        drawCallback: function () {
            var api = this.api();

            totalUnitVal = api.column(4, { page: 'current' }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);

            var formattedTotal = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'PHP',
                minimumFractionDigits: 2
            }).format(totalUnitVal);

            $('#totalUnitMeas').html('Total: ' + formattedTotal);
        }
    });

   
    $("select.category_school, select.value").on('change', function () {
        var selectedCategory = $('select.category_school').val();

      
        table.ajax.url('../getdata.php?rpcsp=true&category=' + selectedCategory).load();
    });
    });


    $("#assetsch").select2({
        theme: "bootstrap4",
        placeholder: "Asset Type",
        ajax: {
            url: '../fetch1.php',
            dataType: 'json',
            type: 'POST',
            delay: 250,
            data: function(params) {
                return {
                    term: params.term,
                    asset1: true,
                    category_id: params.term 
                };
            },
            processResults: function(returnedData) {
                var mappedData = $.map(returnedData.data, function(fetch) {
                    return {
                        id: fetch.id,
                        text: fetch.category
                    };
                });
                return {
                    results: mappedData
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        templateResult: formatCategory,
        templateSelection: formatCategorySelection
    });
    
    
    $("#subassetsch").select2({
        placeholder: "Sub Asset",
        theme: "bootstrap4",
        dropdownParent: $("#editModalschool"),
        ajax: {
            url: '../fetch1.php',
            dataType: 'json',
            type: 'POST',
            delay: 250,
            data: function(params) {
                var selectedCategoryId = $('#assetsch').val(); 
                return {
                    term: params.term,
                    asset2: true,
                    category_id: selectedCategoryId 
                };
            },
            processResults: function(returnedData) {
                var mappedData = $.map(returnedData.data, function(fetch) {
                    return {
                        id: fetch.id,
                        text: fetch.sub_category
                    };
                });
                return {
                    results: mappedData
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        templateResult: formatCategory,
        templateSelection: formatCategorySelection
    });



