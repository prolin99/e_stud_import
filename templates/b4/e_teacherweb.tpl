
<{$toolbar}>

 <h3>教職員電子郵件帳號、網頁一覽表</h3>
    <table class="table  table-striped table-hover">
    <caption>教職員電子郵件帳號、網頁一覽表</caption>
    <thead>
    <tr><th scope="col">次序<{$i++}></th><th scope="col">職務</th><th scope="col">姓名</th><th scope="col">郵件</th><th scope="col">網頁</th></tr>
  </thead>
   <tbody>
	 <{foreach  key=key item=tea   from= $data.teacher }>
	 <tr scope="row">
	 	<td><{$i++}></td>
	 	  <td><{$tea.staff}></td>
	      <td><{$tea.name}></td>
	      <td><{$tea.email_show}></td>
	      <td>
	      	<{ if ($tea.url)}>
	      	<a href="<{$tea.url}>" target='_blank'><i class="fa fa-home"></i>個人網站</a>
	      	<{/if}>
	      </td>
	 </tr>
	 <{/foreach }>
   </tbody>
    </table>
