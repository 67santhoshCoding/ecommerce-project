<script>
    function openForm(model_type, id=''){
        // alert(model_type)
        // alert(id)

    }
    
    function categoryDeleteData (id)
    {
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
        Swal.fire({
            title: 'Do you want to Delete the data?',
            showDenyButton: true,
            // showCancelButton: true,
            confirmButtonText: 'Yes',
            denyButtonText: `No`,
            }).then((result) => {
                if (result.isConfirmed) {
                $.ajax ({
                type : "POST",
                url :"{{route('category.delete')}}",
                data: {
                    "id":id,
                },
                success: function(responce) {
                    if(responce.error == 0){
                        $('.data-table').DataTable().ajax.reload();
                    }
                    else{
                        Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: "Somthing went wrong!",
                    })
                    }
                }
            });
            Swal.fire('Profile Deleted Successfully!', '', 'success')
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        })
    }
   
    function categoryStatus (id)
    {
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
        Swal.fire({
            title: 'Do you want to Change the status?',
            showDenyButton: true,
            confirmButtonText: 'Yes',
            denyButtonText: `No`,
            }).then((result) => {
                if (result.isConfirmed) {
                $.ajax ({
                type : "POST",
                url :"{{route('category.status')}}",
                data: {
                    "id":id,
                },
                success: function(responce) {
                    $('.data-table').DataTable().ajax.reload();
                }
            });
            Swal.fire('Profile Deleted Successfully!', '', 'success')
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        })
    }
</script>