
  <script type='text/javascript' language='javascript' src='<{$xoops_url}>/modules/tadtools/fancyBox/source/jquery.fancybox.js?v=2.1.4'></script>
  <link rel='stylesheet' href='<{$xoops_url}>/modules/tadtools/fancyBox/source/jquery.fancybox.css?v=2.1.4' type='text/css' media='screen' />

<div class="container-fluid">

      <div class="row">
      <div class="col-6">
      <span class="badge badge-success bg-success">現在學生數：<{$data_list.students }> 人</span>
      <{if ($message) }>
      <div class="alert alert-danger"><{$message }> </div>
      <{/if}>
 		<form action ="main.php" enctype='multipart/form-data' method=post >
		<fieldset>
		<legend>學生資料檔案匯入</legend>
		<label>現在學年度：<{$c_year}> </label> </br>

 		<label>上傳 XML檔案 or XLSX (excel2007)檔案:</label>
		<input type=file name=userdata accept=".xml,.xlsx" >

		<input type='hidden' name='op' value='import'> <br /> <br />
		<button type='submit'  name='do_key' class='btn btn-primary'>同步</button>(名冊資料庫會先全部清除！)
		</fieldset>
		</form>

        <form action ="main.php" enctype='multipart/form-data' method=post class="alert alert-info">
		<fieldset>
		<legend>降昇年級、特定班學生名單</legend>
        一人一行，<br/>格式：身份証號-姓名-降(D)昇(A)年數or班級代號(三位數307表3年7班)，例<br/>R123456789-葉大雄-D1<br/>F123456789-王聰明-A1<br/>R221133441-陳小小-307<br/>
        <textarea name="updnlist" class="form-control"  rows="5" placeholder="以-做分隔，身份証號-姓名-降昇年數or班級代號" title="以-做分隔，身份証號-姓名-降昇年數or班級代號" alt="以-做分隔，身份証號-姓名-降昇年數or班級代號" ><{$es_stud_stud_dn}></textarea>
		<input type='hidden' name='op' value='UpDnListSet'> <br /> <br />
		<button type='submit'  name='do_key' class='btn btn-primary'>設定名單</button>（名單更新後，需重匯學生資料檔）
		</fieldset>
		</form>


		<div class="alert alert-info">
		<strong>相關說明：</strong>
		<a href='../health_sample.xlsx' target='_blank' class='btn btn-primary'>EXCEL 範例檔</a><br/>
		<div>使用 EXCEL 格式匯入，請依範例檔欄位填放資料，不使用的欄位也要保留。代號為學號或判別用的唯一值。</div>
		</div>

        <div class="alert alert-info">
		<strong>資料庫說明：</strong>
 		<div>有些學生姓名會使用到全字庫造字，修改如下：<br />
            xoops_data/data/secure.php  中的 XOOPS_DB_CHARSET 改 utf8mb4 <br />
        e_student 資料表 name 欄位也需改為 utf8mb4_general_ci </div>
		</div>

      </div>
      <div class="col-6">
      <h4>人數統計記錄</h4>
      	<{foreach  key=key item=rec   from= $recdata }>
      	<span class="col-3"><a href="statistics.php?id=<{$rec.id}>"    class="viewlog_fancy" title="<{$rec.rec_time}>" ><{$rec.rec_time|truncate:7:"" }></a><span class="fa fa-trash del" title="刪除"  data_ref="<{$rec.id}>" ></span></span>
      	<{/foreach}>
      </div>
      </div>
</div>
  <script type='text/javascript'>
    $(document).ready(function(){
      $(".viewlog_fancy").fancybox({
      fitToView : true,
      width   : '40%',
      height    : '70%',
      autoSize  : true,
      closeClick  : false ,
      type: "iframe"
      });

    });

    //清除記錄----------------------------------------------------------------------------------
  $(document).on("click", ".del", function(){
    	var iid = $(this).attr("data_ref")  ;
	if(confirm('是否確定要刪除？')) {
          		ajax_del( iid) ;  // 刪除動作
          		//alert (iid) ;
           		$(this).parent().hide() ;
        }
  });


   function ajax_del(iid )  {
  	$.ajax({
 		url: 'ajax_del_log.php',
 		type: 'GET',
 		//dateType:'json', //接收資料格式
 		data: {id: iid   },
 	})
 	.done(function(data) {
 		//console.log("success");
 		//取得 json 格式
	 	//var json_obj = jQuery.parseJSON(data) ;

 		//alert(data) ;
 	})
 	.fail(function() {
 		console.log("error");
 	})
 	.always(function() {
 		console.log("complete");
 	});


 }

 </script>
