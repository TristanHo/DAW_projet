var id = 0;

$('#theme').on('click', function() {
    switch(id) {
        case 0 : {$('body').attr('href', 'nuit.css'); $('#theme').html("Mode couleur"); id++; break;}
        case 1 : {$('body').attr('href', 'couleur.css'); $('#theme').html("Mode jour"); id++; break;}
        case 2 : {$('body').attr('href', 'base.css'); $('#theme').html("Mode nuit"); id = 0;}
    }
})