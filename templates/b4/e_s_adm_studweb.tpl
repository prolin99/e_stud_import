<div class="container-fluid">
    <form   method='post' >
    <fieldset>
    <legend>選擇班級</legend>
    <div class="row">
    <span class="col-1">班級：</span>
    <{html_options name=class_id  options=$data.class_name_list_c  selected=$data.select_class_id  onchange="submit();"  class="col-2" }><br />
    </div>
    <div class="row">
      <span class="col-1">個人樣版：</span>
	    <input type="text" name="tpl"  class="col-8" value="<{$tpl_str}>"  title="修改後，還要按下更新鍵" >
    </div>
<div class="row">
    <div class='col-5'>
        <label class="checkbox col-8"><input type="checkbox" value="notable" name="notable"  <{if ($Notable)}>checked<{/if}>>不使用表格</label>
        <button class="btn btn-primary  "   value="更新" name="act_renew" type="submit">更新</button>
    </div>
  </div>
	<div class="alert alert-info ">
	__class_id 班級代號 ,
__sitid 座號  ,
__00sitid 座號(補0二位數) ,
__name 學生姓名 ,
__00name 學生姓名(*同學) ,
__person_id 身份証號 ,
__birthday 生日 ,
__stud_id 學生代號 ,
__parent 學生監護人 ,
__00paren 學生監護人(*家長) ,
__sex 性別代碼
	</div>



    </fieldset>
    </form>
   <h3>偏好設定中保留常用樣式</h3>
   <textarea class="col-12" title="可以偏好中設定">
   <{foreach  key=t_key item=list    from= $tpl_list }>
  <{$list}>
   <{/foreach}>
   </textarea>
   <h3><{ $data.class_name_list_c[$data.select_class_id] }>-名冊匯出結果</h3>
	<{$main}>
 	<h3>網頁原始碼</h3>
	<textarea class="col-10" rows="20" name="dhcp"><{$main}></textarea>
</div>
