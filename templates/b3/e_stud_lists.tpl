<{$toolbar}>
    <form   class="form-inline" method='post' >

    <legend>班級名冊</legend>
    <div class="form-group">
    <label   for="class_id">班級：</label>
    <{html_options name=class_id id="class_id" class="form-control"  options=$data.class_name_list_c  selected=$data.select_class_id  onchange="submit();"   }>
    </div>
    <div class="form-group">
    <a class="btn btn-success"  href="export_namelist.php?class_id=<{$data.select_class_id}>" title="匯出EXCEL">本班名冊</a>
    <a class="btn btn-primary  " href="export_namelist.php?grade=1&class_id=<{$data.select_class_id}>" title="匯出EXCEL">學年名冊</a>
    <a class="btn btn-info " href="export_parentlist.php?class_id=<{$data.select_class_id}>" title="匯出WORD">家長代表選票</a>
    </div>
    </form>

<{ if ($data.list)}>
	<table class="table table-bordered table-hover col-md-4" >
	<tr>
   <td class="col-md-2">班級</td><td class="col-md-1">座號</td><td class="col-md-8">姓名</td>
   </tr>
   <{foreach  key=t_key item=list    from= $data.list }>
   <tr>
   <td><{$data.class_name_list_c[$list.class_id]}></td><td><{$list.class_sit_num}></td><td><{$list.name}></td>
   </tr>

   <{/foreach}>
   </table>
<{/if}>
