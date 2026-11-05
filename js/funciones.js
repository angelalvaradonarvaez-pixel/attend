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
           case "usuario":  
                document.location.href = "borra_usuario.php?registro="+id; 
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
           case "usuario":  
                document.location.href = "usuarios.php"; 
           break;

           }
}

function togglePasswordVisibility() {
        const passwordInput = document.getElementById('text_contra');
        const toggleIcon = document.getElementById('togglePass');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash'); // Changes icon to a "hidden" eye
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye'); // Changes icon back to a regular eye
        }
    }
