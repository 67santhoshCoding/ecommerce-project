@include('admin.layouts.header')

<div class="content-wrapper">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            <h4 class="card-title">Category elements</h4>
            <form  autocomplete="off" method="POST" id="categoryForm" action="{{ route('category.add') }}"  enctype="multipart/form-data" >
                @csrf
                
                @include('admin.partials.product.category.addEdit')
                <div >
                    <button type="" id="submit" class="btn btn-primary me-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

@section('script')
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> --}}
<script>
$(document).ready(function() {
$('#category_name').select2();
$('.js-example-disabled-results').select2();

$('#is_parent').change(function(){
        if($("#is_parent").prop('checked') == true){
            $('#parentCategoryDiv').addClass('d-none');
        } else {
            $('#parentCategoryDiv').removeClass('d-none');
        }
    });

$("#categoryForm").on("submit",function(e){
    $("#categoryForm").validate({
            rules: {
                name: "required",
                
            },
            messages: {
                name: "Please enter your Name",
                parent_id:"Please select Parent Category",
            },
        });
        e.preventDefault();
            var form =  $('#categoryForm')[0];
            var formData = new FormData(form);
            var url = "{{ route('category.add') }}" ;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            $.ajax ({
                type : "POST",
                url :url,
                data:   formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function(responce) {
                    if(responce.error == 1)
                    {
                        Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: responce.message,
                    })
                    }
                    else if(responce.error == 0){
                    Swal.fire({
                        icon: 'success',
                        title: 'Profile update successfully...',
                        // showCancelButton: true,
                        confirmButtonText: 'Save',
                        }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('category')}}";
                        }
                    })

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

});

if (window.File && window.FileList && window.FileReader) {
        $("#image").on("change", function(e) {
            var files = e.target.files,
            filesLength = files.length;
            for (var i = 0; i < filesLength; i++) {
                var f = files[i]
                var fileReader = new FileReader();
                fileReader.onload = (function(e) {
                var file = e.target;
                $("<span class=\"pip\">" +
                    "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                    "<br/><span class=\"remove\">Remove image</span>" +
                    "</span>").insertAfter("#image");
                $(".remove").click(function(){
                    $(this).parent(".pip").remove();
                });

                // Old code here
                /*$("<img></img>", {
                    class: "imageThumb",
                    src: e.target.result,
                    title: file.name + " | Click to remove"
                }).insertAfter("#files").click(function(){$(this).remove();});*/

                });
                fileReader.readAsDataURL(f);
            }
            console.log(files);
        });
} else {
    alert("Your browser doesn't support to File API")
}

// if($('#is_feature').val())
// {
//     alert("yes")
// }
// else{
//     alert("no")
// }

});
</script>
@endsection

@include('admin.layouts.footer')

