window.onload = () => {
    const FiltersForm = document.querySelector("#filtres");

    // On boucle sur les input
    document.querySelectorAll("#filtres input").forEach(input => {
        //on ajoute des listeners sur les inputs
        input.addEventListener("change", () => {
//on recuperer les données du form
            const form=new FormData(FiltersForm);
            //creation de la querystring  pour ajax
            const param=new URLSearchParams();
            form.forEach((value,key)=>{
                param.append(key,value);
            });

            //on recupere l'url active
            const url=new URL(window.location.href);

            //on lance la requete ajax 
            fetch(url.pathname+ "?" +param.toString(),{
                 headers:{
                "X-Requested-With": "XMLHttpRequest"

             }}).then(response => {
               console.log(response)

             }).catch(e=>alert(e));

           
            });
        });
    }

    