$(document).ready(function(){	
 $('a.comment').toggle(function(){
  $(this).html('Скрыть форму ответа &uarr;');
  id = $(this).attr('id');  
  $('#form'+id).show();
  return false;
 },function (){
  $('#form'+id).hide();
  $(this).html('Ответить &darr;');	
  return false;
 });
});