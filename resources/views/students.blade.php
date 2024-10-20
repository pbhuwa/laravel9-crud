@php
    // dd($data);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD operation in laravel using AJAX</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="row m-5 p-4 rounded-3 shadow-lg p-3 mb-5 bg-white rounded">
            <h1 class="card-title">Student list</h1>
            <div class="col-md-8"></div>
            <div class="col-md-4 float-right">
                <a class="btn btn-success" href="javascript:void(0)" id="creteNewStudent">Add Student</a>
            </div>
            <table class="table table-bordered data-table border border-light">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            </div>
        </div>
        <div class="modal fade" id="ajaxModel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalHeading"></h4>
                    </div>
                    <div class="modal-body">
                      
                        <form action="" method="POST" id="studentForm" name="studentForm" class="form-horizontal">
                            @csrf
                            <input type="hidden" name="student_id" id="student_id">
                            <div class="form-group">
                                Name: <br>
                                <input type="text" id="name" name="name" placeholder="Enter Name" value="" required>
                            </div>
                            <div class="form-group">
                                Email: <br>
                                <input type="email" id="email" name="email" placeholder="Enter Email" value="" required>
                            </div>
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</body>
    <script type="text/javascript">
    $(function(){
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        })
        var table = $(".data-table").DataTable({
            serverSide:true,
            processing:true,
            ajax:"{{ route('students.index') }}",
            columns:[
                {data:'DT_RowIndex',name:'DT_RowIndex'},
                {data:'name',name:'name'},
                {data:'email',name:'email'},
                {data:'action',name:'action'}
            ]
        });
        $("#creteNewStudent").click(function(){
            $('#student_id').val('');
            $('#studentForm').trigger('reset');
            $('#modalHeading').html('Add student');
            $('#ajaxModel').modal('show');
        });
        $("#saveBtn").click(function(e){
            e.preventDefault();
            $(this).html('Save');

            $.ajax({
                data:$('#studentForm').serialize(),
                url:'{{ route('students.store') }}',
                type:'POST',
                dataType:'json',
                success:function(data){
                    alert(data.success);
                    $("#studentForm").trigger('reset');
                    $("#ajaxModel").modal('hide');
                    table.draw();
                },
                error:function(data){
                    console.log('Error:',data);
                    $('#saveBtn').html('Save')
                }
            });
        });
        $('body').on('click','.deleteStudent',function(){
            var student_id = $(this).data('id');
            confirm('Are you sure want to delete!');
            $.ajax({
                type:'POST', 
                url:'{{ URL('students/destroy') }}'+'/'+student_id,
                success:function(data){
                    table.draw();
                },
                error:function(data){
                    console.log('Error:',data);
                }
            });
        });
        $('body').on('click','.editStudent',function(){
            var student_id = $(this).data('id');
            $.post('{{ URL('students/edit') }}'+'/'+student_id,function(data){
                $('#modalHeading').html('Edit Student');
                $('#ajaxModel').modal('show');
                $('#student_id').val(data.id);
                $('#name').val(data.name);
                $('#email').val(data.email);
            });
        });
    });
    </script>
</html>