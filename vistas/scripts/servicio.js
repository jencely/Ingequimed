var tabla;


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
	$("#idservicio").val("");
	$("#nombre").val("");
	$("#costo").val("");
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
					url: '../ajax/servicio.php?op=listar',
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
		url: "../ajax/servicio.php?op=guardaryeditar",
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

function mostrar(idservicio)
{
	$.post("../ajax/servicio.php?op=mostrar",{idservicio : idservicio}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#nombre").val(data.nombre);
		$("#costo").val(data.costo);
 		$("#idservicio").val(data.idservicio);

 	})
}


function desactivar(idservicio)
{
	bootbox.confirm("¿Está Seguro de desactivar el servicio?", function(result){
		if(result)
        {
        	$.post("../ajax/servicio.php?op=desactivar", {idservicio : idservicio}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}


function activar(idservicio)
{
	bootbox.confirm("¿Está Seguro de activar el servicio?", function(result){
		if(result)
        {
        	$.post("../ajax/servicio.php?op=activar", {idservicio : idservicio}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}


init();