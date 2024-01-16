//Navbar Links
$(document).ready(function(){
    $('.nav-link').click(function(e){
        e.preventDefault();
        let url = $(this).attr('href');

        $('#conteudo').empty();

        if(url != "index.html"){
            //Insere a nova página dentro da DIV content: 
            $('#conteudo').load(url)
        }
        
    })
});

const btt_mobile = document.getElementById("btt_mobile");
const nav_link = document.getElementById("menu");

const navbar = document.getElementById("navbar");

function toggle_menu(event){
     //Se for touch, ele vai apenas rodar o 'touchstart' ao invés do 'click'
    if(event.type == 'touchstart') {
        event.preventDefault(); //Previne que o 'click' e o 'touchstart' aconteçam ao mesmo tempo
    }

    navbar.classList.toggle("active"); //toggle > Botão liga desliga (se não existir, adiciona, se existir, tira)
}
function link_menu(){
    navbar.classList.remove("active");
}

//Configura o clique no PC
btt_mobile.addEventListener('click', toggle_menu);
nav_link.addEventListener('click', link_menu);

//Configura o clique no celular, touchstart tira o delay do 'click' 
btt_mobile.addEventListener('touchstart', toggle_menu);
nav_link.addEventListener('touchstart', link_menu);


function modal(){
    var modal = document.getElementsByClassName("modal")[0];

    if(modal.style.display === "none"){
        modal.style.display = "block";
    }else{
        modal.style.display = "none";
        document.getElementById("form-local").reset(); //Limpa os dados inseridos ao sair do modal
    }
}


function dExcep(){
    // ---------- Dia Excepcional ----------
    var diaExcep = document.getElementsByName("diaExcep");

    var excep = document.getElementById("excep");
    var dtExcep = document.querySelectorAll(".dExcep"); //Seleciona todos os elementos dentro da classificação, precisa especificar se é classe (.nome) ou id (#nome)

    // ---------- Data Específica ----------
    var dtEspec = document.getElementsByName("dtEspec");

    var espec_nao = document.getElementById("espec_nao");
    var espec_sim = document.getElementById("espec_sim");

    var noEspec = document.getElementById("diaSemana");
    var yesEspec = document.getElementById("dataExcep");

    // ----------Aberto/Fechado ----------
    var aberto_fechado = document.getElementsByName("aberto_fechado");

    var dia_aberto = document.getElementById("dia_aberto");
    var hr_aberto = document.querySelectorAll(".hr_aberto");

    
    for(i=0; i<diaExcep.length; i++){
        if(diaExcep[i].checked){
            var dExcep = diaExcep[i].value;
            if(dExcep > 0){
                //alert(dExcep + " Maior que 0!")

                excep.style.display = "flex";
                for(const i of dtExcep){ //Para ir em cada elemento e adicionar o atributo
                    i.setAttribute("required", "");
                }

                // ---------- Dia Específico ----------
                for(i=0; i<dtEspec.length; i++){
                    if(dtEspec[i].checked){
                        var dEspec = dtEspec[i].value;
                        if(dEspec > 0){
                            //alert(dEspec + " Maior que 0!")
            
                            espec_sim.style.display = "flex";
                            espec_nao.style.display = "none";
            
                            yesEspec.setAttribute("required", "");
                            noEspec.removeAttribute("required");
            
                        }else{
                            //alert(dEspec + " Menor ou igual a 0!")
            
                            espec_sim.style.display = "none";
                            espec_nao.style.display = "flex";
            
                            yesEspec.removeAttribute("required");
                            noEspec.setAttribute("required", "");
                        }
                    }
                }

                // ----------Aberto/Fechado ----------
                for(i=0; i<aberto_fechado.length; i++) {
                    if(aberto_fechado[i].checked){
                        var ab_fc = aberto_fechado[i].value;
            
                        if(ab_fc > 1){
                            dia_aberto.style.display = "flex";
            
                            for(const i of hr_aberto){
                                i.setAttribute("required",  "");
                            }
                        }else{
                            dia_aberto.style.display = "none";
                            for(const i of hr_aberto){
                                i.removeAttribute("required");
                            }
                        }
                    }
                }

            }else{
                //alert(dExcep + " Menor ou igual a 0!")

                excep.style.display = "none";
                for(const i of dtExcep){ //Para ir em cada elemento e remover o atributo
                    i.removeAttribute("required");
                }

                // ---------- Dia Específico ----------
                espec_sim.style.display = "none";
                espec_nao.style.display = "none";
            
                yesEspec.removeAttribute("required");
                noEspec.removeAttribute("required");
                
                // ----------Aberto/Fechado ----------
                for(i=0; i<aberto_fechado.length; i++) {
                    dia_aberto.style.display = "none";
                        for(const i of hr_aberto){
                            i.removeAttribute("required");
                        }
                }

            }
        }
    }
}