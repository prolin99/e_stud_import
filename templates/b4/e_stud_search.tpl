<{$toolbar}>
<form  class="form-inline"  method='post' >
    <fieldset>
    <legend>尋找學生</legend>
	姓名(可只輸入部份資料,多人以空白、換行輸入)： <br />
       <textarea name="stud_name"  class="form-control"    title="學生姓名"  ></textarea>
	<button class="btn btn-primary"   value="search" name="act_search" type="submit">搜尋</button>

    </fieldset>
    </form>

<{if ($data)}>
   <{foreach  key=t_key item=stud    from= $data.student }>
  <p><{$data.class_name_list_c[$stud.class_id]}>   (<{$stud.class_sit_num}>)號   <{$stud.name}> </p>
   <{/foreach}>
<{/if}>
