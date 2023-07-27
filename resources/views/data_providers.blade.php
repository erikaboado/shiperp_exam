<!DOCTYPE html>
<html lang="en">
<head>
    <title>Project - Data Providers</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ url('/') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
</head>
<body>
  
    <div class="container">
        <h2 class="text-center mt-5 mb-3">ShipERP Exam - Data Providers</h2>
        <div class="card">
            <div class="card-header">
                <button class="btn btn-outline-primary" onclick="createDataProvider()">
                    Create New Record
                </button>
            </div>
            <div class="card-body">
                <div id="alert-div">
                 
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>URL</th>
                            <th width="240px">Action</th>
                        </tr>
                    </thead>
                    <tbody id="dataproviders-table-body">
                         
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  
    <!-- modal for creating and editing function -->
    <div class="modal" tabindex="-1"  id="form-modal">
        <div class="modal-dialog" >
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Provider Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="error-div"></div>
                <form>
                    <input type="hidden" name="update_id" id="update_id">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="url">URL:</label>
                        <input type="text" class="form-control" id="url" name="url">
                    </div>
                 
                    <button type="submit" class="btn btn-outline-primary mt-3" id="save-dataprovider-btn">Save</button>
                </form>
            </div>
            </div>
        </div>
    </div>
 
  
    <!-- view record modal -->
    <div class="modal" tabindex="-1" id="view-modal">
        <div class="modal-dialog" >
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="data-provider-name">Data Provider Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <b>Data Provider URL:</b>
                    <p id="url-info"></p>
                </div>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Response key of image URL</span>
                    </div>

                    <input type="text" class="form-control" id="image-key" name="image-key" value="message">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" onclick="triggerDataProvider()">Trigger API</button>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <img src="../loading-thinking.gif" id="imageurl-info" class="img-responsive" style="max-height:250px;"/>
                    <div id="api-response"></div>
                </div>
            </div>
            </div>
        </div>
    </div>
  
    <script type="text/javascript">
  
        showAllDataProviders();
     
        /*
            This function will get all the data provider records
        */
        function showAllDataProviders()
        {
            let url = $('meta[name=app-url]').attr("content") + "/data_providers";

            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    $("#dataproviders-table-body").html("");
                    let dataproviders = response.data_providers;

                    for (var i = 0; i < dataproviders.length; i++) {
                        let showBtn =  '<button ' +
                            ' class="btn btn-outline-info" ' +
                            ' onclick="showDataProvider(' + dataproviders[i].id + ')">Show' +
                        '</button> ';
                        let editBtn =  '<button ' +
                            ' class="btn btn-outline-success" ' +
                            ' onclick="editDataProvider(' + dataproviders[i].id + ')">Edit' +
                        '</button> ';
                        let deleteBtn =  '<button ' +
                            ' class="btn btn-outline-danger" ' +
                            ' onclick="destroyDataProvider(' + dataproviders[i].id + ')">Delete' +
                        '</button>';
     
                        let dataProviderRow = '<tr>' +
                            '<td>' + dataproviders[i].name + '</td>' +
                            '<td>' + dataproviders[i].url + '</td>' +
                            '<td>' + showBtn + editBtn + deleteBtn + '</td>' +
                        '</tr>';
                        $("#dataproviders-table-body").append(dataProviderRow);
                    }
                     
                },
                error: function(response) {
                    console.log(response.responseJSON)
                }
            });
        }
     
        /*
            check if form submitted is for creating or updating
        */
        $("#save-dataprovider-btn").click(function(event){
            event.preventDefault();

            if ($("#update_id").val() == null || $("#update_id").val() == "") {
                storeDataProvider();
            } else {
                updateDataProvider();
            }
        })
     
        /*
            show modal for creating a record and
            empty the values of form and remove existing alerts
        */
        function createDataProvider()
        {
            $("#alert-div").html("");
            $("#error-div").html("");
            $("#update_id").val("");
            $("#name").val("");
            $("#url").val("");
            $("#form-modal").modal('show');
        }
     
        /*
            create new record
        */
        function storeDataProvider()
        {
            $("#save-dataprovider-btn").prop('disabled', true);
            let url = $('meta[name=app-url]').attr("content") + "/data_providers";
            let data = {
                name: $("#name").val(),
                url: $("#url").val(),
            };

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "POST",
                data: data,
                success: function(response) {
                    $("#save-dataprovider-btn").prop('disabled', false);

                    let successHtml = '<div class="alert alert-success" role="alert"><b>Data Provider successfully created</b></div>';
                    $("#alert-div").html(successHtml);
                    $("#name").val("");
                    $("#url").val("");

                    showAllDataProviders();
                    $("#form-modal").modal('hide');
                },
                error: function(response) {
                    $("#save-dataprovider-btn").prop('disabled', false);
     
                    /*
                    show validation error
                    */
                    if (typeof response.responseJSON.errors !== 'undefined') {
                        let errors = response.responseJSON.errors;
                        let urlValidation = "";
                        if (typeof errors.url !== 'undefined') {
                            urlValidation = '<li>' + errors.url[0] + '</li>';
                        }
                        
                        let nameValidation = "";
                        if (typeof errors.name !== 'undefined') {
                            nameValidation = '<li>' + errors.name[0] + '</li>';
                        }
                        
                        let errorHtml = '<div class="alert alert-danger" role="alert">' +
                            '<b>Validation Error!</b>' +
                            '<ul>' + nameValidation + urlValidation + '</ul>' +
                        '</div>';

                        $("#error-div").html(errorHtml);
                    }
                }
            });
        }
     
        /*
            edit record function
        */
        function editDataProvider(id)
        {
            let url = $('meta[name=app-url]').attr("content") + "/data_providers/" + id ;

            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    let dataprovider = response.data_provider;
                    $("#alert-div").html("");
                    $("#error-div").html("");
                    $("#update_id").val(dataprovider.id);
                    $("#name").val(dataprovider.name);
                    $("#url").val(dataprovider.url);
                    $("#form-modal").modal('show');
                },
                error: function(response) {
                    console.log(response.responseJSON)
                }
            });
        }
     
        /*
            sumbit the form and will update a record
        */
        function updateDataProvider()
        {
            $("#save-dataprovider-btn").prop('disabled', true);
            let url = $('meta[name=app-url]').attr("content") + "/data_providers/" + $("#update_id").val();
            let data = {
                id: $("#update_id").val(),
                name: $("#name").val(),
                url: $("#url").val(),
            };

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "PUT",
                data: data,
                success: function(response) {
                    $("#save-dataprovider-btn").prop('disabled', false);

                    let successHtml = '<div class="alert alert-success" role="alert"><b>Data Provider successfully updated</b></div>';

                    $("#alert-div").html(successHtml);
                    $("#name").val("");
                    $("#url").val("");

                    showAllDataProviders();
                    $("#form-modal").modal('hide');
                },
                error: function(response) {
                    /*
                        show validation error
                    */
                    $("#save-dataprovider-btn").prop('disabled', false);
                    if (typeof response.responseJSON.errors !== 'undefined') {
                        console.log(response)
                        let errors = response.responseJSON.errors;
                        let urlValidation = "";

                        if (typeof errors.url !== 'undefined') {
                            urlValidation = '<li>' + errors.url[0] + '</li>';
                        }

                        let nameValidation = "";
                        if (typeof errors.name !== 'undefined') {
                            nameValidation = '<li>' + errors.name[0] + '</li>';
                        }
         
                        let errorHtml = '<div class="alert alert-danger" role="alert">' +
                            '<b>Validation Error!</b>' +
                            '<ul>' + nameValidation + urlValidation + '</ul>' +
                        '</div>';
                        $("#error-div").html(errorHtml);
                    }
                }
            });
        }

        /*
            get and display the record info on modal
        */
        function showDataProvider(id)
        {
            $("#url-info").html("");
            $("#imageurl-info").attr("src", "");

            let url = $('meta[name=app-url]').attr("content") + "/data_providers/" + id + "";

            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    let dataprovider = response.data_provider;
                    $("#data-provider-name").html(dataprovider.name);
                    $("#url-info").html(dataprovider.url);
                    $("#view-modal").modal('show');
                },
                error: function(response) {
                    console.log(response.responseJSON)
                }
            });
        }

        /*
            trigger data provider and display image
        */
        function triggerDataProvider()
        {
            $("#imageurl-info").attr("src", "");
            let url = document.getElementById("url-info").innerHTML;

            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    let dataprovider = response;
                    let image_key = $("#image-key").val();

                    if (typeof dataprovider[image_key] === 'undefined') {
                        var api_response = JSON.stringify(dataprovider);
                        alert('Incorrect key for image url. \n\nAPI Response: ' + api_response);
                    }

                    $("#imageurl-info").attr("src", dataprovider[image_key]);
                },
                error: function(response) {
                    console.log(response.responseJSON)
                    var api_response = JSON.stringify(response);

                    alert('Something went wrong!\n\nResponse: ' + api_response);
                }
            });
        }

        /*
            delete record function
        */
        function destroyDataProvider(id)
        {
            let url = $('meta[name=app-url]').attr("content") + "/data_providers/" + id;
            let data = {
                name: $("#name").val(),
                url: $("#url").val(),
            };

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "DELETE",
                data: data,
                success: function(response) {
                    let successHtml = '<div class="alert alert-success" role="alert"><b>Data Provider successfully deleted</b></div>';
                    $("#alert-div").html(successHtml);
                    showAllDataProviders();
                },
                error: function(response) {
                    console.log(response.responseJSON)
                }
            });
        }
     
    </script>
</body>
</html>
