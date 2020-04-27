function nuevaEmpresa(idDepto, idCiudad){
var html = '<form>'; 
	html +='      <div class="form-group">';
	html +='          <div class="row">';
	html +='            <div class="col col-12 col-md-6">';
	html +='            <label id="frmnit" for="nit" class="col-sm-12 col-form-label">CC/NIT :<span id="sofia" style="color:green" ></span></label>';
	html +='              <input id="nit" type="text" class="form-control">';
	html +='            </div>';	
  html +='                <script>';
  html +='                $(nit).ready(function() {';
  html +='                $("#nit").focusout(function(){';  
  html +='                var dato = $(this).val(); ';
  html +='                traerempresaeditnit(dato);';
  html +='                 }) ';
  html +='                 }).trigger;';
  html +='                </script>'; 
	html +='            <div class="col col-12 col-md-6">';
	html +='            <label id="frmempresa"  for="nempresa" class="col-sm-12 col-form-label">Nombre Empresa:</label>';
  html +='              <input id="nempresa" type="text" class="form-control">';
	html +='            </div>';
	html +='          </div>';
	html +='          <div class="row">';
	html +='            <div class="col-12 col-md-6">';
	html +='            <label id="frmdepto" for="depto" class="col-sm-12 col-form-label">Departamento :</label>';
	html +='			  <select id="depto" class="form-control">'; 
	html +='			  </select>'; 
	html +='            </div>';
	html +='            <div class="col-12 col-md-6">';
	html +='            <label id="frmciudad" for="ciudad" class="col-sm-12 col-form-label">Ciudad :</label>';
	html +='				<select id="ciudad" class="form-control">'; 
	html +='				</select>'; 
	html +='            </div>';
	html +='          </div>';
	html +='          <div class="form-group">';
	html +='            <label id="frmdireccion" for="direccion" class="col-sm-4 col-form-label">Dirección :</label>';
	html +='              <input id="direccion" type="text" class="form-control">';
	html +='          </div>';
  html +='          <div class="row">';
  html +='            <div class="col col-12 col-md-6">';
  html +='            <label id="frmncontacto" for="ncontacto" class="col-sm-12 col-form-label">Nombre contacto :</label>';
  html +='              <input id="ncontacto" type="text" class="form-control">';
  html +='            </div>';
  html +='            <div class="col col-12 col-md-6">';
  html +='            <label id="frmtcontacto" for="tcontacto" class="col-sm-12 col-form-label">Teléfono contacto :</label>';
  html +='              <input id="tcontacto" type="text" class="form-control" onkeypress="return soloTelefono(event,\'btncrearempresa\')" onpaste="return false">';
  html +='            </div>';
  html +='          </div>';

	html +='          <div class="form-group">';
	html +='            <label id="frmcorreo" for="correo" class="col-sm-12 col-form-label">Correo:</label>';
	html +='            <input id="correo" type="text" class="form-control">';
	html +='          </div>';


	html +='        </form>';

	  html+='<script>'; 
	  html+=' traerldepto('+idDepto+');';  
	  html+=' traerlciudad('+idDepto+','+idCiudad+');';    

    html+='$(document).ready(function() {';
     html+='$("#depto").change(function(){';
          html+='var dato = $(this).val(); ';
          html+=' traerlciudad(dato,\'0\');';                              
     html+=' }) ';
     html+=' }).trigger;';                        
	  html+='</script>';	

	html +='<div id="msalida">';
	html +='</div>';
	  vtnmodalsm();  
	  $('#myModalLabel').html('NUEVA EMPRESA: ');
	  $('#bodymodal').html(html);

	  boton = '<button id="btncrearempresa" type="button" onClick="crearempresa(\'0\');" class="btn btn-primary">Guardar</button>';
	  $("#btnact").html(boton);
	  $('#myModal').modal('show');                                  
}

function crearempresa(id){
var correcto = '1';
var mensajeerror = '';
var nempresa = $('#nempresa').val();
var nit = $('#nit').val();
var direccion = $('#direccion').val();
var ncontacto = $('#ncontacto').val();
var tcontacto = $('#tcontacto').val();
var correo = $('#correo').val();
var ciudad = '0';
var depto = '0';
$("#depto").change(function () {
    $("#depto option:selected").each(function () {
      depto = $(this).val();
        });
}).trigger('change'); 
$("#ciudad").change(function () {
    $("#ciudad option:selected").each(function () {
      ciudad = $(this).val();
        });
}).trigger('change'); 
 
if(nempresa.length < 2){
   correcto = '0';
   $('#frmempresa').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">Debe escribir el nombre de la empresa.<p>';
}else{
   $('#frmempresa').removeClass('alert-danger');
   $('#frmempresa').addClass('alert-ligh');
}
if(nit.length < 2){
   correcto = '0';
   $('#frmnit').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">Olvidó escribir CC o NIT de la empresa.<p>';
}else{
   $('#frmnit').removeClass('alert-danger');
   $('#frmnit').addClass('alert-ligh');
}

if(direccion.length < 2){
   correcto = '0';
   $('#frmdireccion').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">Falta la dirección de la empresa.<p>';
}else{
   $('#frmdireccion').removeClass('alert-danger');
    $('#frmdireccion').addClass('alert-ligh');
}

if(depto == '0'){
   correcto = '0';
   $('#frmdepto').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">Debe seleccionar el Departamento donde está ubicada la empresa.<p>';
}else{
   $('#frmdepto').removeClass('alert-danger');
   $('#frmdepto').addClass('alert-ligh');
}
if(ciudad == '0'){
   correcto = '0';
   $('#frmciudad').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">Es necesario seleccionar la ciudad donde está ubicada la empresa.<p>';
}else{
   $('#frmciudad').removeClass('alert-danger');
   $('#frmciudad').addClass('alert-ligh');
}

if(ncontacto.length < 2){
   correcto = '0';
   $('#frmncontacto').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">Recuerde registrar el nombre de su contacto en la empresa.</p>';
}else{
   $('#frmncontacto').removeClass('alert-danger');
   $('#frmncontacto').addClass('alert-ligh');
}

if(tcontacto.length < 10){
   correcto = '0';
   $('#frmtcontacto').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">Escriba el numero telefónico de su contacto.</p>';
}else{
   $('#frmtcontacto').removeClass('alert-danger');
   $('#frmtcontacto').addClass('alert-ligh');
}
if(correo.length < 1){
   correcto = '0';
   $('#frmcorreo').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">Se requiere registrar un correo de contacto.</p>';
}else{
   $('#frmcorreo').removeClass('alert-danger');
   $('#frmcorreo').addClass('alert-ligh');
}

if(correo.length > 1 && validaremail(correo) == '0'){
  correcto = '0';
   $('#frmcorreo').addClass('alert-danger');
   mensajeerror = mensajeerror + '<p class="mb-0">El correo no corresponde a un formato válido.</p>';
}else{
    $('#frmcorreo').removeClass('alert-danger');
   $('#frmcorreo').addClass('alert-ligh'); 
}
  if(correcto == '1'){
      //$('#btncrearempresa').attr('disabled', 'disabled');
	  var parametros={ 
    	'dato':'empresa',
    	'request':'update', 
      'id':id, 	
  		'nempresa':nempresa,
  		'nit':nit, 
  		'direccion':direccion,
  		'depto':depto,
  		'ciudad':ciudad,
  		'ncontacto':ncontacto,
  		'tcontacto':tcontacto,
  		'correo':correo 
	  };   
      $.ajax({ //inicia la funcion ajax
          type:"POST", //tipo de envio: post o get como en un formulario web
          url:"../../views/com/empresacom.php", //Trae datos para editar    
          dataType:"html", //tipo de data que retorna
          data:parametros
          }).done(function(data){ 
            listEmpresa();
            $('#myModal').modal('hide');            
	          $('#msalida').html('');
          });     
  }else{
     $('#btncrearempresa').attr('disabled', false);
     aCommand: toastr["warning"]("Faltan datos para realizar el proceso"); 
     var mens ='<div id="mserr" class="alert alert-danger" role="alert">';
		 mens += 	   '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
		 mens += 	     '<span aria-hidden="true">&times;</span>';
		 mens += 	   '</button>';
         mens += '<h4 class="alert-heading"><strong>Hay datos por revisar!</strong></h4><hr>' ;
         mens += '<p><b>Antes de continuar debe ingresar estos datos:</b></p><br>';
         mens += mensajeerror;
         mens +='</div>';
     $('#msalida').html(mens);
      }
}

function traerempresaedit(id){ 
  //nuevaEmpresa(0,0);
  var parametros = {
    dato:'empresa',
    request:'edit',   
    'id':id 
  };  
try{
      var html = '';  
      $.ajax({ //inicia la funcion ajax
      type:'POST', //tipo de envio: post o get como en un formulario web
      url:"../../views/com/empresacom.php", //url del archivo a llamar y que hace el procedimiento
      dataType:'html',
      data:parametros
      }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo getSuma.php    
          var datosRecibidos = JSON.parse(data); 
            $.each(datosRecibidos, function(key,value) {
              if(value.respuesta == '1'){
                nuevaEmpresa(value.idDepto,value.idCiudad);
                console.log(Encoder.htmlDecode(value.empresa));
                $('#nempresa').val(Encoder.htmlDecode(value.empresa));
                $('#nit').val(value.nit);
                $('#direccion').val(Encoder.htmlDecode(value.direccion));
                $("#depto > option[value="+value.idDepto+"]").attr("selected", "selected");
                $("#ciudad > option[value="+value.idCiudad+"]").attr("selected", "selected"); 
                $('#ncontacto').val(Encoder.htmlDecode(value.nombre));
                $('#tcontacto').val(Encoder.htmlDecode(value.telefono));
                $('#correo').val(Encoder.htmlDecode(value.correo));
                $('#btnact').html('<button id="btncrearempresa" type="button" onclick="crearempresa(\''+value.id+'\');" class="btn btn-primary">Actualizar</button>');
              }
                
             });                 
      });
    }
    catch(ex){
        alert(ex);
    }  
}


function traerempresaeditnit(nit){ 
  //nuevaEmpresa(0,0);
  var parametros = {
    dato:'empresa',
    request:'validar',   
    'nit':nit 
  };  
try{
      var html = '';  
      $.ajax({ //inicia la funcion ajax
      type:'POST', //tipo de envio: post o get como en un formulario web
      url:"../../views/com/empresacom.php", //url del archivo a llamar y que hace el procedimiento
      dataType:'html',
      data:parametros
      }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo getSuma.php    
          var datosRecibidos = JSON.parse(data); 
            $.each(datosRecibidos, function(key,value) {
              if(value.respuesta == '1'){
                //$('#myModal').modal('hide'); 
                //nuevaEmpresa(value.idDepto,value.idCiudad);
                //console.log(Encoder.htmlDecode(value.empresa));
                $('#nempresa').val(Encoder.htmlDecode(value.empresa));
                $('#nit').val(value.nit);
                $('#direccion').val(Encoder.htmlDecode(value.direccion));
                traerldepto(value.idDepto);
                traerlciudad(value.idDepto,value.idCiudad);
                if(value.sofia == '1'){
                  $('#sofia').html('<i class="fas fa-check-circle"></i>')
                }
                //$("#depto > option[value="+value.idDepto+"]").attr("selected", "selected");
                //$("#ciudad > option[value="+value.idCiudad+"]").attr("selected", "selected"); 
                //$('#ncontacto').val(Encoder.htmlDecode(value.nombre));
                //$('#tcontacto').val(Encoder.htmlDecode(value.telefono));
                //$('#correo').val(Encoder.htmlDecode(value.correo));
                $('#btnact').html('<button id="btncrearempresa" type="button" onclick="crearempresa(\''+value.id+'\');" class="btn btn-primary">Actualizar</button>');
              }else{
                $('#nempresa').val('');
                $('#direccion').val('');
                //$("#depto > option[value="+value.idDepto+"]").attr("selected", "selected");
                //$("#ciudad > option[value="+value.idCiudad+"]").attr("selected", "selected"); 
                $('#ncontacto').val('');
                $('#tcontacto').val('');
                $('#correo').val('');
                $('#btnact').html('<button id="btncrearempresa" type="button" onclick="crearempresa(\'0\');" class="btn btn-primary">Guardar</button>');
              }
                
             });                 
              
      });
    }
    catch(ex){
        alert(ex);
    }  
}

function listEmpresa(){
  var parametros = {
      dato:'empresa',
      request:'list'
  }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../../views/com/empresacom.php", //url del archivo a llamar y que hace el procedimiento
    dataType:"html", //tipo de data que retorna
    data:parametros
    }).done(function(data){
      console.log(data);
      $('#centro-content').html(data);
    });
}

function traerldepto(idDepto){
	var parametros = {
    	dato:'depto',
    	request:'select' 
    }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../../views/com/empresacom.php", //url del archivo a llamar y que hace el procedimiento
    dataType:"html", //tipo de data que retorna
    data:parametros
    }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php
      var datosRecibidos = JSON.parse(data);
        $.each(datosRecibidos, function(key,value) { 
              switch(value.respuesta){
              case '5':
                    swal("Programación Centro!", "Debe iniciar Sesión...", "warning");
                    frmlogin();
              break;
              case '0':
                    swal("Programación Centro!", "No hay Departamentos creadas o activos", "warning");                    
              break;              
              case '1':
                  $('#depto').html(value.datos);  
                  $("#depto > option[value="+idDepto+"]").attr("selected", "selected");
              break;                 
            }
          
           });              
    });             
}

function traerlciudad(idDepto, idCiudad){
    var parametros = {
        dato:'ciudad',
        request:'select',    	
        idDepto:idDepto
    }
    $.ajax({ //inicia la funcion ajax
    type:"POST", //tipo de envio: post o get como en un formulario web
    url:"../../views/com/empresacom.php", //url del archivo a llamar y que hace el procedimiento
    dataType:"html", //tipo de data que retorna
    data:parametros
    }).done(function(data){ //donde se ejecuta al terminar la ejecucion del archivo php 
      var datosRecibidos = JSON.parse(data);
        $.each(datosRecibidos, function(key,value) { 
              switch(value.respuesta){
              case '5':
                    swal("Programación Centro!", "Debe iniciar Sesión...", "warning");
                    frmlogin();
              break;
              case '0':
                    swal("Programación Centro!", "No hay Departamentos creadas o activos", "warning");                    
              break;              
              case '1':
                  $('#ciudad').html(value.datos); 
                  $("#ciudad > option[value="+idCiudad+"]").attr("selected", "selected"); 
              break;                 
            }
           });   
    });             
}

function nuevaFicha(){
var html = '';
html +='      <form>';
html +='          <div class="form-group">';
html +='            <label for="recipient-name" class="col-form-label">Recipient:</label>';
html +='            <input type="text" class="form-control" id="recipient-name">';
html +='          </div>';
html +='          <div class="form-group">';
html +='            <label for="message-text" class="col-form-label">Message:</label>';
html +='            <textarea class="form-control" id="message-text"></textarea>';
html +='          </div>';
html +='        </form>';
html +='      </div>';
  vtnmodalsm();  
  $('#myModalLabel').html('Cantidad adicional de: <b></b>');
  $('#bodymodal').html(html);
  $('#myModal').modal('show');                                   
}

function vtnmodalsm(){
var html = '';
html +='<div class="modal fade bd-example-modal-xl" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
html +='  <div class="modal-dialog modal-xl" role="document">';
html +='    <div class="modal-content">';
html +='      <div class="modal-header">';
html +='        <h5 class="modal-title" id="myModalLabel">New message</h5>';
html +='        <button type="button" class="close" data-dismiss="modal" aria-label="Close">';
html +='          <span aria-hidden="true">&times;</span>';
html +='        </button>';
html +='      </div>';
html +='      <div id="bodymodal" class="modal-body">';
html +='      </div>';
html +='      <div class="modal-footer">';
html +='      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>';
html +='      <span id="btnact"></span> ';
html +='      </div>';
html +='    </div>';
html +='  </div>';
html +='</div>';
$('#placemodal').html(html);          
}

function validaremail(email) {
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) ){
        return '0';
      }else{
        return '1';
      }
}

function soloTelefono(e,nboton){ 
key =e.keyCode || e.which;
teclado = String.fromCharCode(key).toLowerCase();
letras = ",0123456789";
especiales = "8-37-38-46-164";
teclado_especial = false;
for (var i in especiales){
  if(key==especiales[i]){
    teclado_especial=true;break;
  }  
}
if (key === 13) {
    document.getElementById(nboton).click();
} 
if(letras.indexOf(teclado)==-1 && !teclado_especial){
  return false;
   }   
}
Encoder = {

  // When encoding do we convert characters into html or numerical entities
  EncodeType : "entity",  // entity OR numerical

  isEmpty : function(val){
    if(val){
      return ((val===null) || val.length==0 || /^\s+$/.test(val));
    }else{
      return true;
    }
  },
  
  // arrays for conversion from HTML Entities to Numerical values
  arr1: ['&nbsp;','&iexcl;','&cent;','&pound;','&curren;','&yen;','&brvbar;','&sect;','&uml;','&copy;','&ordf;','&laquo;','&not;','&shy;','&reg;','&macr;','&deg;','&plusmn;','&sup2;','&sup3;','&acute;','&micro;','&para;','&middot;','&cedil;','&sup1;','&ordm;','&raquo;','&frac14;','&frac12;','&frac34;','&iquest;','&Agrave;','&AACUTE;','&Acirc;','&Atilde;','&Auml;','&Aring;','&AElig;','&Ccedil;','&Egrave;','&EACUTE;','&Ecirc;','&Euml;','&Igrave;','&IACUTE;','&Icirc;','&Iuml;','&ETH;','&Ntilde;','&Ograve;','&OACUTE;','&Ocirc;','&Otilde;','&Ouml;','&times;','&Oslash;','&Ugrave;','&UACUTE;','&Ucirc;','&Uuml;','&Yacute;','&THORN;','&szlig;','&agrave;','&aacute;','&acirc;','&atilde;','&auml;','&aring;','&aelig;','&ccedil;','&egrave;','&eacute;','&ecirc;','&euml;','&igrave;','&iacute;','&icirc;','&iuml;','&eth;','&ntilde;','&ograve;','&oacute;','&ocirc;','&otilde;','&ouml;','&divide;','&oslash;','&ugrave;','&uacute;','&ucirc;','&uuml;','&yacute;','&thorn;','&yuml;','&quot;','&amp;','&lt;','&gt;','&OElig;','&oelig;','&Scaron;','&scaron;','&Yuml;','&circ;','&tilde;','&ensp;','&emsp;','&thinsp;','&zwnj;','&zwj;','&lrm;','&rlm;','&ndash;','&mdash;','&lsquo;','&rsquo;','&sbquo;','&ldquo;','&rdquo;','&bdquo;','&dagger;','&Dagger;','&permil;','&lsaquo;','&rsaquo;','&euro;','&fnof;','&Alpha;','&Beta;','&Gamma;','&Delta;','&Epsilon;','&Zeta;','&Eta;','&Theta;','&Iota;','&Kappa;','&Lambda;','&Mu;','&Nu;','&Xi;','&Omicron;','&Pi;','&Rho;','&Sigma;','&Tau;','&Upsilon;','&Phi;','&Chi;','&Psi;','&Omega;','&alpha;','&beta;','&gamma;','&delta;','&epsilon;','&zeta;','&eta;','&theta;','&iota;','&kappa;','&lambda;','&mu;','&nu;','&xi;','&omicron;','&pi;','&rho;','&sigmaf;','&sigma;','&tau;','&upsilon;','&phi;','&chi;','&psi;','&omega;','&thetasym;','&upsih;','&piv;','&bull;','&hellip;','&prime;','&Prime;','&oline;','&frasl;','&weierp;','&image;','&real;','&trade;','&alefsym;','&larr;','&uarr;','&rarr;','&darr;','&harr;','&crarr;','&lArr;','&uArr;','&rArr;','&dArr;','&hArr;','&forall;','&part;','&exist;','&empty;','&nabla;','&isin;','&notin;','&ni;','&prod;','&sum;','&minus;','&lowast;','&radic;','&prop;','&infin;','&ang;','&and;','&or;','&cap;','&cup;','&int;','&there4;','&sim;','&cong;','&asymp;','&ne;','&equiv;','&le;','&ge;','&sub;','&sup;','&nsub;','&sube;','&supe;','&oplus;','&otimes;','&perp;','&sdot;','&lceil;','&rceil;','&lfloor;','&rfloor;','&lang;','&rang;','&loz;','&spades;','&clubs;','&hearts;','&diams;'],
  arr2: ['&#160;','&#161;','&#162;','&#163;','&#164;','&#165;','&#166;','&#167;','&#168;','&#169;','&#170;','&#171;','&#172;','&#173;','&#174;','&#175;','&#176;','&#177;','&#178;','&#179;','&#180;','&#181;','&#182;','&#183;','&#184;','&#185;','&#186;','&#187;','&#188;','&#189;','&#190;','&#191;','&#192;','&#193;','&#194;','&#195;','&#196;','&#197;','&#198;','&#199;','&#200;','&#201;','&#202;','&#203;','&#204;','&#205;','&#206;','&#207;','&#208;','&#209;','&#210;','&#211;','&#212;','&#213;','&#214;','&#215;','&#216;','&#217;','&#218;','&#219;','&#220;','&#221;','&#222;','&#223;','&#224;','&#225;','&#226;','&#227;','&#228;','&#229;','&#230;','&#231;','&#232;','&#233;','&#234;','&#235;','&#236;','&#237;','&#238;','&#239;','&#240;','&#241;','&#242;','&#243;','&#244;','&#245;','&#246;','&#247;','&#248;','&#249;','&#250;','&#251;','&#252;','&#253;','&#254;','&#255;','&#34;','&#38;','&#60;','&#62;','&#338;','&#339;','&#352;','&#353;','&#376;','&#710;','&#732;','&#8194;','&#8195;','&#8201;','&#8204;','&#8205;','&#8206;','&#8207;','&#8211;','&#8212;','&#8216;','&#8217;','&#8218;','&#8220;','&#8221;','&#8222;','&#8224;','&#8225;','&#8240;','&#8249;','&#8250;','&#8364;','&#402;','&#913;','&#914;','&#915;','&#916;','&#917;','&#918;','&#919;','&#920;','&#921;','&#922;','&#923;','&#924;','&#925;','&#926;','&#927;','&#928;','&#929;','&#931;','&#932;','&#933;','&#934;','&#935;','&#936;','&#937;','&#945;','&#946;','&#947;','&#948;','&#949;','&#950;','&#951;','&#952;','&#953;','&#954;','&#955;','&#956;','&#957;','&#958;','&#959;','&#960;','&#961;','&#962;','&#963;','&#964;','&#965;','&#966;','&#967;','&#968;','&#969;','&#977;','&#978;','&#982;','&#8226;','&#8230;','&#8242;','&#8243;','&#8254;','&#8260;','&#8472;','&#8465;','&#8476;','&#8482;','&#8501;','&#8592;','&#8593;','&#8594;','&#8595;','&#8596;','&#8629;','&#8656;','&#8657;','&#8658;','&#8659;','&#8660;','&#8704;','&#8706;','&#8707;','&#8709;','&#8711;','&#8712;','&#8713;','&#8715;','&#8719;','&#8721;','&#8722;','&#8727;','&#8730;','&#8733;','&#8734;','&#8736;','&#8743;','&#8744;','&#8745;','&#8746;','&#8747;','&#8756;','&#8764;','&#8773;','&#8776;','&#8800;','&#8801;','&#8804;','&#8805;','&#8834;','&#8835;','&#8836;','&#8838;','&#8839;','&#8853;','&#8855;','&#8869;','&#8901;','&#8968;','&#8969;','&#8970;','&#8971;','&#9001;','&#9002;','&#9674;','&#9824;','&#9827;','&#9829;','&#9830;'],
    
  // Convert HTML entities into numerical entities
  HTML2Numerical : function(s){
    return this.swapArrayVals(s,this.arr1,this.arr2);
  },  

  // Convert Numerical entities into HTML entities
  NumericalToHTML : function(s){
    return this.swapArrayVals(s,this.arr2,this.arr1);
  },


  // Numerically encodes all unicode characters
  numEncode : function(s){ 
    if(this.isEmpty(s)) return ""; 

    var a = [],
      l = s.length; 
    
    for (var i=0;i<l;i++){ 
      var c = s.charAt(i); 
      if (c < " " || c > "~"){ 
        a.push("&#"); 
        a.push(c.charCodeAt()); //numeric value of code point 
        a.push(";"); 
      }else{ 
        a.push(c); 
      } 
    } 
    
    return a.join("");  
  }, 
  
  // HTML Decode numerical and HTML entities back to original values
  htmlDecode : function(s){

    var c,m,d = s;
    
    if(this.isEmpty(d)) return "";

    // convert HTML entites back to numerical entites first
    d = this.HTML2Numerical(d);
    
    // look for numerical entities &#34;
    arr=d.match(/&#[0-9]{1,5};/g);
    
    // if no matches found in string then skip
    if(arr!=null){
      for(var x=0;x<arr.length;x++){
        m = arr[x];
        c = m.substring(2,m.length-1); //get numeric part which is refernce to unicode character
        // if its a valid number we can decode
        if(c >= -32768 && c <= 65535){
          // decode every single match within string
          d = d.replace(m, String.fromCharCode(c));
        }else{
          d = d.replace(m, ""); //invalid so replace with nada
        }
      }     
    }

    return d;
  },    

  // encode an input string into either numerical or HTML entities
  htmlEncode : function(s,dbl){
      
    if(this.isEmpty(s)) return "";

    // do we allow double encoding? E.g will &amp; be turned into &amp;amp;
    dbl = dbl || false; //default to prevent double encoding
    
    // if allowing double encoding we do ampersands first
    if(dbl){
      if(this.EncodeType=="numerical"){
        s = s.replace(/&/g, "&#38;");
      }else{
        s = s.replace(/&/g, "&amp;");
      }
    }

    // convert the xss chars to numerical entities ' " < >
    s = this.XSSEncode(s,false);
    
    if(this.EncodeType=="numerical" || !dbl){
      // Now call function that will convert any HTML entities to numerical codes
      s = this.HTML2Numerical(s);
    }

    // Now encode all chars above 127 e.g unicode
    s = this.numEncode(s);

    // now we know anything that needs to be encoded has been converted to numerical entities we
    // can encode any ampersands & that are not part of encoded entities
    // to handle the fact that I need to do a negative check and handle multiple ampersands &&&
    // I am going to use a placeholder

    // if we don't want double encoded entities we ignore the & in existing entities
    if(!dbl){
      s = s.replace(/&#/g,"##AMPHASH##");
    
      if(this.EncodeType=="numerical"){
        s = s.replace(/&/g, "&#38;");
      }else{
        s = s.replace(/&/g, "&amp;");
      }

      s = s.replace(/##AMPHASH##/g,"&#");
    }
    
    // replace any malformed entities
    s = s.replace(/&#\d*([^\d;]|$)/g, "$1");

    if(!dbl){
      // safety check to correct any double encoded &amp;
      s = this.correctEncoding(s);
    }

    // now do we need to convert our numerical encoded string into entities
    if(this.EncodeType=="entity"){
      s = this.NumericalToHTML(s);
    }

    return s;         
  },

  // Encodes the basic 4 characters used to malform HTML in XSS hacks
  XSSEncode : function(s,en){
    if(!this.isEmpty(s)){
      en = en || true;
      // do we convert to numerical or html entity?
      if(en){
        s = s.replace(/\'/g,"&#39;"); //no HTML equivalent as &apos is not cross browser supported
        s = s.replace(/\"/g,"&quot;");
        s = s.replace(/</g,"&lt;");
        s = s.replace(/>/g,"&gt;");
      }else{
        s = s.replace(/\'/g,"&#39;"); //no HTML equivalent as &apos is not cross browser supported
        s = s.replace(/\"/g,"&#34;");
        s = s.replace(/</g,"&#60;");
        s = s.replace(/>/g,"&#62;");
      }
      return s;
    }else{
      return "";
    }
  },

  // returns true if a string contains html or numerical encoded entities
  hasEncoded : function(s){
    if(/&#[0-9]{1,5};/g.test(s)){
      return true;
    }else if(/&[A-Z]{2,6};/gi.test(s)){
      return true;
    }else{
      return false;
    }
  },

  // will remove any unicode characters
  stripUnicode : function(s){
    return s.replace(/[^\x20-\x7E]/g,"");
    
  },

  // corrects any double encoded &amp; entities e.g &amp;amp;
  correctEncoding : function(s){
    return s.replace(/(&amp;)(amp;)+/,"$1");
  },


  // Function to loop through an array swaping each item with the value from another array e.g swap HTML entities with Numericals
  swapArrayVals : function(s,arr1,arr2){
    if(this.isEmpty(s)) return "";
    var re;
    if(arr1 && arr2){
      //ShowDebug("in swapArrayVals arr1.length = " + arr1.length + " arr2.length = " + arr2.length)
      // array lengths must match
      if(arr1.length == arr2.length){
        for(var x=0,i=arr1.length;x<i;x++){
          re = new RegExp(arr1[x], 'g');
          s = s.replace(re,arr2[x]); //swap arr1 item with matching item from arr2  
        }
      }
    }
    return s;
  },

  inArray : function( item, arr ) {
    for ( var i = 0, x = arr.length; i < x; i++ ){
      if ( arr[i] === item ){
        return i;
      }
    }
    return -1;
  }

}