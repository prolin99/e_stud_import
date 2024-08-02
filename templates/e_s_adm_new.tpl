<div class="container-fluid">

 <h3>教職員帳號順序</h3>
    <table class="table  table-striped table-hover">
    <tr><th>次序<{$i++}></th><th>職務</th><th>姓名</th><th>EMAIL帳號名稱</th> </tr>
	 <{foreach  key=key item=tea   from= $data.teacher }>
	 <tr>
	 	<td><{$i++}></td>
	 	  <td><{$tea.staff}></td>
	      <td><{$tea.name}></td>
	      <td><{$tea.email_account}></td>

	 </tr>
	 <{/foreach }>

    </table>
</div>
