@extends('layouts.master')

@section('content')

<!--Begin : Create Post-->
<div class="create-post-wrap">
    <button class="btn btn-primary create-new-post" id="addNew">Create New Post</button>
</div>

<div class="container">
    <form id="createForm" method="POST" enctype="multipart/form-data" data-parsley-validate>
        {!! csrf_field() !!}
        <div class="create-add-form">
            <select name="post_type" id="post_type" required="">
               <option value="">-- Choose a Post Type -- </option>
               @foreach($post_types as $singleType)
                   <option value="{{ $singleType->id }}"> {{ $singleType->type }}</option>
               @endforeach
            </select>

            <div class="outer-div">
               <div class="tag-div">
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
                   <input type="text" name="title" id="title" placeholder="Enter Post Title" required="">
                   <textarea name="description" id="description" placeholder="Enter Post Description" required=""></textarea>
                   <input type="file" name="post_image" id="post_image">
                   <button type="submit" id="submitBtn"> SUBMIT </button>
               </div>

            </div>
        </div>
    </form>
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
        });

        //Poll Submission
        $('body').on('click','.poll-submit-btn',function(){

            var $this = $(this);
            var post_id = $this.attr('data-post_id');
            var option_id = $('.choosed-poll-option').val();

            $.ajax({
                url: base_url+'/posts/submitpoll',
                type: 'POST',
                data: {
                    post_id,
                    option_id,
                    _token: CSRF_TOKEN
                },
                success: function (data) {
                    if(data.status){
                        $this.parent().parent().children('.poll-container').remove();
                        $this.parent().parent().append(data.renderer);
                        $this.remove();
                    }
                }
            });

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