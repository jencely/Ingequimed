var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});
	$("#sexo").val('F');
	$("#sexo").selectpicker('refresh');
	$("#estado_civil").val('S');
	$("#estado_civil").selectpicker('refresh');
	$("#tipo_documento").val('DNI');
	$("#tipo_documento").selectpicker('refresh');
}

//Función limpiar
function limpiar()
{
	$("#apaterno").val("");
	$("#amaterno").val("");
	$("#nombre").val("");
	$("#fecha_nacimiento").val("");
	$("#sexo").val("");
	$("#estado_civil").val("");
	$("#alergia").val("");
	$("#intervenciones_quirurgicas").val("");
	$("#tipo_documento").val("");
	$("#num_documento").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#ocupacion").val("");
	$("#persona_responsable").val("");
	$("#idpersona").val("");
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		$("#dbuscar").hide();
		$("#formulariohistoria").hide();
		$("#btncerrar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
		$("#dbuscar").show();
		$("#formulariohistoria").hide();
		$("#btncerrar").hide();
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
	texto=$("#texto").val();
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
					url: '../ajax/persona.php?op=listar&texto='+texto,
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,
	    "order": [[ 0, "desc" ]]
	}).DataTable();
}


function guardaryeditar(e)
{
	e.preventDefault(); 
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/persona.php?op=guardaryeditar",
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

function mostrar(idpersona)
{
	$.post("../ajax/persona.php?op=mostrar",{idpersona : idpersona}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#apaterno").val(data.apaterno);
		$("#amaterno").val(data.amaterno);
		//$("#tipo_documento").selectpicker('refresh');
		$("#nombre").val(data.nombre);
		$("#fecha_nacimiento").val(data.fecha_nacimiento);
		$("#sexo").val(data.sexo);
		$("#sexo").selectpicker('refresh');
		$("#estado_civil").val(data.estado_civil);
		$("#estado_civil").selectpicker('refresh');
		
		$("#vacunas_completas").val(data.vacunas_completas);
		$("#vacunas_completas").selectpicker('refresh');
		$("#intervenciones_quirurgicas").val(data.intervenciones_quirurgicas);
		$("#alergia").val(data.alergia);


		$("#tipo_documento").val(data.tipo_documento);
		$("#tipo_documento").selectpicker('refresh');
		$("#num_documento").val(data.num_documento);
		$("#direccion").val(data.direccion);
		$("#telefono").val(data.telefono);
		$("#email").val(data.email);
		$("#ocupacion").val(data.ocupacion);
		$("#persona_responsable").val(data.persona_responsable);
 		$("#idpersona").val(data.idpersona);
 	})
}

function historia(idpersona)
{
		$.post("../ajax/atencion.php?op=ListarAtenciones&idp="+idpersona,function(r){
	        $("#hisotoriac").html(r);
		});

		$("#listadoregistros").hide();
		$("#formularioregistros").hide();
		$("#formulariohistoria").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		$("#dbuscar").hide();
		$("#btncerrar").show();

		
}

function eliminar(idpersona)
{
	bootbox.confirm("¿Está Seguro de eliminar el paciente?", function(result){
		if(result)
        {
        	$.post("../ajax/persona.php?op=eliminar", {idpersona : idpersona}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

init();