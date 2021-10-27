var tabla;

$("#peso").change(calcularIMC);
$("#talla").change(calcularIMC);


function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})
}


function limpiar()
{
	$("#idatencion").val("");
	$("#presion_arterial").val("");
	$("#temperatura").val("");
	$("#frecuencia_respiratoria").val("");
	$("#frecuencia_cardiaca").val("");
	$("#saturacion").val("");
	$("#peso").val("");
	$("#talla").val("");
	$("#imc").val("");
	$("#estado").val("");
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
		$("#btnagregar").show();
	}
}


function cancelarform()
{
	limpiar();
	mostrarform(false);
}


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
					url: '../ajax/triaje.php?op=listar',
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


function guardaryeditar(e)
{
	e.preventDefault(); 
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/triaje.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	          
	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}

function mostrar(idatencion)
{
	$.post("../ajax/triaje.php?op=mostrar",{idatencion : idatencion}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#edad").val(data.edad);
		$("#dni").val(data.num_documento);
		$("#paciente").val(data.paciente);
		$("#especialista").val(data.especialista);
		$("#servicio").val(data.servicio);
 		$("#idatencion").val(data.idatencion);

 	})
}


function desactivar(idtriaje)
{
	bootbox.confirm("¿Está Seguro de desactivar el triaje?", function(result){
		if(result)
        {
        	$.post("../ajax/triaje.php?op=desactivar", {idtriaje : idtriaje}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}


function activar(idtriaje)
{
	bootbox.confirm("¿Está Seguro de activar el triaje?", function(result){
		if(result)
        {
        	$.post("../ajax/triaje.php?op=activar", {idtriaje : idtriaje}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}
function calcularIMC()
{
	var peso=$("#peso").val();
	var talla=$("#talla").val();

	

	if (peso!="" && talla!=""){

		
		$("#resultado").show();
		
		talla=talla/100;
		var imc=peso/(talla*talla);

		var estado="";

		if (imc<18){
			estado="Peso Bajo";
		}
		else if(imc>=18 && imc<25){
			estado="Peso Normal";
		}
		else if(imc>=25 && imc<27){
			estado="Sobrepeso";
		}
		else if(imc>=27 && imc<30){
			estado="Obesidad grado I";
		}
		else if(imc>=30 && imc<40){
			estado="Obesidad grado II";
		}
		else {
			estado="Obesidad grado III";	
		}


		$("#imc").val(imc.toFixed(2));
		$("#estado").val(estado);
		//Mostramos los resultados
	}
	else{
		//$("#resultado").hide();
	}
}


init();