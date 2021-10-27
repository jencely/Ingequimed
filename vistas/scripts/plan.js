var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})
}

//Función limpiar
function limpiar()
{
	$("#idatencion").val("");
	$("#tiempo_enfermedad").val("");
	$("#antecedentes").val("");
	$("#examen_fisico").val("");
	$("#tratamiento").val("");
	$("#receta").val("");
	$("#proxima_cita").val("");
	$("#motivo_consulta").val("");
	$("#plan").val("");
	$("#texto").val("");
	$("#diagnosticos").html("");
	//$("#estado").val("");
	$(".filas").remove();
	$(".filasr").remove();
	cont=0;
	contr=1;
	detalles=0;
	$("#btnGuardar").hide();

	
}


function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,
	    "aServerSide": true,
	    dom: 'Bfrtip',
	    buttons: [		          
		            
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/resultado.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5
	}).DataTable();
}

//Función para guardar o editar
function guardaryeditar(e)
{
	idatencion=$("#idatencion").val();
	e.preventDefault(); 
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/resultado.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	          
	          mostrarform(false);
	          tabla.ajax.reload();
	          window.open("../reportes/historia.php?idatencion=" +idatencion, '_blank');
	          window.open("../reportes/receta.php?idatencion=" +idatencion, '_blank');
	    }

	});
	limpiar();
}

function mostrar(idatencion)
{
	$.post("../ajax/resultado.php?op=mostrar",{idatencion : idatencion}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#edad").html(data.edad);
		$("#dni").html(data.num_documento);
		$("#paciente").html(data.paciente);
		$("#especialista").html(data.especialista);
		$("#servicio").html(data.servicio);
 		$("#idatencion").val(data.idatencion);

 		$("#presion_arterial").val(data.presion_arterial);
 		$("#temperatura").val(data.temperatura);
 		$("#frecuencia_respiratoria").val(data.frecuencia_respiratoria);
 		$("#frecuencia_cardiaca").val(data.frecuencia_cardiaca);

 		$("#saturacion").val(data.saturacion);
 		$("#peso").val(data.peso);
 		$("#talla").val(data.talla);
 		var imc2=Number(data.imc);
 		$("#imc").val(imc2.toFixed(2));

 		$("#idpersona").val(data.idpersona);
 		$("#alergia").val(data.alergia);
 		$("#intervenciones_quirurgicas").val(data.intervenciones_quirurgicas);
 		$("#vacunas_completas").val(data.vacunas_completas);
 		$("#vacunas_completas").selectpicker('refresh');
 	})
}

function buscarDiagnostico()
{
	var texto=$("#texto").val();
	$.post("../ajax/resultado.php?op=diagnosticos&texto="+texto,function(r){
	        $("#diagnosticos").html(r);
	});
}

var impuesto=18;
var cont=0;
var contr=1;
var detalles=0;
$("#btnGuardar").hide();



  function evaluar(){
  	if (detalles>0)
    {
      $("#btnGuardar").show();
    }
    else
    {
      $("#btnGuardar").hide(); 
      cont=0;
    }
  }

  function eliminarDetalle(indice){
  	$("#fila" + indice).remove();
  	detalles=detalles-1;
  	evaluar();
  }

function eliminarReceta(indice){
  	$("#filar" + indice).remove();
  }

init();