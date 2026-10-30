function confirma_borrado(id,modulo)
{ if (confirm("Seguro de borrar \n" + modulo + " = " + id)) 
    {
    //alert("SI BORRAR")
        switch (modulo) 
           {
           case "sucursal":  
                document.location.href = "borra_sucursal.php?registro="+id;        
           break;
           case "departamento":  
                document.location.href = "borra_departamento.php?registro="+id; 
           break;
           case "importaciones":  
                document.location.href = "til/borra_importacion.php?registro="+registro; 
           break;

           }
    }
    else 
    {
    // alert("NO BORRAR")
    }
}

function regresar(modulo){ 
  switch (modulo) 
           {
           case "sucursal":  
                document.location.href = "sucursales.php";
           break;
           case "departamento":  
                document.location.href = "departamentos.php";    
           break;
           case "importaciones":  
                document.location.href = "til/borra_importacion.php?registro="+registro; 
           break;

           }
}
