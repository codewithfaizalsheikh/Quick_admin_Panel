

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
        crossorigin="anonymous"></script>

</head>

<body>
    <h1>Hello, world!</h1>

    <div id="SuccessMessage"></div>


    <!-- Add Student Modal -->
    


    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>User Detail
                            <a href="#" class="btn btn-primary float-end btn-sm" data-bs-toggle="modal"
                                data-bs-target="#AddStudentModal">Add User</a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <table class="table">
                            <thead>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                            </thead>

                            <tbody>

                            </tbody>

                        </table>


                    </div>
                </div>
            </div>
        </div>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {

            fetchUser();

            function fetchUser() {
                $.ajax({
                    type: 'get',
                    url: 'api/v1/fetch',
                    dataType: "json",
                    success: function(response) {
                        console.log(response.user);
                        $('tbody').html('')
                        $.each(response.user, function(key,item){
                            $('tbody').append('<tr>\
                                        <td>' + item.id + '</td>\
                                        <td>' + item.name + '</td>\
                                        <td>' + item.email + '</td>\
                                        <td><button type="button" class="edit_user btn btn-primary btn-sm" value="' +item.id + '" id="edit">Edit</button>\
                                            <button type="button" class="view_user btn btn-info btn-sm" value="' +item.id + '" id="edit">view</button>\
                                            <button type="button"class="delete_user btn btn-danger btn-sm"  value="' +item.id + '" id="delete">Delete</button>\
                                        </td>\
                                        </tr>');
                        })

                    }
                });
  
            }
            $(document).on('click', '.delete_user', function(e) {
                    e.preventDefault();
                    var user_id = $(this).val();
                    console.log(user_id);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    
                    $.ajax({
                        type: 'delete',
                        url: 'api/v1/delete/'+user_id,
                        success: function(response) {
                            console.log(response); 
                            fetchUser();
                           
                        }
                    })  
                });


                $(document).on('click','.view_user',function(e){
                    e.preventDefault();
                    var user_id = $(this).val();
                    console.log(user_id);

                    var url = "{{ route('admin.users.show','') }}"+'/'+user_id;

                   


                })





        })
    </script>



</body>

</html>






