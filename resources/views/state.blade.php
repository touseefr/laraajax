<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" referrerpolicy="no-referrer" />
  <title>Document</title>
</head>

<body>
  <div class="container">
    <h1 class="text-center">Laravel Ajax Crud operation</h1>
    <hr>
    <div class="row">
      <div class="col-6 offset-3 mt-3">
        <form action="" id="myform">
          <li class="alert alert-danger d-none" id="save_errorlist"></li>
          <div class="form-group">
            <label for="">Seleect State</label>
            <select name="state_id" class="form-control">
              @foreach($states as $state)
              <option value="{{ $state->id }}">{{ $state->state_name }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="">City Name</label>
            <input type="text" name="city_name" id="city_name" class="form-control">
            <small class="text-danger" id="city_name_error"></small>
          </div>
          <div class="form-group">
            <label for="">Image</label><br>
            <input type="file" name="image" id="file">
            <div>
              <small class="text-danger" id="image_error"></small>
            </div>
          </div>

          <button id="submit" class="btn btn-success">Add</button>
        </form>
      </div>
    </div>
    <hr>
    <button><a href="/bin">Bin</a></button>
    <div class="row">
      <div class="col">
        <table id="cities" class="table table-bordered">
          <thead>
            <tr>
              <th>Id</th>
              <th>image</th>
              <th>city</th>
              <th>state</th>
              <th>status</th>
              <th>edit</th>
              <th>delete</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="post" id="formedit" enctype="multipart/form-data">
              @csrf
              <!-- input hidden field -->
              <input type="hidden" name="id">
              <div class="form-group">
                <label for="">Seleect State</label>
                <select name="edit_state_id" class="form-control">
                  @foreach($states as $state)
                  <option value="{{ $state->id }}">{{ $state->state_name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label for="">City Name</label>
                <input type="text" name="edit_city_name" id="edit_city_name" value="{{ $state->city_name }}" class="form-control">
                <small class="text-danger" id="edit_city_name_error"></small>
              </div>
              <label for="">select status</label>
              <select name="edit_status" id="">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
              <!-- <div id="edit_img">

                            </div> -->

              <div class="form-group">
                <label for="">update Image</label><br>
                <input type="file" name="ed_image">
                <div>
                  <small class="text-danger" id="image_error"></small>
                </div>
              </div>

            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" id="update" class="btn btn-primary">Update</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</body>

</html>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>

<script>
  $(document).ready(function() {
    //  alert("fime");
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    //img preview
    // function filePreview(input) {
    //     if (input.files && input.files[0]) {
    //         var reader = new FileReader();
    //         reader.onload = function(e) {
    //             $('#myform + img').remove();
    //             $('#myform').after('<img src="' + e.target.result + '" width="320" height="190"/>');
    //         };
    //         reader.readAsDataURL(input.files[0]);
    //     }
    // }

    // $("#file").change(function() {
    //     filePreview(this);
    // });

    $('#submit').click(function(e) {
      e.preventDefault();
      let formdat = new FormData($('#myform')[0]); //also imgaes with text
      $.ajax({
        url: "/addcity",
        type: "Post",
        contentType: false,
        processData: false,
        //data: $('#myform').serialize(),
        data: formdat,
        success: function(response) {
          if (response.status == 400) {
            // $('#save_errorlist').html('');
            // $('#save_errorlist').removeClass('d-none');
            $.each(response.errors, function(key, value) {
              //$('#save_errorlist').append('<li>' + err_value + '<li/>')
              $('#' + key).addClass('is-invalid');
              $('#' + key + '_error').text(value[0]);
            })
            // var errors=$.parseJSON(response.errors)
            // console.log('erere',errors)
          } else {
            console.log(response);
            Swal.fire({
              icon: 'success',
              title: 'Congrats',
              text: 'Data Added Successfully',
            })
            // $('#save_errorlist').html('');
            // $('#save_errorlist').addClass('d-none');
            onsuccess();
            //  $('#'+key).removeClass('is-invalid');
            //  $('#'+key+'_error').text('')
            $('#myform')[0].reset();
            table.ajax.reload();
          }
        },
        error: function() {
          console.log("erroerss");
        },
      });
    })

    function onsuccess() {
      $('#city_name').removeClass('is-invalid');
      //$('#city_name').val('');
      $('#city_name_error').text('')
      $('#image_error').text('')
    }
    //data display on data table
    var table = $('#cities').DataTable({
      processing: true,
      //   serverSide: true,
      ajax: {
        url: "/getcities",
        type: "post"
      },
      columns: [{
          "data": "id"
        },
        {
          render: function(data, type, row) {
            return `<img src="cities/${row.image}" class="img-thumbnail rounded"  width="20" height="90"  /> `
          }
        },
        {
          "data": "city_name"
        },
        {
          "data": "state_name"
        },

        {
          "data": null,
          render: function(data, type, row) {
            if (row.status == 'active') {
              return `<button class="btn btn-success">Active</button>`;
            } else {
              return `<button class="btn btn-secondary">Inactive</button>`;
            }
          }
        },
        {
          "data": null,
          render: function(data, type, row) {
            return `<button data-id="${row.id}" id="edit" data-toggle="modal" data-target="#exampleModal"  class="btn btn-info"><i class='fa fa-edit'></i></button>`;
          }
        },
        {
          "data": null,
          render: function(data, type, row) {
            return `<button data-id="${row.id}" id="delete" class="btn btn-danger"><i class='fa fa-trash'></i></button>`;
          }
        }
      ]
    });
    //display data table 2nd method
    //      var table = $('#users-table').DataTable({
    //     processing: true,
    //     serverSide: true,
    //     ajax: 'https://datatables.yajrabox.com/eloquent/row-details-data',
    //     columns: [
    //         {
    //             "className":      'details-control',
    //             "orderable":      false,
    //             "searchable":     false,
    //             "data":           null,
    //             "defaultContent": ''
    //         },
    //         {data: 'id', name: 'id'},
    //         {data: 'name', name: 'name'},
    //         {data: 'email', name: 'email'},
    //         {data: 'created_at', name: 'created_at'},
    //         {data: 'updated_at', name: 'updated_at'}
    //     ],
    //     order: [[1, 'asc']]
    // });
    //edit code goes here....
    $(document).on('click', '#edit', function() {
      $.ajax({
        url: '/getCityById',
        type: "post",
        dataType: 'json',
        data: {
          "_token": "{{ csrf_token() }}",
          "id": $(this).data('id')
        },
        success: function(response) {
          $('input[name="id"]').val(response.data.id);
          $('select[name="edit_state_id"]').val(response.data.state_id);
          $('input[name="edit_city_name"]').val(response.data.city_name);
          $('select[name="edit_status"]').val(response.data.status);
          //$('#edit_img').html(response.data.image);
          $('#edit_img').html('<img src="cities' + '/' + response.data.image + '" alt="something" class="img-thumbnail rounded" heigth="3"/>');
          console.log(response.data);
        }
      })
    });
    //udpate code goes here
    $(document).on('click', '#update', function() {
      // let formdara=new FormData($('#formedit')[0]);
      Swal.fire({
        title: 'Do you want to save the changes?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: `Save`,
        denyButtonText: `Don't save`,
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {

          let formd = new FormData($('#formedit')[0]); //also imgaes with text
          $.ajax({
            url: '/update',
            type: 'post',
            processData: false,
            contentType: false,
            //    cache: false,
            dataType: 'json',
            data: formd,
            success: function(response) {
              if (response.status == 400) {
                // $('#save_errorlist').html('');
                // $('#save_errorlist').removeClass('d-none');
                console.log('erupdateere')
                $.each(response.errors, function(key, value) {
                  //$('#save_errorlist').append('<li>' + err_value + '<li/>')
                  $('#' + key).addClass('is-invalid');
                  $('#' + key + '_error').text(value[0]);
                })
                // var errors=$.parseJSON(response.errors)
                console.log('erupdateere')
              } else {
                console.log('yes');
                Swal.fire('Saved!', '', 'success')
              }
            },
            error : function(reject)
            {
              console.log(opperr);
            }
          })


        } else if (result.isDenied) {
          Swal.fire('Changes are not saved', '', 'info')
        }
      })

    })
    //delete code goes here...
    $(document).on('click', '#delete', function() {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {

          $.ajax({
            url: '/delete',
            type: 'get',
            dataType: 'json',
            data: {
              'id': $(this).data('id')
            },
            success: function(response) {
              console.log(response);
            }
          })
          table.ajax.reload();
          Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          )
        }
      })
    })

  })
</script>