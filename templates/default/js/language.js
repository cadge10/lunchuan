// JavaScript Document
function setLanguage(value){
	$.get('index.php',{r:Math.random(),a:'ajax',mod:'set_lang','lang':value},function(data){
		if ($.trim(data)=='success'){
			window.location.reload();
		}else{
			alert('no');
		}
	});
}
