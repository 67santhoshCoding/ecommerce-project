@include('admin.layouts.header')

<div class="content-wrapper">
    <div class="main-panel">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">User Profile</h4>
                <form  autocomplete="off" id="regForm" action="{{ route('profile-save') }}" method="POST" enctype="multipart/form-data" >
                    @csrf
                <div class="form-group row">
                    <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Name<span class="text-danger">*</span> </label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="{{ $data->name }}" name="name" id="name" placeholder="Name">
                    </div>
                    <input type="hidden" name="id" value="{{ $data->id }}" >
                    </div>
                    <div class="form-group row">
                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="email" value="{{ $data->email }}" name="email" autocomplete="off" placeholder="Username">
                    </div>
                    </div>

                    <div class="form-group row">
                    <label for="exampleInputMobile" class="col-sm-3 col-form-label">Mobile</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="mobile" maxlength="10" value="{{ $data->mobile }}" name="mobile" placeholder="Mobile number">
                    </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">Profile</label>
                        <div class="col-sm-9 field">
                            <input type="file" class="form-control" id="files" name="files"  >
                        </div>
                    </div>
                    <?php if(!empty($data->profile) && isset($data->profile)){ ?>


                        <div style="margin-left:212px">
                            <span class="pip">
                                <img class="imageThumb" src="{{ asset('/'.$data->profile) }}" title="" alt="no img">
                            </span>
                            <br/>
                            <button class="remove" onclick="myFunction({{ $data->id }})" onclik="profileImageRemove({{ $data->id }})">Remove image</button>
                        </div>
                        
                        <?php } ?>
                    <div class="form-group row">
                    <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Old Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="old_password" autocomplete="old-password" name="old_password" placeholder="Old Password">
                    </div>
                    </div>
                    <div class="form-group row">
                    <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="password" autocomplete="new-password" name="password" placeholder="Password">
                    </div>
                    </div>
                    <div class="form-group row">
                    <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Re Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="confoirm_password" name="confoirm_password" placeholder="Confirm Password">
                    </div>
                    </div>
                    
                    <button id="submit" name="submit" type="submit"  style="float:right"    class="btn btn-primary me-2">Submit</button>
                    <!-- <button class="btn btn-light">Cancel</button> -->
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script>
        
        $("#regForm").on("submit",function(e){

            $("#regForm").validate({
                rules: {
                    name: "required",
                    email: {
                        required:true,
                        email:true,
                    },
                    mobile: {
                        required: true,
                        number:true,
                        minlength: 10,
                        maxlength:10,
                    },
                },
                messages: {
                    name: "Please enter your Name",
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 6 characters long"
                    },

                },
            });
            e.preventDefault();
            var form =  $('#regForm')[0];
            var formData = new FormData(form);
            var url = "{{ route('profile-save') }}" ;
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
                            location.reload(true);
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

        function myFunction(id) {
            var id = id;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            $.ajax ({
                type : "POST",
                url :"{{route('profile_image_remove')}}",
                data: {
                    "id":id,
                },
                success: function(responce) {
                    
                    if(responce.error == 0){
                        Swal.fire({
                        icon: 'success',
                        title: 'Image deleted successfully...',
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
            return false;
        }
    $(document).ready(function() {



  if (window.File && window.FileList && window.FileReader) {
    $("#files").on("change", function(e) {
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
            "</span>").insertAfter("#files");
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


});

</script>
@endsection
@include('admin.layouts.footer')
