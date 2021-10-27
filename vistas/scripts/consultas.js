//Función Listar
function init()
{
	listar()
}
$("#fechainicio").change(listar);
$("#fechafin").change(listar);

function listar()
{
	fechainicio=$("#fechainicio").val();
	fechafin=$("#fechafin").val();
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
					url: '../ajax/consultas.php?op=listar&fechainicio='+fechainicio+'&fechafin='+fechafin,
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
init();