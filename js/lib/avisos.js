$(function(){
	$("#data_divulgacao").mask("99/99/9999");

	$("#data_divulgacao").datepicker();

	jQuery("#form_avisos").validationEngine();
});