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

function valida_alta_sucursal(){ 
//  valida el ID

if ( document.fsucursal.text_idsuc.value.trim() == ""){ 
    alert("Especifique el ID.");
    document.fsucursal.text_idsuc.focus();
     return;
}

//  valida la descripcion
descripcion = document.fsucursal.text_dessuc.value;
if (document.fsucursal.text_dessuc.value.trim() == ""){ 
    alert("Especifique la descripción.");
    document.fsucursal.text_dessuc.focus();
     return;
}
//-------------------------------------------------------
//el formulario es enviado
//alert("Se envia el formulario para grabar.");
   document.fsucursal.submit();
}
