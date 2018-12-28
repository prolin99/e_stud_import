<link rel="stylesheet" href="<{$xoops_url}>/modules/tadtools/jquery/themes/base/jquery-ui.css">
<script src="<{$xoops_url}>/modules/tadtools/jquery/ui/jquery-ui.js"></script>
<style>
.groupbox {

    border: 1px dotted gray;
    background-color: #EEE;


}
.groupbox_list {

    border: 1px dotted gray;

}
</style>
<div class="container-fluid">
 <h3>指定群組</h3>

      <div class="row" >

      <div class="col-4" id="tea_div">
		<br />
      	<{foreach  key=c_key item=teacher    from= $data.teacher_list }>

      		   <span class="col-2 tea" data_ref="tea_<{$c_key}>_<{$teacher.name}>"   ><label  id="tea_<{$c_key}>" title='<{$teacher.name}>(<{$teacher.uname}>)' name_title='<{$teacher.name}>' class="badge badge-success">
      		   <{$teacher.name}></label><span id="i_<{$c_key}>" ></span></span>

      	<{/foreach }>


      </div>

      <div class="col-8" id="group_div">
      <div class="row">
      	<div class="col-2">拖曳到群組</div>
      	<div class="col-10">成員列表</div>
      </div>
      <{foreach  key=g_key item=group    from= $data.group_list }>
      <div class="row">
      	<div class="groupbox col-2" data_ref="group_<{$g_key}>"  title="拖放到此"  ><{$group}>(放在這)<br /><br /></div>
      	<div class="col-10" data_ref="group_<{$g_key}>" id="group_<{$g_key}>">
      		<{foreach  key=u_key item=user    from= $data.group_users_list[$g_key] }>
      		  <span class="col-2" data_ref="tea_<{$u_key}>_<{$user.name}>_group_<{$g_key}>"><label class="badge badge-success"><{$user.name}><span class="fa fa-trash  del" title="移除"></span></label></span>
      		<{/foreach}>
      	</div>
      </div>
      <{/foreach}>

      </div>


      </div>

      <div class="row">
      	<p>
            <span class="badge badge-info">說明</span><br/>
           把人員拖曳到各群組名稱上，就會加入該群組。垃圾桶圖示表示移出該群組。<br/>
           只出現校內教職員後的群組名稱。重複拖曳到同一群組，會出現多次姓名，但不影響資料的正確。
        </p>
      </div>
</div>
<script>

$(function () {
        //可拖動
        var zindex = 1000;
        $(".tea").draggable({
                revert: "valid",

                start: function(event, ui) { $(this).css("z-index", zindex++ ); }

        });

        //可接收
        $(".groupbox").droppable({
                drop: function (event, ui) {
                	var group = $(this).attr("data_ref")  ;
                    var user_data = ui.draggable.attr('data_ref')
                    set_group(user_data ,group) ;

                },
                out: function (event, ui) {
                        $(this).css("background-color", "")
                }
        });
});

function set_group(user_data ,group_box) {
	// user_data  tea_1_管理員
	var splits = user_data.split('_') ;
	var user = '<span class="col-2" data_ref="'+ user_data + '_' +group_box +'"><label class="badge badge-success">'+ splits[2]+ '<span class="fa fa-trash  del" title="移除"></span></label></span>' ;
    $('#' + group_box ).append(user) ;
    ajax_teacher_group(user_data +'_'+group_box , 'add') ;

}

    //消除 ----------------------------------------------------------------------------------
  $(document).on("click", ".del", function(){

    var mark_id = $(this).parent().parent().attr("data_ref")  ;
    //alert (mark_id) ;
    var splits = mark_id.split('_') ;
    $(this).parent().parent().remove() ;
 	ajax_teacher_group(mark_id, 'del') ;
  });

      var ajax_teacher_group=function( tid ,mode ){

      	  //記錄
            var URLs="ajax_set_group.php" ;

            $.ajax({
                url: URLs,
                type:"GET",
                dataType:'text',
				data:{id:tid,do:mode },
                success: function(msg){
                   // alert(msg);
                },

                 error:function(xhr, ajaxOptions, thrownError){
                    alert('error:' + xhr.status);
                    alert(thrownError);
                 }
           })
        }

</script>
