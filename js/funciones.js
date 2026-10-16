function confirma_borrado(id,modulo)
{ if (confirm("Seguro de borrar \n" + modulo + " = " + id)) 
    {
    //alert("SI BORRAR")
        switch (modulo) 
           {
           case "sucursal":  
                document.location.href = "borra_sucursal.php?registro="+id;        
           break;
           case "cargadas":  
                document.location.href = "til/borra_cargada.php?registro="+registro; 
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