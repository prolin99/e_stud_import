
<script src="<{$xoops_url}>/modules/tadtools/jquery/ui/jquery-ui.js"></script>
<style>
.groupbox {
    border: 1px dotted gray;
    background-color: #EEE;
}
.tea {
    background-color: #BCF5A9;
}
</style>

<div class="container-fluid">

      <h3>級任設定(配對)</h3>
      <div class="row">
        <form  action="teacher_set.php" method="post" >
        <span class="label">班名:</span>
        <input type="text" name="class_name_set"   placeholder="以逗號做分隔，數量可超過現有班數。" title="以逗號做分隔，數量可超過現有班數。" alt="以逗號做分隔，數量可超過現有班數。"   value="<{$ES_classname_set}>">
        <button type="submit" name='act_class_set'  value='班名'  class="btn btn-primary" >班名設定</button>

        <button type="submit" name='act_clear'  value='刪除'  class="btn btn-danger"  title="全部清除已設定的級任資料"  onclick='return confirm("真的要清空設定?")' >級任清空</button>
        <button type="submit" name='act_up'  value='135升級'  class="btn btn-warning" title="135年級級任往上帶班" onclick='return confirm("確定要升級?")' >135升級</button>
        <a class="btn btn-success" href="export_class.php" title="匯出EXCEL">班級總表</a>
        </form>

      <div class="col-9" id="class_div">


      	<h4>班級列表</h4>


 		<!--  年級分開  -->
      	<{foreach  key=g_key item=g_class_id    from= $data.g_class_list }>
      		<div class="row" >
      		<p> </p>
      		<{foreach  key=c_key item=class_id    from= $g_class_id }>
      		<{if ($data.class_set[$c_key])}>
      			<div class="groupbox col-2" id="class_<{$c_key}>" has_teacher="<{$data.class_set[$c_key]}>" id="class_<{$c_key}>" style="background:#EEE;">
      			<!-- teacher_代號_教師名:class_班級代號  -->
      			 <span class="tea" id="box_<{$data.class_set[$c_key]}>"  has_class="class_<{$class_id}>" data_ref="teacher_<{$data.class_set[$c_key]}>_<{ $data.class_teach[$c_key]}>:class_<{$class_id}>" >
      			 <{$data.class_list_c[$c_key]}>_<{ $data.class_teach[$c_key]}><span class="fa fa-trash    del" id="i_<{$class_id}>" data_ref="teacher_<{$data.class_set[$c_key]}>:class_<{$class_id}>" ></span>
           </span>
      			</div>
      		<{else}>
      			<div class="groupbox col-2" id="class_<{$c_key}>" has_teacher="0" id="class_<{$c_key}>" style="background:#EEE;"> <span><{$data.class_list_c[$c_key]}></span> </div>
			<{/if}>
			<{/foreach }>
			</div>
      	<{/foreach }>


      </div>

      <div class="col-2" id="teacher_div">
      <h4>教師列表</h4>

	<{foreach  key=t_key item=teacher_list    from= $data.teacher }>
	<{if ($data.teacher_class[$t_key])}>
 	<span  class="tea" id="tea_<{$t_key}>" data_ref="teacher_<{$t_key}>_<{$teacher_list.name}>" style='display: none;'>
	<label id="teacher_<{$t_key}>" title='<{$teacher_list.name}>(<{$teacher_list.uname}>)' name_title='<{$teacher_list.name}>' class="badge badge-success " ><{$teacher_list.name}></label>
</span>
	<{else}>
 	<span  class="tea" id="tea_<{$t_key}>" data_ref="teacher_<{$t_key}>_<{$teacher_list.name}>" >
	<label id="teacher_<{$t_key}>" title='<{$teacher_list.name}>(<{$teacher_list.uname}>)' name_title='<{$teacher_list.name}>' class="badge badge-success "><{$teacher_list.name}></label>
</span>
	<{/if}>
	<{/foreach }>
          <p> <button  id='show_register' class="btn btn-primary" smode="0" >校內人員(切換)</button></p>
      </div>

      </div>
      <div class="row">
      	<p>
            <span class="badge badge-info">說明</span>
            拖拉到任教班級，點垃圾桶圖示表示清除。
        </p>
      </div>
</div>

   <SCRIPT type="text/javascript">
    var label_tea='' ;
    var label_class='' ;
    var o_label_tea='' ;
    var o_label_class='' ;
    var name='';
    var class_id='';

//可拖拉
$(function () {
        var zindex = 1000;
        $(".tea").draggable({
                revert: "valid",
                start: function(event, ui) { $(this).css("z-index", zindex++ ); }
        });

        //放入
        $(".groupbox").droppable({
                drop: function (event, ui) {
                	//現在這一格
                	var cell_pos = $(this).attr("id")  ;		//班 class_班級代號
                	var cell_old_data = $(this).attr("has_teacher")  ;	//已排教師 (教師代號)

                	//拖拉進來的
                	var dropin_data_id = ui.draggable.attr('id') ;			//tea_代號
                	var dropin_data = ui.draggable.attr('data_ref') ;		//teacher_代號_姓名
                	var dropin_data_old = ui.draggable.attr('has_class') ;	//class_班級代號
                	if (cell_pos != dropin_data_old)
                		cell_set(cell_pos , cell_old_data , dropin_data_id , dropin_data , dropin_data_old) ;

                }

        });

});

//轉成使用班級名稱
function class_name( class_id) {
  var class_name_array= [];
  <{foreach  key=cid item=cname    from= $data.class_list_c }>
     class_name_array[<{$cid}>] = '<{$cname}>' ;
  <{/foreach}>
  return class_name_array[class_id] ;
}


//指定班級
function cell_set(cell_pos , cell_old_data , dropin_data_id , dropin_data , dropin_data_old) {
	/*
	//cell_pos 班 class_班級代號 id="class_304"
	//cell_old_data 已排教師 (教師代號) has_teacher="1"
	//dropin_data_id	tea_代號	id="box_1"
	//dropin_data	teacher_代號_姓名	data_ref="teacher_1_管理員:class_304"
	//dropin_data_old	 	//class_班級代號	 has_class="class_304"
	*/

	var tea_splits_first = dropin_data.split(':') ;
	var tea_splits = tea_splits_first[0].split('_') ;
	var cell_splits = cell_pos.split('_') ;
	var tea_id_splits = dropin_data_id.split('_') ;

	var cell_html = '<span class="tea" id="box_'+ tea_splits[1]  +'"  has_class="'+ cell_pos + '" data_ref="teacher_'+  tea_splits[1] + '_' + tea_splits[2] + ':'+ cell_splits  + '" >'+
				class_name(cell_splits[1]) +'_'+ tea_splits[2]+
				'<span class="fa fa-trash   del"  data_ref="teacher_'+  tea_splits[1] + ':'+ cell_splits  + '"  onclick="del_class_teacher(\''+ cell_pos +'\'  , \'' + dropin_data_id + '\');"></span></span>' ;
	$('#'+cell_pos) .html(cell_html) ;
	$('#'+cell_pos) .attr('has_teacher' , tea_splits[1] ) ;


	if (tea_id_splits[0]=='box') {
		//原在別班
		var old_class_id_splits = dropin_data_old.split('_') ;
		$('#'+dropin_data_old).html(class_name(old_class_id_splits[1] ))  ;


	}else{
		//如果是右方，則消失
		$('#'+ dropin_data_id).hide() ;
	}
	//原級任回復
	if (cell_old_data!='0')
			$('#tea_'+ cell_old_data).show() ;

	//再次指定為可拖動
    $(".tea").draggable({     	revert: "valid"   });
    $(".tea").css("z-index", 1999 );
    //寫入
    mark_id = dropin_data_id +':' + cell_pos ;
    ajax_set_teacher(mark_id) ;

}



      var ajax_set_teacher=function( tid ){
      	  //指定教師，寫入
      	  //tid    tea_1:class_304
             var URLs="ajax_set_teacher.php" ;

            $.ajax({
                url: URLs,
                type:"GET",
                dataType:'text',
				data:{id:tid , job:"<{$data.staff_teacher_id }>"} ,
                success: function(msg){
                    //alert(msg);
                },

                 error:function(xhr, ajaxOptions, thrownError){
                    alert('error:' + xhr.status);
                    alert(thrownError);
                 }
           })
        }

    //消除配對，刪除級任----------------------------------------------------------------------------------
  $(document).on("click", ".del", function(){

    var mark_id = $(this).attr("data_ref")  ;  //teacher_<{$data.class_set[$c_key]}>:class_<{$class_id}>
    var splits = mark_id.split(':') ;

    del_class_teacher(splits[1] , splits[0]  ) ;

  });

  function del_class_teacher(cell , teacher) {
  	var splits = cell.split('_') ;
  	//班級清空，出現班級名稱
    $('#'+ cell ).text( class_name( splits[1] )  ) ;

    //把右方教師顯示出來
    var splits = teacher.split('_') ;
    $('#tea_'+splits[1]).show() ;
    //alert('#tea_'+splits[1]) ;
 	var mark_id = teacher + ':' + cell ;
    ajax_del_teacher(mark_id) ;
  }

      var ajax_del_teacher=function( tid ){
      	  //刪除記錄
             var URLs="ajax_del_teacher.php" ;

            $.ajax({
                url: URLs,
                type:"GET",
                dataType:'text',
				data:{id:tid , job:"<{$data.staff_teacher_id }>"} ,
                success: function(msg){
                   // alert(msg);
                },

                 error:function(xhr, ajaxOptions, thrownError){
                   // alert('error:' + xhr.status);
                    alert(thrownError);
                 }
           })
        }

    //顯示全部的註冊人員、校內人員(切換)----------------------------------------------------------------------------------
    $(document).on("click", "#show_register", function(){
        var smode =  $(this).attr("smode")  ;

        ajax_show_teacher(smode) ;

    });

    var ajax_show_teacher=function( smode ){
        //
        var URLs="ajax_redisp_teacher.php" ;

        $.ajax({
            url: URLs,
            type:"GET",
            dataType:'text',
            data:{mode:smode } ,
            success: function(msg){
                //重顯示教師群
                $("#teacher_div").html(msg) ;
                $(".tea").draggable({
                	revert: "valid",
        		    });
                $(".tea").css("z-index", 1999 );
            },

            error:function(xhr, ajaxOptions, thrownError){
                alert('error:' + xhr.status);
                alert(thrownError);
            }
        })
    }


    </script>
