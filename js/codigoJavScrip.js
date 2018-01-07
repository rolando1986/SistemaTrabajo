$(document).ready(function() {
    setTimeout(function() {
        $(".mens").fadeOut(1500);
    },3000);
});

function enviar_formulario(){ 
	document.logout.submit() 
} 
function enviar_formularioHome(){ 
	document.home.submit() 
}


$( function() {
	$( "#datepicker" ).datepicker();
	$('#datepicker').datepicker('option', { dateFormat: 'yy/mm/dd' });
} );
$( function() {
	$( "#datepicker2" ).datepicker();
	$('#datepicker2').datepicker('option', { dateFormat: 'yy/mm/dd' });
} );

