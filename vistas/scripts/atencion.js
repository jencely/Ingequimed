var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});

	$("#formulariop").on("submit",function(e)
	{
		editarplan(e);	
	});
	$.post("../ajax/atencion.php?op=selectEspecialista", function(r){
	            $("#idempleado").html(r);
	            $('#idempleado').selectpicker('refresh');	
	});
	$.post("../ajax/atencion.php?op=selectServicio", function(r){
	            $("#idservicio").html(r);
	            $('#idservicio').selectpicker('refresh');	
	});
}

//$("#idservicio").change(mostrarValores);

//function mostrarValores()
  //{
    //datosServicio=document.getElementById('idservicio').value.split('_');
    //$("#costo").val(datosServicio[2]);
  //}

//Función limpiar
function limpiar()
{
	$("#idatencion").val("");
	$("#costo").val("");
	$("#idpaciente").val("");
	$("#paciente").val("");
	$("#documento").val("");

}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#formularioplan").hide();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#formularioplan").hide();
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
					url: '../ajax/atencion.php?op=listar',
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
	e.preventDefault(); 
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/atencion.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	          
	          mostrarform(false);
	          tabla.ajax.reload();

	          var url="http://www.ingequimed.com";
	          
	          window.onload=function(){
				abrirEnPestana(url);
			}
	    }

	});
	limpiar();
}

function mostrar(idatencion)
{
	$.post("../ajax/atencion.php?op=mostrar",{idatencion : idatencion}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		$("#costo").val(data.total);
 		$("#idatencion").val(data.idatencion);
 		$("#idpaciente").val(data.idpersona);
 		$("#paciente").val(data.paciente);
 		$("#idservicio").val(data.idservicio);
 		$("#idservicio").selectpicker('refresh');
 		$("#idempleado").val(data.idempleado);
 		$("#idempleado").selectpicker('refresh');
 		


 	})
}


function anular(idatencion)
{
	bootbox.confirm("¿Está Seguro de anular la atención?", function(result){
		if(result)
        {
        	$.post("../ajax/atencion.php?op=anular", {idatencion : idatencion}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

function buscarPaciente()
{
	var documento=$("#documento").val();
	$.post("../ajax/persona.php?op=buscar",{documento : documento}, function(data, status)
	{
		$("#idpaciente").val('');
		$("#paciente").val('');

		if (data==null){
			//mostrarform(true);
			$("#idpaciente").val('');
			$("#paciente").val('No existe el paciente');
		}
		else
		{
			data = JSON.parse(data);		
			//mostrarform(true);
			$("#idpaciente").val(data.idpersona);
			$("#paciente").val(data.apaterno + ' ' +data.amaterno + ' ' + data.nombre);
		}
		
 	})
}
function abrirEnPestana(url) {
		$("<a>").attr("href", url).attr("target", "_blank")[0].click();
}


var impuesto=18;
var cont=0;
var contr=1;
var detalles=0;
var valor=0;
$("#btnGuardarP").hide();


  function evaluar(){
  	if (detalles>0)
    {
      $("#btnGuardarP").show();
    }
    else
    {
      $("#btnGuardarP").show(); 
      cont=0;
    }
  }

  function eliminarDetalle(indice){
  	$("#fila" + indice).remove();
  	detalles=detalles-1;
  	evaluar();
  }



init();