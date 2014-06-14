<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-02-16
// $Id:$
// ------------------------------------------------------------------------- //

define("_MI_ESTUDENTS_NAME","單位名冊");
define("_MI_ESTUDENTS_AUTHOR","prolin (prolin@tn.edu.tw)");
define("_MI_ESTUDENTS_CREDITS","prolin");
define("_MI_ESTUDENTS_DESC","此模組的用途是匯入學生資料、設定教職員資料，以提供相關模組使用。");
//define("_BACK_MODULES_PAGE","回模組首頁");
//define("_MI_MODULE_ADMENU1", "主管理介面");
 
define("_MI_ESTUDENTS_CONFIG_TITLE1", "教師的群組");
define("_MI_ESTUDENTS_CONFIG_DESC1", "要設定教師所在的群組，才能在設定級任時呈現");

define("_MI_ESTUDENTS_CONFIG_TITLE2", "職稱");
define("_MI_ESTUDENTS_CONFIG_DESC2", "以逗號或行分隔， 1 2 5 1 01-教務主任 (無空白)<br/>表示(職別_處室別_群組別_僅一人_序號-職稱)<br/>說明：<br/>1.職別：0校長 1主任 2組長 3教師 4職員 <br/>2.處室：0校長 1教務 2學務 3總務 4輔導 5職員 6教師 7幼稚園 <br/>3.群組：5教務 6學務 7總務 8輔導 (配合輕鬆架設定) <br/>4.唯一值：1唯一 (設定後會自動消失)<br/>5.兩位數代號<br/>990000-離職人員，會移出校內人員群組。  ");

define("_MI_ESTUDENTS_CONFIG_TITLE3", "常用匯出樣式");
define("_MI_ESTUDENTS_CONFIG_DESC3", "分行分隔。<br />__class_id 班級代號 <br />__sitid 座號 <br />__name 學生姓名 <br />__person_id 身份証號 <br />__birthday 生日<br />__stud_id 學生代號 <br />__parent 學生監護人<br /> __sex 性別代碼 ");
?>