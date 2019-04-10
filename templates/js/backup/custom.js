jQuery.noConflict()(function($) {


    /*-------------------------------------REVIEW-------------------------------------*/
    $('.give_rating .star').hover(function () {         
        var rate_val = $(this).data('rv');         
        $(this).prevAll().andSelf().removeClass('grey');     
        $(this).nextAll().addClass('grey');
         $('.rate').val(rate_val);
         
    }, function () {});	
    
    $('.star').click(function (){
        var rv = $(this).data("rv");  
        $('.rate').val(rv);
    });
    
    
    /*-------------------------------------FILE_UPLOAD-------------------------------------*/
   /* $(document).on('fileselect', ':file', function (event, numFiles, label) {
        var input = $(this).parents('.file_upload').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;

        if (input.length) {
            input.val(log);
        } else {
            if (log) alert(log);
        }
    });
    
    $(document).on('change', ':file', function () {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });*/

    /*-------------------------------------ANNIMATION_WAYPOINT-------------------------------------*/


    /*-------------------------------------SELECT_SUBJECT-------------------------------------*/
    $('.image_box').bind('click', function () {
        var fullVidHght = 0;
        var liMarBottom = 0;
        var liPos = 0;
        var liPosition = 0;
        var liHeight = 0;
        var liexMar = 0;
        var liPosAll = 0;
        var liPositionAll = 0;
        //alert(liMarBottom);	
        fullVidHght = parseInt($(this).siblings().height());
        $('.image_list > ul > li').css('margin-bottom', 20);
        liMarBottom = parseInt($(this).parent().css('margin-bottom'));
        $('.image_list > ul > li').css('margin-bottom', liMarBottom);
        $('.test_full').hide();
        $('.test_full').css('top', 0);
        $('.test_pointer').hide();
        $('.image_box').removeClass('active');
        $(this).addClass('active');
        liPos = $(this).parent().position();
        liPosition = liPos.top;
        liHeight = parseInt($(this).parent().height());

        liexMar = liMarBottom + fullVidHght;

        $('.image_list > ul > li').each(function () {
            liPosAll = $(this).position();
            liPositionAll = liPosAll.top;
            if (liPositionAll == liPosition) {
                $(this).css('margin-bottom', liexMar + 20);
            }
        });

        $(this).siblings().css('top', liPosition + liHeight + liMarBottom);
        $(this).siblings().show();
        $(this).children().siblings('.test_pointer').show();
        var target = $(this).siblings();
        var targetOffset = ($(target).offset().top) - 140;
        $('html, body').animate({
            scrollTop: (targetOffset)
        }, 400);

        //player.stopVideo();
        $('.image_list ul li').find("iframe").each(function () {
            var src = $(this).attr('src');
            $(this).attr('src', src);
        });
    });
    
    $('.message .close_msg').on('click', function () {   
        var smArr = [];
        $(this).parent('.message').removeClass('active');  
        if($('.message').hasClass('errovrly')==false){
            setTimeout(function () {
                $('.overlay_msg').fadeOut();
                $('.overlay_msg').removeClass('blakish');
                $('body').removeClass('fixedbody');   
            }, 600);
        }
        $('.message').removeClass('errovrly');        
    });
    /*#signupform, */
    $('#loginform, #forgotpasswordform, #changepasswordform').unbind('submit').bind('submit', function (e) {
        e.preventDefault();
        var formData    = $(this).serialize();
        
        var link        = $(this);
        var btnval      = link.find(".animate_btn").val();
        
        var btnwidth  = link.find(".animate_btn").outerWidth();
        var btnheight = link.find(".animate_btn").outerHeight();
        link.find(".animate_btn").css({
            'transition': '0s'
        });
        link.find(".animate_btn").attr('disabled', 'disabled');
        link.find(".animate_btn").val('...').css({
            "background": "#009fd1",
            "color": "#ffffff",
            "box-shadow": "0 0 0 0"
        });
        link.find(".animate_btn").animate({
            width: "54px",
            height: "54px",
            borderRadius: "30px"
        }, {
            duration: 50,
            complete: function () {
                link.find('.animate_btn').addClass('spin').css('transition', '.5s');
                //Ajax Call starts

                $.ajax({
                    url: SITE_LOC_PATH + "/modules/dashboard/action.php",
                    type: "POST",
                    data: formData,
                    cache: false,
                    success: function (result) {

                       var result = JSON.stringify(result)

                        // var result = JSON.parse(result);

                        link.find('.animate_btn').addClass('complete');

                        setTimeout(function ()
                        {
                            var cls = (result['type'] == 1) ? 'finalsuccess' : 'finalerror';
                            link.find('.animate_btn').addClass(cls).trigger('classChange');
                        }, 50);

                        link.find('.animate_btn').unbind('classChange').bind('classChange', function ()
                        {
                            var clr = (result['type'] == 1) ? '#6DD741' : '#E8261A';
                            setTimeout(function () {
                                link.find('.animate_btn').removeClass('spin complete finalsuccess finalerror').addClass('goback').css({
                                    'background': clr,
                                    'color': "#ffffff",
                                    'border-color': clr
                                }).val(result['msg']).trigger('classChange2');
                            }, 80);
                        });

                        link.find('.animate_btn').unbind('classChange2').bind('classChange2', function () {
                            setTimeout(function ()
                            {

                                if (result['redirect'] != '') {
                                    window.location.href = 'http://www.annexis.net/dashboard/';
                                }

                                if (result['type'] == 1) {
                                    link[0].reset();
                                } else {
                                    link.find('.animate_btn').removeClass('goback').val(btnval).css({
                                        'width': btnwidth,
                                        'height': btnheight,
                                        'background': '#009fd1',
                                        'color': "#ffffff",
                                        'border-color': '#009fd1',
                                        'border-radius': '6px',
                                        'box-shadow': '1px 1px 5px #ccc'
                                    }).stop().animate({}, {
                                        complete: function () {
                                            link.find('.animate_btn').removeAttr('disabled')
                                        }
                                    });

                                }
                            }, 300);
                        });

                    }
                });

                //Ajax Call ends
            }
        });
    });
    
    $('#change_password_form').on('submit', function (e) {
        e.preventDefault();
        var frm = $(this);
        frm.find('button[type="submit"]').addClass('clicked');
        var data = frm.serialize();
        $.ajax({
            url: MODULE_PATH + "/dashboard/action.php",
            type: "POST",
            data: data,
            cache: false,
            success: function (result) {
                var result = result.split('>');
                frm.find('button[type="submit"]').removeClass('clicked');
                misteryMessage(result[1], result[0]);
                
                if (result[0] == 'success') 
                    frm[0].reset();
                    
                /*var link2 = link.find('.alrtMsg');
                link2.html(result);
                if(link2.children('span').hasClass('success'))
                    link.find('input[type="password"]').val('');*/
            }
        });
    });


    //-------------
    
    /*-------------------------------------READMORE-------------------------------------*/
    
    jQuery.noConflict()(function($){
        $(".testimonialrotator").testimonialrotator({
            settings_slideshowTime:3
        });
    });

    if(PAGETYPE=='testimonials')
    {        
        var requestUri = window.location.href; 
        requestUri = requestUri.replace(SITE_LOC_PATH, "");
        requestArray = requestUri.split('='); 
        $(".h-padding").each(function(){
            if($(this).attr("data-id")==requestArray[1])
            {
                $("html, body").animate({scrollTop:$(this).offset().top-50}, 800);
                return false;
            }
        });
    }
    
     $('#contact_form').unbind('submit').bind('submit', function (e) {
        e.preventDefault();
        var formData    = $(this).serialize();
        var link        = $(this);
        var btnval      = link.find(".animate_btn").val();
        
        var btnwidth  = link.find(".animate_btn").outerWidth();
        var btnheight = link.find(".animate_btn").outerHeight();
        link.find(".animate_btn").css({
            'transition': '0s'
        });
        link.find(".animate_btn").attr('disabled', 'disabled');
        link.find(".animate_btn").val('').css({
            "background": "#009fd1",
            "box-shadow": "0 0 0 0"
        });
        link.find(".animate_btn").animate({
            width: "54px",
            height: "54px",
            borderRadius: "30px"
        }, {
            duration: 50,
            complete: function () {
                link.find('.animate_btn').addClass('spin').css('transition', '.5s');
                //Ajax Call
                $.ajax({
                    url: MODULE_PATH + "/communication/action.php",
                    type: "POST",
                    data: formData,
                    cache: false,
                    success: function (result) {
                        var result = JSON.stringify(result);
                        link.find('.animate_btn').addClass('complete');

                        setTimeout(function () {
                            var cls = (result['type'] == 1) ? 'finalsuccess' : 'finalerror';
                            link.find('.animate_btn').addClass(cls).trigger('classChange');
                        }, 50);

                        link.find('.animate_btn').unbind('classChange').bind('classChange', function () {
                            var clr = (result['type'] == 1) ? '#6DD741' : '#E8261A';
                            setTimeout(function () {
                                link.find('.animate_btn').removeClass('spin complete finalsuccess finalerror').addClass('goback').css({
                                    'background': clr,
                                    'border-color': clr
                                }).val(result['msg']).trigger('classChange2');
                            }, 80);
                        });

                        link.find('.animate_btn').unbind('classChange2').bind('classChange2', function () {
                            setTimeout(function () {
                                if (result['redirect'] != '')
                                    window.location.href = result['redirect'];

                                if (result['type'] == 1) {
                                    link[0].reset();
                                } else {
                                    link.find('.animate_btn').removeClass('goback').val(btnval).css({
                                        'width': btnwidth,
                                        'height': btnheight,
                                        'background': '#009fd1',
                                        'border-color': '#009fd1',
                                        'border-radius': '6px',
                                        'box-shadow': '1px 1px 5px #ccc'
                                    }).stop().animate({}, {
                                        complete: function () {
                                            link.find('.animate_btn').removeAttr('disabled')
                                        }
                                    });

                                }
                            }, 3000);
                        });

                    }
                });
                //Ajax Call
            }
        });
    });
    
       
    // study material upload
    $(document).on('submit', '#uplddc, #signupform', function(e){
        e.preventDefault();
        var frm = $(this);
        var btn = frm.find('button');
        btn.addClass('clicked');
        
        var formData = new FormData(frm[0]);
        
        $.ajax({
            url: MODULE_PATH + "/dashboard/action.php",
            type: 'POST',
            data: formData,
            mimeType: "multipart/form-data",
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
            cache: false,
            success: function(data){
                btn.removeClass('clicked');
                var result = data.split('>');
                
                if(result[0]=='success'){
                    frm[0].reset();
                    $('.selClg').html('');
                }
                
                misteryMessage(result[1], result[0]);
            }
        });
    });

    
    $('.img_browse').click(function(e){
        e.preventDefault();
        
        $.ajax({
            url: SITE_LOC_PATH+'/request/',
            type: 'POST',
            data:{'ajx':1, 'page':'browse'},
            success: function(response){
                misteryMessageAjax(response, '');
                
                $('#dpfid').on('change', function (e) {
                    var files = e.target.files;

                    processFileUpload(files);
                    return false;
                });
            }
        });
    });
    
    $('.message-ajax').on('click', '.autosuggest li', function(e){
        e.stopPropagation();
        var ins = $(this).find('.subheading').text();
        $(this).parents('.autosuggest').find('.suggest').val(ins);
        $(this).parents('.autosuggest').find('.track').val($(this).data('track'));
        $(this).parents('.autosuggest').find('.autosearch').html('');
    });
    
    $('.message-ajax').on('blur', '.autosuggest .suggest', function(){
        var track = $(this).siblings('.track').val().trim();
        if(track==''){
            $(this).val('');
        }
    });
    
    $('.edit_setting').click(function(e){
        e.preventDefault();
        
        $(this).parents('ul').find('.focused').removeClass('focused');
        $(this).parents('ul').find('.edit_data').removeClass('edit_data');
        $(this).parents('ul').find('.setting_input').hide();
        
        $(this).parents('li').addClass('focused');
        $(this).parents('.setting_info').addClass('edit_data');
        
        var input = $(this).parents('.setting_info').find('.setting_input'),
            spanVal = input.siblings('span').text();
        input.val(spanVal);
        input.val('').val(spanVal).animate({
            width: 'toggle'
        }, 300).focus();
    });
    
    $('.cancel_setting').click(function(e){
        e.preventDefault();
        
        $(this).parents('li').removeClass('focused');
        $(this).parents('.setting_info').removeClass('edit_data');
        $(this).parents('li').find('.setting_input').hide();
    });
    
    $('.save_setting').on('click', function(e){
        e.preventDefault();
        var btn    = $(this);
        btn.addClass('clicked');
        var update = btn.data('update');
        var input  = btn.parents('.setting_info').find('.setting_input').val();
        $.ajax({
            url     :   MODULE_PATH + "/dashboard/action.php",
            type    :   'POST',
            data    :   {ajax:1, update:update, input: input, SourceForm: 'PrfUpdt'},
            
            success :   function(response){
                btn.removeClass('clicked');
                
                var result = response.split('>');
                misteryMessage(result[1], result[0]);
                if(result[0] == 'success') {                    
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                }
            }
        });
    });
    $('#gallery-1').royalSlider({
        fullscreen: {
          enabled: true,
          nativeFS: true
        },
        controlNavigation: 'thumbnails',
        autoScaleSlider: true, 
        autoScaleSliderWidth: 960,     
        autoScaleSliderHeight: 850,
        loop: false,
        imageScaleMode: 'fit-if-smaller',
        navigateByClick: true,
        numImagesToPreload:2,
        arrowsNav:true,
        arrowsNavAutoHide: true,
        arrowsNavHideOnTouch: true,
        keyboardNavEnabled: true,
        fadeinLoadedSlide: true,
        globalCaption: true,
        globalCaptionInside: false,
        thumbs: {
          appendSpan: true,
          firstMargin: true,
          paddingBottom: 4
        }
  });
    
    $(document).on('click', '.addnewProduct', function(){
        // alert('inside add product');
        var clickedBtn = $(this);
        clickedBtn.addClass('clicked');
        var valP    = $(this).val();
        valP.split('>');
        var id_company = valP[0];
       
        $.ajax({
            url: SITE_LOC_PATH+'/request/',
            type: 'POST',
            data:{'ajx':1, 'id_company':id_company, 'page':'addproductType'},
            success: function(response){ 
                clickedBtn.removeClass('clicked');
                $('#sadrzaj').html(response);
              $("html, body").animate({scrollTop:$('#sadrzaj').offset().top-50}, 800);
            }
        });

        // this.producttype();
    });
    
    // $(document).on('click', '.proType', function(){
    //     var clickedBtn = $(this);
    //     clickedBtn.addClass('clicked');
    //     var valP    = $(this).val();
    //     var uid     = $(this).attr('data-uid');
    //     var cmpid   = $(this).attr('data-cmpid');       
    //     $.ajax({
    //         url: SITE_LOC_PATH+'/request/',
    //         type: 'POST',
    //         data:{'ajx':1, 'cmpid':cmpid, 'proType':valP, 'page':'addproduct'},
    //         success: function(response){ console.log(response);
    //             clickedBtn.removeClass('clicked');
    //             $('#sadrzaj').html(response);
    //            $("html, body").animate({scrollTop:$('#sadrzaj').offset().top-50}, 800);
                
    //              /*------------------------------------------------*/
    
    //             $('#tags_1').tagsInput({
    //               width:'100%',
    //               height:'34px',
    //               placeholderColor:'inherit'
    //             });

    //             function onAddTag(tag) {
    //               alert("Added a keyword: " + tag);
    //             }
    //             function onRemoveTag(tag) {
    //               alert("Removed a keyword: " + tag);
    //             }
    //             function onChangeTag(input,tag) {
    //               alert("Changed a keyword: " + tag);
    //             }
    //             /*------------------------------------------------*/
    //         }
    //     });
    // });

    // $(document).on('click', '.prType', function(){
    //     var clickedBtn = $(this);
    //     clickedBtn.addClass('clicked');
    //     var valP    = $(this).val();
    //     var uid     = $(this).attr('data-uid');
    //     var cmpid   = $(this).attr('data-cmpid');  
    //     //alert(valP+"-"+uid+"-"+cmpid);
    //     $.ajax({
    //         url: SITE_LOC_PATH+'/request/',
    //         type: 'POST',
    //         data:{'ajx':1, 'cmpid':cmpid, 'prType':valP, 'page':'company'},
    //         success: function(response){ console.log(response);
    //          //alert(response);
    //             clickedBtn.removeClass('clicked');
    //             $('#sadrzaj').html(response);
    //             // //$("html, body").animate({scrollTop:$('#sadrzaj').offset().top-50}, 800);
                
    //         }
    //     });
    // });

    $(document).on('click','.productType', function producttype(){

        // alert('inside productType');

        var clickedBtn = $(this);
        clickedBtn.addClass('clicked');
        var valP    = $(this).val();
        var uid     = $(this).attr('data-uid');
        var cmpid   = $(this).attr('data-cmpid');
        $.ajax({
            url: SITE_LOC_PATH+'/request/',
            type: 'POST',
            data:{'ajx':1, 'cmpid':cmpid, 'productType':valP, 'page':'addproduct'},
            success: function(response){ console.log(response);
                clickedBtn.removeClass('clicked');
                $('#sadrzaj').html(response);
                $("html, body").animate({scrollTop:$('#sadrzaj').offset().top-50}, 800);

                /*------------------------------------------------*/

                $('#tags_1').tagsInput({
                    width:'100%',
                    height:'34px',
                    placeholderColor:'inherit'
                });

                function onAddTag(tag) {
                    alert("Added a keyword: " + tag);
                }
                function onRemoveTag(tag) {
                    alert("Removed a keyword: " + tag);
                }
                function onChangeTag(input,tag) {
                    alert("Changed a keyword: " + tag);
                }
                /*------------------------------------------------*/



            }
        });
    });

    $(document).on('change','#p_category',function(){
        var val    = $(this).val();
        var option = '';
        $.ajax({
            url: SITE_LOC_PATH+'/request/',
            type: 'POST',
            data:{'categoryId':val,'page':'category','ajx':1},
            cache: false,
            success: function(data){ 
                var html = '';
                if(data){
                    $('.categoryDetails').html(data);  
                    
                }            
            }
        });
    });
    
    $("#p_category").trigger("change");
        
    /*------------------------------------------------------*/
   function readURL(input) {

       // var $input = input;
        //var $newinput =  $(this).parent().find('.portimg');
        //alert("hii");
        if (input.files && input.files[0]) {

            var reader = new FileReader();
            reader.onload = function (e) {

                reset($(input).siblings('.dvPreview').next('br').next('.delbtn'), true);
                reset($(input).siblings('.dvPreview').next('br'), true);
                var $log = $(input).siblings('.dvPreview');
              // var  str = "<img src=" +e.target.result+" >";
              // var html = $($.parseHTML(str)).attr({height:50,width:50});
               $log.attr('src', e.target.result).show();
              //$log.append( html );
                //reset($newinput.next('.delbtn'), true);
                // $newinput.attr('src', e.target.result).show();
              $log.after('<br><input type="button" class="delbtn removebtn" value="remove">');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }



$(document).on('change','.fileUpload', function()
{
readURL(this);
});

 $(document).on('click', '.delbtn', function (e) {
        reset($(this));
    });

 function reset(elm, prserveFileName) {
        if (elm && elm.length > 0) {
            $(elm).prev('br').prev('.dvPreview').attr('src', '').hide();
            $(elm).prev('br').hide();
            if (!prserveFileName) {
                 $(elm).parent().parent().find('input.fileUpload ').val("");
                //input.fileUpload and input#uploadre both need to empty values for particular div
            }
            elm.remove();
        }
    }

 /*------------------------------------------------------*/


 function profileReadURL(input) {

       
        if (input.files && input.files[0]) {

            var reader = new FileReader();
            reader.onload = function (e) {

                // reset($(input).siblings('.dvPreview').next('br').next('.delbtn'), true);
                // reset($(input).siblings('.dvPreview').next('br'), true);
                var $log = $(input).prev('.profileDiv').find('.profilePreview');
               $log.attr('src', e.target.result).show();
              //$log.append( html );
                //reset($newinput.next('.delbtn'), true);
                // $newinput.attr('src', e.target.result).show();
              //$log.after('<br><input type="button" class="delbtn removebtn" value="remove">');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

$(document).on('change','.profilePicUpload', function()
{

profileReadURL(this);


});


/*------------------------------------------------------*/
    
    $(document).on('keyup', '#sampleName', function(){         
        
        var srcTxt    = $(this).val();
        var len       = $(this).val().length;
        
        if(len>0){
            var companyId = $(this).attr('data-comp');
            $.ajax({
                url: SITE_LOC_PATH+'/request/search-product/',
                type: 'POST',
                data:{'srcTxt':srcTxt,'companyId':companyId},
                cache: false,
                success: function(data){ 
                    var html = '';
                    if(data=='[]'){                        
                        html = '<input type="file" name="proimg">';
                        $('#proImg').html(html);                           
                        $('.tagpanel').html('');
                        $('.tagpanel').prepend('<input name="p_keyword" id="tags_1" type="text" class="form-control tags" required="" value="">');
                        
                        $('#range1').val('');
                        $('#range2').val(''); 
                        $('#pdesc').find('textarea').html('');
                        $('.categoryDetails').html(''); 
                        
                        $('select[name="currency"]').removeAttr("selected");               
                        $('select[name="unitType"]').removeAttr("selected");               
                        $('select[name="p_category"]').removeAttr("selected");  
                        
                        $('input[name="p_keyword"]').tagsInput({
                          width:'100%',
                          height:'34px',
                          placeholderColor:'inherit'
                        });

                        function onAddTag(tag) {
                          alert("Added a keyword: " + tag);
                        }
                        function onRemoveTag(tag) {
                          alert("Removed a keyword: " + tag);
                        }
                        function onChangeTag(input,tag) {
                          alert("Changed a keyword: " + tag);
                        }
                        
                    }
                    else{
                        
                        var obj = jQuery.parseJSON(data); 

                        html = '<ul id="product-name">';
                        $.each(obj, function(key, value) {
                            html += '<li data-id="'+value.id+'" data-name="'+value.p_name+'" data-img="'+value.p_photo+'" data-keywd="'+value.p_keyword+'" data-desc="'+value.p_bdes+'" data-currncy="'+value.p_price+'" data-range1="'+value.range1+'" data-range2="'+value.range2+'" data-cid="'+value.p_category+'" data-uType="'+value.p_ctype+'" data-qty="'+value.p_capaacity+'">'+value.p_name+'</li>';
                        });
                        html += '</ul>';                    
                        $('#smname').html(html);   
                    }            
                }
            }); 
        }
        else{
            
            html = '<input type="file" name="proimg">';
            $('#proImg').html(html);   
            
            $('.tagpanel').html('');
            $('.tagpanel').prepend('<input name="p_keyword" id="tags_1" type="text" class="form-control tags" required="" value="">');
            
            $('#qty').val('');
            $('#range1').val('');
            $('#range2').val('');  
            $('#pdesc').find('textarea').html('');
            $('.categoryDetails').html('');   
            
            $('select[name="currency"]').removeAttr("selected");               
            $('select[name="unitType"]').removeAttr("selected");               
            $('select[name="p_category"]').removeAttr("selected");               
            
            $('input[name="p_keyword"]').tagsInput({
              width:'100%',
              height:'34px',
              placeholderColor:'inherit'
            });

            function onAddTag(tag) {
              alert("Added a keyword: " + tag);
            }
            function onRemoveTag(tag) {
              alert("Removed a keyword: " + tag);
            }
            function onChangeTag(input,tag) {
              alert("Changed a keyword: " + tag);
            }
        }
        
       
    }); 
    
    $(document).on('click', '#product-name li', function(){ 
        var proid   =  $(this).attr('data-id');
        var proNm   =  $(this).attr('data-name');
        var img     =  $(this).attr('data-img');
        var keywd   =  $(this).attr('data-keywd');
        var desc    =  $(this).attr('data-desc');
        var currncy =  $(this).attr('data-currncy');
        var range1  =  $(this).attr('data-range1');
        var range2  =  $(this).attr('data-range2');
        var cid     =  $(this).attr('data-cid');
        var uType   =  $(this).attr('data-uType');
        var qty     =  $(this).attr('data-qty');
                    
        var imgLink = '';
        
        if(img=='')     {   
            html = '<img src="'+TMPL_PATH+'/images/noimage.jpg" alt="'+proNm+'" width="120px" height="120px"><input type="file" name="proimg">';
        }
        else{
            html = '<img src="'+MEDIA_FILES_SRC+'/product/large/'+img+'" alt="'+proNm+'" width="120px" height="120px"><input type="hidden" name="proImg" value="'+img+'">';
        }    
        
        $('#proid').val(proid);
        $('#sampleName').val(proNm);
        $('#proImg').html(html);
                
        $('.tagpanel').html('');
        
        $('.tagpanel').prepend('<input name="p_keyword" id="tags_1" type="text" class="form-control tags" required="" value="'+keywd+'" style="display: none;">');
        
        $('#qty').val(qty);
        $('#range1').val(range1);        
        $('#range2').val(range2);        
        var cnt = currncy;
        cnt = $.trim(cnt);
        $('select[name="currency"]').val(cnt);       
        var uTyp = uType;
        uTyp = $.trim(uTyp);
        $('select[name="unitType"]').val(uTyp); 
        $('select[name="p_category"]').val(cid);        
        
        $('#pdesc').find('textarea').html(desc);
        $('#pdesc').append('<input type="hidden" name="proCid" value="'+cid+'">');        
        
        $("#p_category").trigger("change");
        /*-------------------------*/
        
        $('input[name="p_keyword"]').tagsInput('destroy');
        
        /*$('input[name="p_keyword"]').tagsInput({
          width:'100%',
          height:'34px',
          placeholderColor:'inherit'
        });*/
        
        function onAddTag(tag) {
          alert("Added a keyword: " + tag);
        }
        function onRemoveTag(tag) {
          alert("Removed a keyword: " + tag);
        }
        function onChangeTag(input,tag) {
          alert("Changed a keyword: " + tag);
        }
        /*-------------------------*/
    });    
    
    $(document).on('keyup', '#uto', function(){         
        
        var srcTxt    = $(this).val();
        var len       = $(this).val().length;
        
        if(len>0){
            var cid = $(this).attr('data-cid');
            $.ajax({
                url: SITE_LOC_PATH+'/request/search-tomail/',
                type: 'POST',
                data:{'srcTxt':srcTxt,'cid':cid},
                cache: false,
                success: function(data){ 
                    var html = '';
                    if(data=='[]'){  
                        $('#utoId').val('');       
                        $('#uto').val('');   
                        $('#uphone').val('');
                        $('#uemail').val(''); 
                    }
                    else{
                        
                        var obj = jQuery.parseJSON(data); 

                        html = '<ul id="to-name">';
                        $.each(obj, function(key, value) {
                            html += '<li data-id="'+value.contactID+'" data-name="'+value.name+'" data-phone="'+value.phone+'" data-email="'+value.email+'" data-address="'+value.address+'" data-country="'+value.country+'">'+value.name+' - '+value.country+'</li>';
                        });
                        html += '</ul>';                    
                        $('#umail').html(html);   
                    }            
                }
            }); 
        }
        else{   
            $('#utoId').val('');   
            $('#uto').val('');   
            $('#uphone').val('');
            $('#uemail').val('');  
            $('#uadd').val('');  
        }       
    }); 
    
    $(document).on('click', '#to-name li', function(){ 
        var utoId   =  $(this).attr('data-id');
        var uto     =  $(this).attr('data-name');
        var uphone  =  $(this).attr('data-email');
        var uemail  =  $(this).attr('data-phone');
        var uadd  =  $(this).attr('data-address');
        
        $('#utoId').val(utoId);
        $('#uto').val(uto);
        $('#uphone').val(uphone);
        $('#uemail').val(uemail);  
        $('#uadd').val(uadd);  
    });  
    
    $(document).click(function(){
      $('.autosearch').html('');  
    });     
    
    $(document).on('submit', '#address,#sampledata,#editsampledata,#addQty,#sendsample,#reqSend', function(e){ 
        e.preventDefault();
        var frm = $(this);
        var btn = frm.find('button');
        btn.addClass('clicked');
        
        var formData = new FormData(frm[0]);
        
        $.ajax({
            url: MODULE_PATH + "/dashboard/action.php",
            type: 'POST',
            data: formData,
            mimeType: "multipart/form-data",
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
            cache: false,
            success: function(result){               
                
                btn.removeClass('clicked');
                $('.errMsg').html(result);   
                 setTimeout(function () {
                     if($(result).hasClass('successmsg'))
                        location.reload(); 
                    else
                        $('.errMsg').html(''); 
                }, 1900);
            }
        });
    });
    
    /*-------------------------------------PRODUCT_QTY-------------------------------------*/
    var get = 0,
        sum = 0;
    $(document).on('click','.add_value', function(){ 
        get = parseInt($(this).parent('.qty_block').children('.qty_input').val());
        if (isNaN(get)) {
            $(this).parent('.qty_block').children('.qty_input').val(1);
            return false;
        }
        sum = get + 1;
        $(this).parent('.qty_block').children('.qty_input').val(sum);
    });
    $(document).on('click','.minus_value', function(){
        get = parseInt($(this).parent('.qty_block').children('.qty_input').val());
        if (isNaN(get)) {
            $(this).parent('.qty_block').children('.qty_input').val(0);
            return false;
        }
        sum = get - 1;
        if (sum < 1) {
            $(this).parent('.qty_block').children('.qty_input').val(1);
            return false;
        }
        $(this).parent('.qty_block').children('.qty_input').val(sum);
    });
    $(document).on('keyup','.qty_input, .qtyinput', function(){
        if (this.value.match(/[^0-9]/g)) {
            this.value = this.value.replace(/[^0-9]/g, '');
        }
    });
    $(document).on('blur','.qty_input', function(){
        if (($(this).val() == "") || ($(this).val() == 0)) {
            $(this).val('1');
        }
    });
    /*---------------------------------------------------------------------*/
            
    $(document).on('click', '.newAddress, .addSample, .addqty', function(){
        var clickedBtn = $(this);
        clickedBtn.addClass('clicked');
        var valP       = $(this).val(); 
        var id_company = $(this).attr('data-val');
        var pge        = $(this).attr('data-page');
        
        $.ajax({
        url: SITE_LOC_PATH+'/request/',
        type: 'POST',
        data:{'ajx':1, 'id_company':id_company, 'valP':valP, 'page':pge},
        success: function(response){ console.log(response);
            clickedBtn.removeClass('clicked');
            $('#sadrzaj').html(response);
            //if(pge=='addsample'){
                $("html, body").animate({scrollTop:$('#sadrzaj').offset().top-50}, 800);
            //}
            
            $('#tags_1').tagsInput({
                  width:'100%',
                  height:'34px',
                  placeholderColor:'inherit'
              });

            function onAddTag(tag) {
              alert("Added a keyword: " + tag);
            }
            function onRemoveTag(tag) {
              alert("Removed a keyword: " + tag);
            }
            function onChangeTag(input,tag) {
              alert("Changed a keyword: " + tag);
            }            
            
        }
        });
    });
    $(document).on('click', '.formClose',function(){
         $('#sadrzaj').html('');
    });
    
    $(document).on('click','.sendSample',function(){
        window.location.href= SITE_LOC_DASH_PATH+"/samples/send-to/";
    });
    
    $(document).on('click', '.addShow', function(){
        var clickedBtn = $(this);
        clickedBtn.addClass('clicked');
        var addId = $(this).attr('data-id'); 
        var sidebar = $(this).attr('data-side'); 
       
        $.ajax({
        url: SITE_LOC_PATH+'/request/',
        type: 'POST',
        data:{'ajx':1, 'addId':addId, 'sidebar':sidebar, 'page':'showsidebar'},
        success: function(response){
            clickedBtn.removeClass('clicked');            
                 setTimeout(function () {
                    $('.sadrzaj').html(response);   
                    location.reload(); 
                }, 2500);
        }
        });
    });    
    
    $(document).on('click', '.editproductshow, .editAddress, .editSample, .viewSample, .viewhistory', function(){
        var clickedBtn = $(this);
        clickedBtn.addClass('clicked');
        var pId = $(this).attr('data-id');
        var pge = $(this).attr('data-page');
        var proType = $(this).attr('data-type');
        $.ajax({
            url: SITE_LOC_PATH+'/request/',
            type: 'POST',
            data:{'ajx':1, 'pId':pId, 'proType':proType, 'page':pge},
            success: function(response){
                clickedBtn.removeClass('clicked');
                $('#sadrzaj').html(response);
                
                $("html, body").animate({scrollTop:$('#sadrzaj').offset().top-50}, 800);
                /*------------------------------------------------*/
    
                $("#p_category").trigger("change");
                
                $('#tags_1').tagsInput({
                      width:'100%',
                      height:'34px',
                      placeholderColor:'inherit'
                  });

                function onAddTag(tag) {
                  alert("Added a keyword: " + tag);
                }
                function onRemoveTag(tag) {
                  alert("Removed a keyword: " + tag);
                }
                function onChangeTag(input,tag) {
                  alert("Changed a keyword: " + tag);
                }
                /*------------------------------------------------*/
                
            }
        });
    });
           /*...............................................*/

 
    $(document).on('click', '.previewProduct', function(){

     var clickedBtn = $(this);
     clickedBtn.addClass('clicked');
     var name =$("#productdata").find("#p_name").val();
     var image =$("#productdata").find("#image1").next(".dvPreview").attr('src');
     var image1 =$("#productdata").find("#image11").next(".dvPreview").attr('src');
     var image2 =$("#productdata").find("#image21").next(".dvPreview").attr('src');
     var image3 =$("#productdata").find("#image31").next(".dvPreview").attr('src');
     var image4 =$("#productdata").find("#image41").next(".dvPreview").attr('src');
     var image5 =$("#productdata").find("#image51").next(".dvPreview").attr('src');
     var p_price =$("#productdata").find("#p_price").val();
    // var p_bdes =$("#productdata").find("#p_bdes").val();
    // alert(p_bdes);
       var range1 =$("#productdata").find("#range1").val();
        var range2 =$("#productdata").find("#range2").val();
         var paymenttype =$("#productdata").find("#pt").find('input[type=radio]:checked').val();
          var p_min_quanity =$("#productdata").find("#p_min_quanity").val();
          var p_delivertytime0 =$("#productdata").find("#p_delivertytime0").val();
          var p_delivertytime1 =$("#productdata").find("#p_delivertytime1").val();
          var p_delivertytime = p_delivertytime0+''+p_delivertytime1;
         
          var json = {'p_name':name,'image':image,'image1':image1,'image2':image2,'image3':image3,'image4':image4,'image5':image5,'p_price':p_price,
            'range1':range1,'range2':range2,'paymenttype':paymenttype,'p_min_quanity':p_min_quanity,'p_delivertytime':p_delivertytime}; 
       var test = JSON.stringify(json); 

         $.ajax({
            url: SITE_LOC_PATH+'/request/',
            type: 'POST',
            data:{'ajx':1, 'page':'previewProduct','data':test},
            success: function(response){ 
                clickedBtn.removeClass('clicked');
                $('#myModal').modal('show'); 
                $('.modal-body').html(response);
              //$("html, body").animate({scrollTop:$('#previewPro').offset().top-50}, 800);
            }
       });

    });


/*...............................................*/
$(document).on("click",".viewmsz",function() {
        
         var clickedBtn = $(this);
        clickedBtn.addClass('clicked');
        var contactID = $(this).attr('data-id'); 
        var page = $(this).attr('data-page'); 
         $.ajax({
            url: SITE_LOC_PATH+'/request/',
            type: 'POST',
            data:{'ajx':1, 'contactID':contactID, 'page':page},
            success: function(response){
                clickedBtn.removeClass('clicked');
                $('.msg_box').html(response);
                  $('.msg_box').toggleClass('active');
              //  $("html, body").animate({scrollTop:$('#showmail').offset().top-50}, 800);
            }
        });
       
              
    });
 
$(document).on("click",".back", function(){
   $('.msg_box').removeClass('active');
});



 /*...............................................*/


    $(document).on('click', '.viewreq,.viewsamplereq', function(){
        var clickedBtn = $(this);
        clickedBtn.addClass('clicked');
        var pId = $(this).attr('data-id'); 
        var page = $(this).attr('data-page'); 
        $.ajax({
            url: SITE_LOC_PATH+'/request/',
            type: 'POST',
            data:{'ajx':1, 'pId':pId, 'page':page},
            success: function(response){
                clickedBtn.removeClass('clicked');
                $('#sadrzaj').html(response); 
                $("html, body").animate({scrollTop:$('#sadrzaj').offset().top-50}, 800);
            }
        });
    });

 /*...............................................*/

    $(document).on('click', '.replymsz', function(){
        
        var clickedBtn = $(this);
        clickedBtn.addClass('clicked');
        var contactID = $(this).attr('data-id'); 
        var page = $(this).attr('data-page'); 
        var userid = $(this).attr('data-userid'); 
        var username = $(this).attr('data-name'); 
         var subject = $(this).attr('data-subject'); 
        $.ajax({
            url: SITE_LOC_PATH+'/request/',
            type: 'POST',
            data:{'ajx':1, 'contactID':contactID, 'page':page, 'userid':userid, 'username':username, 'subject':subject},
            success: function(response){
                clickedBtn.removeClass('clicked');
                 $('#myMszModal').modal('show'); 
                $('.modal-body').html(response);
                // $('#sadrzaj').html(response); 
                // $("html, body").animate({scrollTop:$('#sadrzaj').offset().top-50}, 800);
            }
        });
    });






 /*...............................................*/
 
    
    $(document).on('click', '.nextPro', function(){
    $(this).addClass('clicked');
    var uid = $(this).val();
    var formData = $('form').serialize();
    $.ajax({
        type: 'post',
        url : MODULE_PATH + "/dashboard/action.php",
        data: formData,
        success: function (data) {
            $(this).removeClass('clicked');
            var result = JSON.stringify(data);

            if(result['error'] == 1){
                $('.errMsg').html('<div class="errormsg">'+result['msg']+'</div">'); 
                location.reload();
            }     
            else{
                $('.errMsg').html('<div class="successmsg">'+result['msg']+'</div">');            
                setTimeout(function () {
                    //if(result['redirect'] != '')
                        window.location.href = SITE_LOC_PATH+'/dashboard/products/';
                },600);         
            }    

        }
      });
    });      
    
//**********************************************************//
 $(document).on('click', '.UpPrf', function(){
        $(this).addClass('clicked');
       var form = $('#user_form')[0];
       var data = new FormData(form);
        $.ajax({
            url : MODULE_PATH + "/dashboard/action.php",    
           type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            success: function (response) {
                $(this).removeClass('clicked');

                   var result=JSON.parse(response.trim('\\uFEFF\\'));

                    if(result['error'] == 1){
                    $('.errMsg').html('<div class="errormsg">'+result['msg']+'</div">'); 
                    location.reload();
                }     
                else{
                    $('.errMsg').html('<div class="successmsg">'+result['msg']+'</div">');            
                    setTimeout(function () {
                   window.location.href = SITE_LOC_PATH+'/dashboard/accounts-settings.php/'
                    },1000);         
                } 

            }
          });
    });  


//********************************************************************//

    $(document).on('submit', '#companydata', function(e){
                
       $('.sendcompanyData').addClass('clicked');
		var data = new FormData(this);  
		$.ajax({
            url: MODULE_PATH + "/dashboard/action.php",
			type: 'POST',
			data: data,
			processData: false,
			contentType: false,
			success: function(response){
            $('.sendcompanyData').removeClass('clicked');
            //console.log(response.trim('\\uFEFF\\'));
            //alert(response);
            
            var result=JSON.parse(response.trim('\\uFEFF\\'));

                    if(result['error'] == 1){
                    $('.errMsg').html('<div class="errormsg">'+result['msg']+'</div">'); 
                    location.reload();
                }     
                else{
                    $('.errMsg').html('<div class="successmsg">'+result['msg']+'</div">');            
                    setTimeout(function () {
                    location.reload();
                    },1000);         
                } 


			}
		});
		e.preventDefault();
	});   
    
    
    $(document).on('submit', '#productdata, #proDataEdit', function(e){
        var frm = $(this);
        var btn = frm.find('button');
        btn.addClass('clicked');
		var data = new FormData(this);        
		$.ajax({
            url: MODULE_PATH + "/dashboard/action.php",
			type: 'POST',
			data: data,
			processData: false,
			contentType: false,
			success: function(result){
                btn.removeClass('clicked');
                var result = JSON.stringify(result);
                if(result['error'] == 1){
                    $('.errMsg').html('<div class="errormsg">'+result['msg']+'</div">'); 
                    location.reload();
                }     
                else{
                    $('.errMsg').html('<div class="successmsg">'+result['msg']+'</div">');            
                    setTimeout(function () {
                    location.reload();
                    },1000);         
                } 
			}
		});
		e.preventDefault();
	});

    $(document).on('click', '.deleteproduct, .deleteAddress, .deleteSample', function(){
        var clickedBtn = $(this);
        clickedBtn.addClass('clicked');
        var pid = $(this).attr('data-id'); 
        var pge = $(this).attr('data-page');
        $.ajax({
            url: SITE_LOC_PATH+'/request/',
            type: 'POST',
            data:{'ajx':1, 'pid':pid, 'page':pge},
            success: function(response){
               clickedBtn.removeClass('clicked');
                $('#sadrzaj').html(response);
                 setTimeout(function () {
                    location.reload();
                },1000);   
            }
        });
    });
    
     $(document).on('click', '.viewProduct', function(){
        var clickedBtn = $(this);
        clickedBtn.addClass('clicked');
        var pid = $(this).attr('data-id'); 
        var pge = $(this).attr('data-page');
        



        $.ajax({
            url: SITE_LOC_PATH+'/request/',
            type: 'POST',
            data:{'ajx':1, 'pid':pid, 'page':pge},
            success: function(response){
               clickedBtn.removeClass('clicked');
                $('#myModal').modal('show'); 
                $('.modal-body').html(response); 
            }
        });
    });

    $(document).on('click', '.deletereq,.deletesamplereq', function(){
        var clickedBtn = $(this);
        clickedBtn.addClass('clicked');
        var pid = $(this).attr('data-id'); 
        var page = $(this).attr('data-page'); 
        $.ajax({
            url: SITE_LOC_PATH+'/request/',
            type: 'POST',
            data:{'ajx':1, 'pid':pid, 'page':page},
            success: function(response){
                clickedBtn.removeClass('clicked');
                $('#sadrzaj').html('<div class="successmsg">Requirement deleted successfully.</div><div class="clearfix"></div>');
                setTimeout(function () {
                    location.reload();
                },600);   
            }
        });
    });
    
    $(document).on('click','.addnew',function(e){
        e.preventDefault();
        var samplId = $('.sample').val();
        if(samplId=='')
            alert('Please select sample');
        else{
            samplId = $('.selectSmp').val();
            var clickedBtn = $(this);
            clickedBtn.addClass('clicked');
            var cid = $(this).attr('data-cid');
            $.ajax({
                url: SITE_LOC_PATH+'/request/addnew/',
                type: 'POST',
                data:{'cid':cid,'samplId':samplId},
                success: function(response){
                    clickedBtn.removeClass('clicked');
                        var html = '';
                       if(response){

                            var obj      = jQuery.parseJSON(response);
                            
                            if(obj.length==1)
                                $('.newSmp').hide();
                           else
                                $('.newSmp').show();

                            html = '<div class="col-sm-6 form-group"><label style="line-height: 34px;">Sample </label> <select name="sample[]" class="sample" style="width: 80%; height: 34px;" required><option value="">--Select--</option>';
                            $.each(obj, function(key, value) {
                                html += '<option value="'+value.sampleId+'">'+value.productName+'</option>';
                            });

                            html += '</select></div>';
                            html += '<div class="col-sm-6 form-group"><label style="line-height: 34px;">Qty</label><span class="qty_block"><span class="minus_value">minus</span><input class="qty_input form-control" id="smQt" name="qty[]" value="1" type="text" readonly=""><span class="add_value">add</span></span></div>';
                        }

                    $('#newSmpl').append(html);
                }
            });
        }
        
    });
    
    
    $(document).on('change','.sample',function(){
        var track  = $('.selectSmp').val();
        var sample = $(this).val(); 
        
        var sCArr = track+","+sample;   
        $('.selectSmp').val(sCArr);
        /*$.ajax({
            url: SITE_LOC_PATH+'/request/sample-qty/',
            type: 'POST',
            data:{'sample':sample},
            success: function(response){
                                   
                $('.qty_input').val(response);
            }
        });*/
        
    });
    
    /*--------------------Booking Date----------------------------*/
    
    $(document).on('click', '#addmore_btn', function(){
        var html = '<div class="seldt"><label>Select Date</label><br><input name="startDate[]" type="text" style="width:120px;" class="form-control multidate" value="" placeholder="dd-mm-yyyy"/></div>';

        html += $('.schedule').html();

        $('#add_date').append('<div class="schextra"><span class="schcls glyphicon glyphicon-remove"></span>'+html+'</div>');
    });

    $(document).on('click', ".schcls", function(){
        $(this).parent('.schextra').remove(); 
    });

    $(document).on('focus', "input.multidate", function(){
        $('input.multidate').datepicker({
            minDate:0,
            dateFormat: 'dd-mm-yy'
        });
    });
    
    $(document).on('focus',".timepicker", function(){
        $('.timepicker').timepicker({
            minTime: '6:00 AM',
            maxTime: '11:00 PM'
       });
    });
    
    ///////////////select state////////////////////////////////
    $(document).on('click',".bookLc", function(){    
        var clickedBtn = $(this);
        clickedBtn.addClass('clicked');
        var id_office=$("#office_name").val();

        if(id_office==null)
        {
            alert("Select office");
            return false;		
        }
        var dataString1 = $('#addbkfrm').serialize();

        $.ajax({
            type: "POST",
            url: MODULE_PATH + "/dashboard/action.php",
            data: dataString1,
            success: function(msg){	
            clickedBtn.removeClass('clicked');
                if(msg == 1){
                    $("#succ").html('<div class="alert alert-success" role="alert">Booking done. Please wait...</div>');
                    setTimeout(function(){$("#succ").html(" ");location.reload(); },3000);
                }
                else{
                    var result = jQuery.parseJSON(msg);
                    var errMsg = '';
                    $.each(result, function(key, value) {
                        errMsg += value+'<br>';
                    });
                    $("#succ").html('<div class="alert alert-warning" role="alert">Error! '+errMsg+'</div>');
                }
            }
        });
    });
    
    $(document).on('click',".cnfbk", function(e){
        e.preventDefault();
        var clicked = $(this);
        clicked.addClass('clicked');

        var id_booking = clicked.attr('data-id');
        $('.editpanel').remove();
        if(id_booking){
            clicked.addClass('clicked');	
            $.ajax({
                type: "POST",
                url: MODULE_PATH + "/dashboard/action.php",
                data: {'SourceForm':'userconfirmbook','ajax':1,'id_booking':id_booking},
                cache:false,
                success: function(msg){
                    clicked.removeClass('clicked');
                    var result = jQuery.parseJSON(msg);
                    if(result.error){
                        alert(result.error);
                    }
                    else{

                        var html = '<tr class="editpanel"><td colspan="9">';
                            html += '      <form id="cnfbkfrm" method="post"><span class="glyphicon glyphicon-remove edtbkfrm_rm"></span><div class="edthd">'+result.office+' - '+result.startDate+' @ '+result.startTime+'</div><div id="updatesucc"></div>';
                            

                                     html += '<div class="schedule cnf">Once you confirm, you won\'t be able to edit this schedule anymore.<br>Are you sure to confirm this booking schedule?';

                                     html += '</div>';
                                             html += '<div class="btnw">';
                                             html += '<button type="submit" class="btn btn-success btn-lg bkbtn">Confirm Booking</button>';
                                             html += '<input type="hidden" name="SourceForm" value="setconfirmbook">';
                                             html += '<input type="hidden" name="ajax" value="1">';
                                             html += '<input type="hidden" name="id_booking" value="'+id_booking+'">';
                                     html += '</div>';
                                 html += '</form>';
                             html += '</td></tr>';

                        clicked.parents('tr').after(html);
                    }
                }
            });
        }
    });
    
    $(document).on('submit',"#cnfbkfrm", function(e){
        e.preventDefault();
        var formData = new FormData(this);
        
        $.ajax({
            url: MODULE_PATH + "/dashboard/action.php",
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			success: function(msg){	
                var result = jQuery.parseJSON(msg);
                if(result.error){
                    $("#updatesucc").html('<div class="alert alert-warning" role="alert">Error! '+result.error+'</div>');
                }
                else{
                    $("#updatesucc").html('<div class="alert alert-success" role="alert">Done. Please wait...</div>');
                    setTimeout(function(){$("#updatesucc").html(" ");location.reload(); },3000);
                }
            }
		});
		e.preventDefault();
    });
    
    $(document).on('submit',"#edtbkfrm", function(e){
        e.preventDefault();
        var formData = new FormData(this);
        
        $.ajax({
            url: MODULE_PATH + "/dashboard/action.php",
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			success: function(msg){	
                var result = jQuery.parseJSON(msg);
                if(result.error){
                    $("#updatesucc").html('<div class="alert alert-warning" role="alert">Error! '+result.error+'</div>');
                }
                else{
                    $("#updatesucc").html('<div class="alert alert-success" role="alert">Done. Please wait...</div>');
                    setTimeout(function(){$("#updatesucc").html(" ");location.reload(); },3000);
                }
            }
		});
		e.preventDefault();
    });    
    
    $(document).on('click',".edtbk", function(e){ 
        e.preventDefault();
        var clicked = $(this);

        var id_booking = clicked.attr('data-id');
        $('.editpanel').remove();
        if(id_booking)
        {
            clicked.addClass('clicked');
            $.ajax({
                type: "POST",
                url: MODULE_PATH + "/dashboard/action.php",
                data: {'SourceForm':'editbook','ajax':1,'id_booking':id_booking},
                cache:false,
                success: function(msg){
                    clicked.removeClass('clicked');
                    var result = jQuery.parseJSON(msg);
                    if(result.error){
                        alert(result.error);
                    }
                    else{

                        var html = '<tr class="editpanel"><td colspan="9">';
                            html += '      <form id="edtbkfrm" method="post"><span class="glyphicon glyphicon-remove edtbkfrm_rm"></span><div class="edthd">'+result.office+'</div><div id="updatesucc"></div>';
                            html += '      <div class="seldt">'
                                                 html += '<label>Select Date</label><br>'
                                                 html += '<input name="startDate" style="width:120px;" type="text" class="form-control multidate" value="'+result.startDate+'" placeholder="Select Date">'
                                             html += '</div>'

                                             html += '<div class="schedule">'
                                                 html += '<table class="schtbl">'
                                                     html += '<tbody><tr>'
                                                         html += '<td class="start_date">'
                                                             html += '<label>Start Time </label><br>'   
                                                             html += '<input name="startTime" style="width:120px;" type="text" class="form-control timepicker" value="'+result.startTime+'" placeholder="Select Time">'
                                                         html += '</td>'

                                                         html += '<td class="end_date">'
                                                             html += '<div class="end_sep">'
                                                                 html += '<label>Duration (Hour)</label>'
                                                                 html += '<br> '
                                                                 html += '<select name="hour" class="form-control"><option value="">--select--</option>';
                                                                 for(var i=1; i<=result.ofcUse; i++){
                                                                     if(i == result.hour)
                                                                         html += '<option value="'+i+'" selected>'+i+'</option>';
                                                                     else
                                                                        html += '<option value="'+i+'">'+i+'</option>';
                                                                 }
                                                                 html += '</select>';
                                                             html += '</div>'
                                                         html += '</td>'
                                                     html += '</tr>'
                                                 html += '</tbody></table>'
                                             html += '</div>';
                                                     html += '<div class="btnw">';
                                                     html += '<button type="submit" class="btn btn-primary btn-lg bkbtn">Update Booking</button>';
                                                     html += '<input type="hidden" name="SourceForm" value="updatebook">';
                                                     html += '<input type="hidden" name="ajax" value="1">';
                                                     html += '<input type="hidden" name="id_booking" value="'+id_booking+'">';
                                             html += '</div>';
                                         html += '</form>';
                                     html += '</td></tr>';

                        clicked.parents('tr').after(html);
                    }
                }
            });
        }
    });
    
    $(document).on('click',".h-table .edtbkfrm_rm", function(e){
        e.preventDefault();
        $(this).parents('.editpanel').remove();
    });
        
    /*-----------------------Register------------------------------*/
    $(document).on('click',".create", function(e){
        e.preventDefault();
        $("html, body").animate({ scrollTop: 0 }, 400);
        
        $(".loader").show();
        
        if($("#name").val()==''){$(".name").addClass("has-error");$(".loader").hide();return false;}
        if($("#surname").val()==''){$(".surname").addClass("has-error");$(".loader").hide();return false;}
        if($("#username").val()==''){$(".username").addClass("has-error");$(".loader").hide();return false;}
        if($("#phone").val()==''){$(".phone").addClass("has-error");$(".loader").hide();return false;}
        if($("#email").val()==''){$(".email").addClass("has-error");$(".loader").hide();return false;}
        if($("#password").val()==''){$(".password").addClass("has-error");$(".loader").hide();return false;}
        if($("#address").val()==''){$(".address").addClass("has-error");$(".loader").hide();return false;}
        if($("#country").val()==''){$(".country").addClass("has-error");$(".loader").hide();return false;}
        if($("#state").val()==''){$(".state").addClass("has-error");$(".loader").hide();return false;}
        if($("#city").val()==''){$(".city").addClass("has-error");$(".loader").hide();return false;}
        if($("#zip").val()==''){$(".zip").addClass("has-error");$(".loader").hide();return false;}
	  
        var email=$("#email").val();
        
        if(IsEmail(email)==false){
            $(".email").addClass("has-error");
            $(".loader").hide();
            return false;
        }

        pl    = $('input[name=blankRadio]:checked', 'form').val();
        
        if(pl == 'standard')
        {
            valm1=$('#blankRadio1A:checked').val();
            valm2=$('#blankRadio2A:checked').val();
            if(valm1==undefined && valm2==undefined)
            {
                alert("Please select your plan");
                return false;
            }
        }
        else
        {
            valm3=$('#blankRadio3A:checked').val();
            valm4=$('#blankRadio4A:checked').val();
            valm5=$('#blankRadio5A:checked').val();
            if(valm3==undefined && valm4==undefined && valm5==undefined)
            {
                alert("Please select your plan");
                return false;
                //setTimeout(function(){$(".second_screen").html(msg);$(".second_screen").toggle('slow')},500);
                $(".loader").hide();
            }		  
        }
        ///check username and email//
        var username=$("#username").val();
        var company=$("#company").val();
        var phone=$("#phone").val();
        var password=$("#password").val();
        //var email=$("#email").val();                
		dataString = 'username='+username+'&email='+email+'&company='+company+'&phone='+phone+'&password='+password+'&SourceForm=checkusr&ajax=1';		
		//alert(dataString);
		$.ajax({
            type: "POST",
            url: MODULE_PATH + "/dashboard/action.php",
            data: dataString,
            cache:false,
            success: function(msg1){
            msg=parseInt(msg1);
                if(msg==2)
                {
                    $(".username_check").html("* Username is taken!!!");
                    $(".username").addClass("has-error");
                    setTimeout(function(){$(".username_check").html(' ');},2500);	
                    $(".loader").hide();		   
                    return false;	 
                }

                if(msg==3)
                {
                    $(".email_check").html("* Email is in our system!!!");
                    $(".email").addClass("has-error");
                    setTimeout(function(){$(".email_check").html(' ');},2500);
                    $(".loader").hide();
                    return false;
                }

                if(msg==4)
                {
                    $(".phone_check").html("* Phone is in our system!!!");
                    $(".phone_ch").addClass("has-error");
                    setTimeout(function(){$(".phone_check").html(' ');},2500);
                    $(".loader").hide();
                    return false;
                }	
                if(msg==5)
                {
                    $(".company_check").html("* Company name is in our system!!!");
                    $(".company").addClass("has-error");
                    setTimeout(function(){$(".company_check").html(' ');},2500);
                    $(".loader").hide();
                    return false;
                }	
                if(msg==6)
                {
                    $(".padssword_check").html("* Password needs 1 capital, 1 non-capital, 1 digit!!!");
                    $(".password").addClass("has-error");
                    setTimeout(function(){$(".padssword_check").html(' ');},12500);
                    $(".loader").hide();
                    return false;
                }			 		 
                if(msg==1)
                {
                    var dataString1 = $("form").serialize();
                    $(".first_screen").toggle('slow');
                    $.ajax({
                        type: "POST",
                        url: MODULE_PATH + "/dashboard/action.php",
                        data: dataString1,
                        cache:false,
                        success: function(msg){
                            setTimeout(function(){$(".second_screen").html(msg);$(".second_screen").toggle('slow')},500);
                            $(".loader").hide();
                        }
                    });
                }
            },
            error:function(err){
                console.log(err);
                return false;
            }
        });
    });
    
    $(document).on('change','#state_office', function(){
        
        var state   =$(this).val();        
        var selOfc  =$(this).attr('data-selofc');
        var dataOfc =$(this).attr('data-office');
        $.ajax({
        type: "POST",
        url: MODULE_PATH + "/dashboard/action.php",
        data: {'SourceForm':'Readoffice','ajax':'1','state_code':state,'cityOffice':selOfc},
        success: function(msg){
            $("#city_office").html(msg); 
            
            var on=$("#city_office").val();
            var dataStringC = 'SourceForm=Readofficename&ajax=1&office_name='+on+'&office='+dataOfc;   
            $.ajax({
                type: "POST",
                url: MODULE_PATH + "/dashboard/action.php",
                data: dataStringC,
                success: function(msg){
                    $("#office_name").html(msg);
                    //alert(onF);
                        var onF=$("#office_name").val();
                        var dataStringN = 'SourceForm=Readofficeimg&ajax=1&id_office='+onF;
                        $.ajax({
                        type: "POST",
                        url: MODULE_PATH + "/dashboard/action.php",
                        data: dataStringN,
                        success: function(msg){
                          $("#office_thumb").html(msg);
                                var dataStringI = 'SourceForm=getcoordinate&ajax=1&address='+on;			
                                $.ajax({
                                type: "POST",
                                url: MODULE_PATH + "/dashboard/action.php",
                                data: dataStringI,
                                success: function(msg){   
                                        
                                       var mapLc ='<iframe  scrolling="no"  src="https://maps.google.it/maps?q='+msg+'&output=embed"  width="100%" height="450" frameborder="0" style="border:0"></iframe>';
                                    
                                       $("#loctn").html(mapLc);
                                    }
                                });
                          }
                        });

                    }
            });		  
          }
        });
    });
    
    $(document).on('change','#city_office', function(){ 
	    var on=$(this).val();		
		$.ajax({
		type: "POST",
        url: MODULE_PATH + "/dashboard/action.php",
		data: {'SourceForm':'Readofficename','ajax':'1','office_name':on},
		success: function(msg){	
		  $("#office_name").html(msg);
                var on=$("#office_name").val();		
                $.ajax({
                type: "POST",
                url: MODULE_PATH + "/dashboard/action.php",
                data: {'SourceForm':'Readofficeimg','ajax':'1','id_office':on},
                success: function(msg){	
                  $("#office_thumb").html(msg);
                  var state=$("#state_office").val();		
                        $.ajax({
                        type: "POST",
                        url: MODULE_PATH + "/dashboard/action.php",
                        data: {'SourceForm':'getcoordinate','ajax':'1','address':on},
                        success: function(msg){	
                           var mapLc ='<iframe  scrolling="no"  src="https://maps.google.it/maps?q='+msg+'&output=embed"  width="100%" height="450" frameborder="0" style="border:0"></iframe>';

                           $("#loctn").html(mapLc);
                                
                          }
                        });
                  }
                });		  
          }
		});
   });
    $("#state_office" ).trigger('change');
    
    $(document).on('change','#office_name', function(){
	    var on=$(this).val();		
		$.ajax({
		type: "POST",
        url: MODULE_PATH + "/dashboard/action.php",
		 data: {'SourceForm':'Readofficeimg','ajax':'1','id_office':on},
		success: function(msg){	
		  $("#office_thumb").html(msg);
		   var state=$("#state_office").val();			
                $.ajax({
                type: "POST",
                url: MODULE_PATH + "/dashboard/action.php",                
                data: {'SourceForm':'getcoordinate','ajax':'1','address':on},
                success: function(msg){	
                    
                        var mapLc ='<iframe  scrolling="no"  src="https://maps.google.it/maps?q='+msg+'&output=embed"  width="100%" height="450" frameborder="0" style="border:0"></iframe>';

                       $("#loctn").html(mapLc);
                  }
                });
		  }
		});
   });
    
    $( "input" ).focus(function() {
        clas=$( this ).attr('id');
        $("."+clas).removeClass("has-error");
        //d=$( this ).val();
        //alert(d);
    });

    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test(email)) {
            return false;
        }else{
            return true;
        }
    }
    
    
    $(document).on('change','.mbrshp', function(e){
        var mbrshp = $(this).attr('data-membership');
        $('.loader').fadeIn(400);
        $('.first_screen, .second_screen').fadeOut(400);
        $("html, body").animate({ scrollTop: 0 }, 600);
        var pgUrl   = document.URL;
        var spltUrl = pgUrl.split('?src=');    
        
        if(spltUrl[1])
            window.location.href = SITE_LOC_PATH+'/'+PAGETYPE+'/'+mbrshp+'?src='+spltUrl[1];
        else
            window.location.href = SITE_LOC_PATH+'/'+PAGETYPE+'/'+mbrshp;
    });
      
    $('#contactBtn').submit(function(e){ 
		e.preventDefault();        
        var frm = $(this);
        var btn = frm.children('button');
        btn.addClass('clicked');
        var formData    = $(this).serialize();
		$.ajax({
            url: MODULE_PATH +"/communication/action.php",
			type: 'POST',
			data: formData,
			success: function(result){
                btn.removeClass('clicked'); 
                var result = result.split('>');
                if(result[0]=='error')
				    $('.errMsg').html('<div class="errormsg" style="width:84%">'+result[1]+'</div">');
                else{
                    $('.errMsg').html('<div class="successmsg" style="width:84%">'+result[1]+'</div">');            
                        setTimeout(function () {
                        location.reload();
                        },1000);    
                    }
			}
		});
	});
    $('#quoteBtn').submit(function(e){
		e.preventDefault();        
        var frm = $(this);
        var btn = frm.children('button');
        btn.addClass('clicked');
        var formData    = $(this).serialize();
		$.ajax({
            url: MODULE_PATH +"/communication/action.php",
			type: 'POST',
			data: formData,
			success: function(result){ 
                btn.removeClass('clicked'); 
                var result = result.split('>');
                if(result[0]=='error')
				    $('.errMsg').html('<div class="errormsg" style="width:84%">'+result[1]+'</div">');
                else{
                    $('.errMsg').html('<div class="successmsg" style="width:84%">'+result[1]+'</div">');            
                        setTimeout(function () {
                        location.reload();
                        },1000);    
                    }
			}
		});
	});
    
    $('#blogcomment').submit(function(e){ 
		e.preventDefault();        
        var frm = $(this);
        var btn = frm.children('button');
        btn.addClass('clicked');
        var formData    = $(this).serialize();
		$.ajax({
            url: MODULE_PATH +"/blog/action.php",
			type: 'POST',
			data: formData,
			success: function(result){
                btn.removeClass('clicked');
                var result = result.split('>');
                if(result[0]=='error')
				    $('.errMsg').html('<div class="errormsg">'+result[1]+'</div">');
                else{
                    $('.errMsg').html('<div class="successmsg">'+result[1]+'</div">');            
                        setTimeout(function () {
                        location.reload();
                        },1000);    
                    }
			}
		});
	});
      
    $(document).on('click','.vidPlay', function(e){
        e.preventDefault();
        $(this).parent().addClass('videoPlay');
        $(this).next().trigger('play');
    });
    
    $(document).on('click','.selLocation',function(e){
       e.preventDefault();
        var perm = $(this).attr('data-parmalink');
        
        window.location.href = SITE_LOC_PATH+'/register/?src='+perm;
    });
      
    
});



function misteryMessage(message, type) {
    $('.overlay_msg').fadeIn();
    $('.message-' + type).find('.title').text(type);
    if (message != 'wlc') $('.message-' + type).find('.msg').text(message);
    $('.message-' + type).css('margin-top', $(window).scrollTop()).addClass('active');
}

function misteryMessageConfirm(message, type, dataid) {
    $('.overlay_msg').fadeIn();
    $('.message-' + type).find('.title').text(type);
    if (message != 'wlc') $('.message-' + type).find('.msg').text(message);
    $('.message-' + type).css('margin-top', $(window).scrollTop()).addClass('active');
    $('.btn_conf').attr('data-id', dataid);
}

function misteryMessageAjax(message, type) {
    $('body').addClass('fixedbody');
    $('.overlay_msg').addClass('blakish');
    $('.overlay_msg').fadeIn();

    $('.message-ajax').find('.msg').html(message);
    $('.message-ajax').css('margin-top', $(window).scrollTop()).addClass('active');
}

function processFileUpload(droppedFiles) {
    var frm = $("#dpfrm")[0];
    var formData = new FormData(frm);

	$('.d_cell').addClass('clicked');
    
    $.ajax({
        url: MODULE_PATH + "/dashboard/action.php",
        type: 'POST',
        data: formData,
        mimeType: "multipart/form-data",
        processData: false,  // tell jQuery not to process the data
        contentType: false,  // tell jQuery not to set contentType
        cache: false,
        success: function(data){
            $('.d_cell').removeClass('clicked');
            var result = data.split('>');

            if(result[0]=='success'){
                location.reload();
            }
            else{
                $('.message-ajax').removeClass('active');
                misteryMessage(result[1], result[0]);
            }
        }
    });
}

function init_map() {
    var coor=$("#coord").val();
    if(coor){
        var arr=[];
        var arr=coor.split(",");
        var latA=arr[0];
        var longA=arr[1];
        var myOptions = {
            zoom: 13,
            center: new google.maps.LatLng(latA,longA),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map"), myOptions);
        marker = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng(latA,longA)
        });
    }
}


