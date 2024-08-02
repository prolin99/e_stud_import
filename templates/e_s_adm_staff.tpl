
<div class="container-fluid">

      <h3>職稱設定(配對，先選人再選職稱)</h3>
      <div class="row" >
      <div class="col-8" id="tea_div">
          <div class="row">
              <div class="col-3"><h4>教師列表</h4></div>
              <div class="col-3"><button  id='show_register' class="btn btn-primary" smode="0" >校內人員(切換)</button></div>
          </div>
      	<{foreach  key=c_key item=teacher    from= $data.teacher_list }>
       	       <{if ($data.user_staff_id[$c_key])}>
      	       		<!-- 已設職稱  -->
      	           <span class="col-3"><label  id="tea_<{$c_key}>" title='<{$teacher.name}>(<{$teacher.uname}>)' name_title='<{$teacher.name}>' class="badge badge-default bg-secondary">
      	           <{$teacher.name}>_<{$data.user_staff_job[$c_key]}></label>
      	           <span id="i_<{$c_key}>" class="fa fa-trash  del" data_ref="sta_<{$data.user_staff_id[$c_key]}>:tea_<{$c_key}>"></span>
      	           </span>
      	       <{else}>
      		   <span class="col-3"><label  id="tea_<{$c_key}>" title='<{$teacher.name}>(<{$teacher.uname}>)' name_title='<{$teacher.name}>' class="badge badge-success bg-success"><{$teacher.name}></label>
                    <span id="i_<{$c_key}>" ></span></span>
      		<{/if}>
      	<{/foreach }>


      </div>


      <div class="col-3" id="staff_div">
      <h4>職稱</h4>
	<{foreach  key=t_key item=staff_list    from= $data.staff }>
	<{if ($data.staff_user_id[$t_key])}>
	<label id="sta_<{$t_key}>" title='<{$t_key}>_<{$staff_list}>' name_title='<{$staff_list}>' class="badge badge-success bg-success" style="display: none;"><{$staff_list}></label>
	<{else}>
	<label id="sta_<{$t_key}>" title='<{$t_key}>_<{$staff_list}>' name_title='<{$staff_list}>' class="badge badge-success bg-success"><{$staff_list}></label>
	<{/if}>
	<{/foreach }>

      </div>

      </div>
      <div class="row">
      	<p>
            <span class="badge badge-info bg-info">說明</span><br/>
            點選雙邊進行設定，選擇時呈黃色，設定完成為黑色，唯一位的職稱會隱藏。<br/>垃圾桶圖示會還原重新設定。
            <br/>職稱會配合群組的指定，請看偏好中--職稱設定說明。
            <br/>找不到教師名稱，可切換校內群組鍵，查看非在校人員，再設職稱。
            <br/>離職人員，會移除校內教師的群組權限，及之後的群組權限 。但是否還有其他權限，請查看群組設定。
        </p>
      </div>
</div>

    <script>
    var label_right='' ;
    var label_left='' ;
    var o_label_right='' ;
    var o_label_left='' ;
    var name='';
    var class_id='';

    //右方部份的點選(綠-未選，黃-正在選，黑-已設定不能選)
    $(document).on("click", "#staff_div  label" ,  function(){

    	if ($(this).attr("class") == "badge badge-success bg-success" ){
    	   //可選
    	  	$(this).removeClass() ;
        	$(this).addClass('badge badge-warning bg-warning') ;
			label_right= $(this).attr("id")  ;
        	name =  $(this).attr("name_title")  ;
        	if (o_label_right!=''){
        	   	//換選，先前的還原
        		$('#'+o_label_right).removeClass() ;
        		$('#'+o_label_right).addClass('badge badge-success bg-success') ;
        	}
        	o_label_right = $(this).attr("id")  ;
		    link() ;
	    }else {
    		if ($(this).attr("class") == "badge badge-warning bg-warning" ){
    			//不再選
    			$(this).removeClass() ;
    			$(this).addClass('badge badge-success bg-success') ;
    			label_right= '' ;
    			o_label_right ='' ;
            	name = '' ;
    		}
	    }

    });

    //左方部份的點選
    $(document).on("click", "#tea_div label" ,  function(){

    	if ($(this).attr("class") == "badge badge-success bg-success" |  $(this).attr("class") == "label label-success"  ){
    	   //可選
    	  	$(this).removeClass() ;
        	$(this).addClass('badge badge-warning bg-warning') ;
		    label_left= $(this).attr("id")  ;
        	class_id =  $(this).attr("name_title")  ;
        	if (o_label_left!=''){
        		//換選，先前的還原
        		$('#'+o_label_left).removeClass() ;
        		$('#'+o_label_left).addClass('badge badge-success bg-success') ;
        	}
        	o_label_left = $(this).attr("id")  ;
		    link() ;
	    }else {
    		if ($(this).attr("class") == "badge badge-warning bg-warning"  |  $(this).attr("class") == "label label-warning" ){
    			//不再選
    			$(this).removeClass() ;
    			$(this).addClass('badge badge-success bg-success') ;
    			label_left= '' ;
    			o_label_left ='' ;
            	class_id = '' ;
    		}
	    }


    });

    //作配對，改成黑色，寫入
    function link() {
    	var mark_id ,job ;
          if ((label_right != '') & (label_left!=''))  {

           	if (	label_right=='sta_990000')  {
           		//alert(label_right) ;
           		alert('離職人員，會移除校內教師的群組的權限！') ;
           	}

             mark_id = label_right +':' + label_left ;
             //取得職稱
             job = $('#'+label_right).attr("name_title")  ;
             $('#'+label_left).removeClass() ;
             $('#'+label_left).html(class_id +'_'+ name) ;	//姓名+ 職稱
             $('#'+label_left).addClass('badge badge-default bg-secondary') ;
             //$('#'+label_right).addClass('badge badge-default bg-secondary') ;

             //圖示的內容放置
             var splits = label_left.split('_') ;
             var icon = 'i_'+ splits[1] ;
             $('#' +icon).removeClass() ;
             $('#' +icon).attr('data_ref', mark_id) ;
 	     $('#' +icon).addClass("fa fa-trash  del") ;

             //如果第四碼為 1 代表唯一(sta_000101)，要 hide
             var sta_id = label_right.split('_') ;
 			 if (sta_id[1].charAt(3)== '1') {
             	$('#'+label_right).hide() ;
             }else{
                 ///還原顏色
                 $('#'+o_label_right).removeClass() ;
                 $('#'+o_label_right).addClass('badge badge-success bg-success') ;
             }

             label_right ='' ;
             o_label_right ='' ;
             label_left='' ;
             o_label_left ='' ;

             //設定教師
             //alert(mark_id +job) ;
             ajax_set_teacher(mark_id ,job) ;
          }
    }

    //把目前有選定的部份先清空
    function clear_now() {
             if (o_label_right!=''){
        		$('#'+o_label_right).removeClass() ;
        		$('#'+o_label_right).addClass('badge badge-success bg-success') ;
             }
             if (o_label_left!=''){
        		$('#'+o_label_left).removeClass() ;
        		$('#'+o_label_left).addClass('badge badge-success bg-success') ;
             }
             label_right ='' ;
             o_label_right ='' ;
             label_left='' ;
             o_label_left ='' ;
    }



    //消除配對，還原----------------------------------------------------------------------------------
  $(document).on("click", ".del", function(){

    var mark_id = $(this).attr("data_ref")  ;
    var splits = mark_id.split(':') ;
    clear_now() ;

    $('#'+splits[0]).removeClass() ;
    $('#'+splits[0]).addClass('badge badge-success bg-success') ;
    $('#'+splits[0]).show() ;
    $('#'+splits[1]).removeClass() ;
    $('#'+splits[1]).addClass('badge badge-success bg-success') ;

    $('#'+splits[1]).text($('#'+splits[1]).attr("name_title") ) ;
    //清除教師
    //alert (mark_id) ;
    ajax_del_teacher(mark_id) ;
    //icon 清空
    $(this).removeClass() ;
    $('#' +icon).attr('data_ref', "") ;

  });

      var ajax_set_teacher=function( tid ,tjob ){
      	  //指定教師，寫入
      	  //取得
            var URLs="ajax_set_staff.php" ;

            $.ajax({
                url: URLs,
                type:"GET",
                dataType:'text',
				data:{id:tid,job:tjob},
                success: function(msg){
                    //alert(msg);
                },

                 error:function(xhr, ajaxOptions, thrownError){
                    alert('error:' + xhr.status);
                    alert(thrownError);
                 }
           })
        }

      var ajax_del_teacher=function( tid ){
    	  //刪除記錄
            var URLs="ajax_set_staff.php" ;

            $.ajax({
                url: URLs,
                type:"GET",
                dataType:'text',
				data:{id:tid,do:"del" },
                success: function(msg){
                   // alert(msg);
                },

                 error:function(xhr, ajaxOptions, thrownError){
                    alert('error:' + xhr.status);
                    alert(thrownError);
                 }
            })
        }

    //顯示全部的註冊人員、校內人員(切換)----------------------------------------------------------------------------------
    $(document).on("click", "#show_register", function(){
        var smode =  $(this).attr("smode")  ;

        clear_now() ;
        ajax_show_teacher(smode) ;

    });

    var ajax_show_teacher=function( smode ){
        //刪除記錄
        var URLs="ajax_redisp_staff.php" ;
        //alert(smode) ;
        $.ajax({
            url: URLs,
            type:"GET",
            dataType:'text',
            data:{mode:smode } ,
            success: function(msg){
                //重顯示教師群
                $("#tea_div").html(msg) ;
            },

            error:function(xhr, ajaxOptions, thrownError){
                alert('error:' + xhr.status);
                alert(thrownError);
            }
        })
    }
    </script>
