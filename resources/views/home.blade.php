@extends('layouts.master')

@section('content')

<style type="text/css">
    .home-add-post{
      border: 1px solid #ccc;
      width: 100%;
      border-radius: 2px;
      margin-top: 20px;
      box-shadow: 5px 5px 10px 0px rgba(0, 0, 0, 0.1);
      max-width: 600px;
    }
    .home-add-post-title{
      border-bottom: 1px solid #eee;
      background: whitesmoke;
      padding: 7px 15px;
      font-size: 16px;
      color: #134563;
      font-weight: 600;
    }
    .home-add-post-inner{
      padding: 25px 60px;
    }
    .form-control[type="file"]{
      height: 43px;
    }
    .close-home-post{
      color: #134563;
      cursor: pointer;
      margin-left: auto;
      font-size: 13px;
    }
    .home-add-post .custom-select {
      background: #FFF url(downward-arrow.png) no-repeat center right 10px;
      display: block;
      width: 100% !important;
      padding: 5px 15px;
      border: #ced4da 1px solid;
      color: #565656;
      border-radius: 4px;
      cursor: pointer;
    }
</style>


<!--Begin : Create Post-->
<div class="create-post-wrap flex-column">
    <button class="btn btn-primary create-new-post ml-auto mr-auto" id="addNew">Create New Post</button>
    <div class="container ">
        <form id="createForm" class="row d-flex justify-content-center align-items-center" method="POST" enctype="multipart/form-data" data-parsley-validate>
            {!! csrf_field() !!}
            <div class="create-add-form home-add-post ">

              <div class="home-add-post-title d-flex">
                <div>
                  Create New Post
                </div>
                <div class="close-home-post">
                  <a class="close-home-post">Cancel</a>
                </div>
              </div>

              <div class="home-add-post-inner">

                <select name="post_type" id="post_type" required="" class="form-control">
                   <option value="">-- Choose a Post Type -- </option>
                   @foreach($post_types as $singleType)
                       <option value="{{ $singleType->id }}"> {{ $singleType->type }}</option>
                   @endforeach
                </select>

                <div class="outer-div">
                   <div class="tag-div mt-2">
                       <div class="custom-select" id="custom-select">- Choose Post Tags -</div>
                       <div id="custom-select-option-box">
                           <div class="custom-select-option">
                               <input onchange="toggleFillColor(this);"
                                   class="custom-select-option-checkbox" type="checkbox"
                                   name="tags[]" value="PHP" data-parsley-required="false"> PHP
                           </div>
                           <div class="custom-select-option">
                               <input onchange="toggleFillColor(this);"
                                   class="custom-select-option-checkbox" type="checkbox"
                                   name="tags[]" value="Python" data-parsley-required="false"> Python
                           </div>
                           <div class="custom-select-option">
                               <input onchange="toggleFillColor(this);"
                                   class="custom-select-option-checkbox" type="checkbox"
                                   name="tags[]" value="Android" data-parsley-required="false"> Android
                           </div>
                           <div class="custom-select-option">
                               <input onchange="toggleFillColor(this);"
                                   class="custom-select-option-checkbox" type="checkbox"
                                   name="tags[]" value="iOS" data-parsley-required="false"> iOS
                           </div>
                           <div class="custom-select-option">
                               <input onchange="toggleFillColor(this);"
                                   class="custom-select-option-checkbox" type="checkbox"
                                   name="tags[]" value="UI" data-parsley-required="false"> UI
                           </div>
                       </div>
                   </div>

                   <div class="content-div">
                       <input type="text" name="title" class="form-control mt-2 mb-2" id="title" placeholder="Enter Post Title" required="">
                       <textarea name="description" id="description" class="form-control mb-2" placeholder="Enter Post Description" required=""></textarea>
                       <input type="file" name="post_image" id="post_image"  class="form-control mt-2 mb-2">

                       <div class="d-flex ml-auto">
                         <button type="submit" id="submitBtn" class="btn btn-primary create-new-post ml-auto"> Create post </button>
                       </div>

                   </div>

                </div>


              </div>
            </div>
        </form>
    </div>
</div>

<!--End : Create Post-->

<!--Begin : Content Area-->
<div class="container category-selector">
    <div class="row">

        <div class="content-right-wrap">
            <div class="d-flex">

                <!-- <form class="form-inline all-category"> -->
                <div class="form-group mr-15 mb-2 category-option">
                    <label class="dropdown">
                        <select id="category-sel">
                            <option value="0" selected>All Categories</option>
                            <option value="1">Technical</option>
                            <option value="2">Non-Technical</option>
                            <option value="3">Polls</option>
                        </select>
                    </label>
                </div>
                <!-- </form> -->
            </div>
            <div class="newfeeds-container table-responsive">
                <table class="newsfeed-table">
                    <thead>
                        <tr>
                            <th>Topic</th>
                            <th class="replies">Comments</th>
                            <!-- <th class="views">Views</th> -->
                            <th class="activity">Activity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- APPEND -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!--End : Content Area-->


@stop

@section('custom_scripts')

<script type="text/javascript">

    var post_type;
    // var page_num = 0;
    var filter_type = $("#category-sel").val();

    $(document).ready(function() {

        loadPosts();

        // Create New Button click event
        $("#addNew").click(function(){
            $(".create-add-form").show();
            $(this).hide();
        });

        $(".close-home-post").click(function(){
            $(".home-add-post").hide();
            $("#addNew").show();
        });

        // Tags on change event
        $('body').on('change','#post_type',function(){

            post_type = $(this).val();
            if(! post_type){
                toastr.error('Please select a Post Type');
                toggleDivs('hide');
                return false;
            }

            if(post_type == '1'){
                toggleDivs('show');
            } else{
                $(".tag-div").hide();
                $(".content-div").show();
                $(".outer-div").show();
            }
        });

        $("#category-sel").change(function(){
            filter_type = $(this).val();
            loadPosts();
        });

        // Create form submission event
        $("form#createForm").submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: base_url+'/posts/create',
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if(data.status){
                        toastr.success('Post created successfully');
                        toggleDivs('hide');
                        $(".createForm").hide();
                        $("form#createForm")[0].reset();
                        $("form#createForm").parsley().reset();

                        loadPosts();
                    }
                }
            });
        });


        // CUSTOM SELECT BOX CSS
        $("body").on("click", "#custom-select" ,function(){
            $("#custom-select-option-box").toggle();
        });
        $("body").on("click", ".custom-select-option" ,function(){
            var checkboxObj = $(this).children("input");
            $(checkboxObj).prop("checked",true);
            toggleFillColor(checkboxObj);
        });
        $("body").on("click",function(e){
            if(e.target.id != "custom-select" && $(e.target).attr("class") != "custom-select-option") {
                $("#custom-select-option-box").hide();
            }
        });
        // CUSTOM SELECT BOX CSS
    });


    // LOAD MAIN POSTS
    function loadPosts(){
        $.ajax({
            url: base_url+'/posts/loadPosts',
            type: 'POST',
            data: {
                filter_type: filter_type,
                _token: CSRF_TOKEN
            },
            success: function (data) {
                if(data.status){
                    $(".newsfeed-table tbody").empty().append(data.renderer);
                }
            }
        });
    }


    // CUSTOM SELECT BOX CSS
    function toggleFillColor(obj) {
        $("#custom-select-option-box").show();
        if($(obj).prop('checked') == true) {
            $(obj).parent().css("background",'#c6e7ed');
        } else {
            $(obj).parent().css("background",'#FFF');
        }
    }

    // SHOW/HIDE DIV HELPER
    function toggleDivs(type){
        if(type == 'show'){
            $(".tag-div").show();
            $(".content-div").show();
            $(".outer-div").show();
        } else{
            $(".tag-div").hide();
            $(".content-div").hide();
            $(".outer-div").hide();
        }
    }
</script>

@endsection