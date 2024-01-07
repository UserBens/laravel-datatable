<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    {{-- css datatable --}}
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
</head>

<body>
    <div class="container">
        <h1>Student List</h1>
        <a class="btn btn-success mb-3" href="javascript:void(0)" id="createNewStudent">Add</a>
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="studentForm" name="studenForm" class="form-horizontal">
                        <input type="hidden" name="student_id" id="student_id">
                        <div class="form-group">
                            Name: <br>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter Name" value="" required>
                        </div>

                        <div class="form-group mt-2">
                            Email: <br>
                            <input type="text" class="form-control" id="email" name="email"
                                placeholder="Enter Email" value="" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3" id="saveBtn" value="create">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    {{-- bootstrap js --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    {{-- js datatable --}}
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

</body>

<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $(".data-table").DataTable({
            serverSide: true,
            processing: true,
            ajax: "{{ route('student.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ]
        });

        $("#createNewStudent").click(function() {
            $("#student_id").val('');
            $("#studentForm").trigger('reset');
            $("#modalHeading").html("Add Student");
            $('#ajaxModel').modal('show');
        });

        $("#saveBtn").click(function(e) {
            e.preventDefault();
            $(this).html('Save');

            $.ajax({
                data: $("#studentForm").serialize(),
                url: "{{ route('student.store') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $("#studentForm").trigger('reset');
                    $('#ajaxModel').modal('hide');
                    table.draw();
                },
                error: function(data) {
                    console.log('error', data);
                    $("#saveBtn").html('Save');
                }
            });
        });

        $('body').on('click', '.deleteStudent', function() {
            var student_id = $(this).data("id");
            confirm("Sure Want To Delete?");
            $.ajax({
                type: "DELETE",
                url: "{{ route('student.store') }}" + '/' + student_id,
                success: function(data) {
                    table.draw();
                },
                error: function(data) {
                    console.log('Error', data);
                }
            });
        });

        $('body').on('click', '.editStudent', function() {
            var student_id = $(this).data('id');
            $.get("{{ route('student.index') }}" + "/" + student_id + "/edit", function(data) {
                $("#modalHeading").html("Edit Student");
                $('#ajaxModel').modal('show');
                $("#student_id").val(data.id);
                $("#name").val(data.name);
                $("#email").val(data.email);
            });
        });

    });
</script>

</html>
