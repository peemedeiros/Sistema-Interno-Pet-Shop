function validarEntrada(caracter,typeBlock){
    //charCode converte o caracter digitado em ascii
        
    //Serve para padronizar a conversão em ascii em todas as versões de navegadores.
    //Os que são baseados em janela ou não
    
    var tipo = typeBlock;
    
    if(window.event){
        var asc = caracter.charCode;
    }else{
        var asc = caracter.which;
    }

        //valida apenas a digitação de letra
    if(tipo == "numeric"){
       if(asc >=48 && asc<=57){

            //cancela da tecla digitada

            return false;
        }
    
    }else if(tipo == "string"){
        if(asc < 48 || asc > 57){
            return false;
        }
    }
}
function mascaraFone(obj,caracter){
   
	var input = obj.value;
	var id = obj.id;
	var cel = obj.name;
	var resultado = input;
	
    if(validarEntrada(caracter, "string") == false){
        return false;
    }else if(cel == "txt-cliente-celular"){
		
		if(input.length == 0){
            resultado = "(";
        }else if(input.length == 3){
            resultado += ")";
        }else if(input.length == 13){
            return false;
        }

        document.getElementById(id).value = resultado;
		
	}else{
			 
        if(input.length == 0){
            resultado = "(";
        }else if(input.length == 3){
            resultado += ")";
        }else if(input.length == 13){
            return false;
        }

        document.getElementById(id).value = resultado;
        }
}
function mascaraCep(obj,caracter){
   
	var input = obj.value;
	var id = obj.id;
	var cep = obj.name;
	var resultado = input;
	
    if(validarEntrada(caracter, "string") == false){
        return false;
    }else if(cep == "txt-cliente-cep" || cep =="txt-transporte-cep" || cep == "txt-cep-ordem"){
		
		if(input.length == 5){
            resultado += "-";
        }else if(input.length == 9){
            return false;
        }

        document.getElementById(id).value = resultado;
	}
}
function mascaraUf(obj,caracter){
   
	var input = obj.value;
	var id = obj.id;
	var uf = obj.name;
	var resultado = input;
	
    if(validarEntrada(caracter, "numeric") == false){
        return false;
    }else if(uf == "txt-estado"){
		
		if(input.length == 2){
            return false;
        }

        document.getElementById(id).value = resultado;
	}
}
function mascaraAniversario(obj,caracter){
    var input = obj.value;
	var id = obj.id;
	var aniversario = obj.name;
	var resultado = input;
	
    if(validarEntrada(caracter, "string") == false){
        return false;
    }else if(aniversario == "txt-cliente-nascimento"){
		
		if(input.length == 2){
            resultado += "/";
        }else if(input.length == 5){
            return false;
        }
        document.getElementById(id).value = resultado;
	}
}