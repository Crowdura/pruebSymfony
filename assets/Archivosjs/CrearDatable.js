export default function CrearDataTable()
{
   let Promaise = new Promise((resolve,reject)=>{
      $("#CargarDatos").on("click", function(event){  
         $.ajax({  
            url: '/PruebaAjax',  
            type:       'POST',   
            dataType:   'json',  
            async:      true,  
            
            success: function(data) {
             console.table(data);
             resolve(data);
            },  
            error : function(xhr, textStatus, errorThrown) {  
               alert('Ajax request failed.');  
            }  
            });  
         });
   });
   Promaise.then((data)=>{
      $('#TablaAjax').DataTable( {
         select: true,
         data: data,
         columns: [
            { data: "Id"},
            { data: "Codigo" },
            { data: "name" },
            { data: "Category"},
            { data: "Marca" },
            { data: "price" },
            { data: "Creado.date" },
            { data: "Actualizado.date" }
        ]
        } );
   })
}