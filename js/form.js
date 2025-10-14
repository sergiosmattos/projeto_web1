window.addEventListener('DOMContentLoaded', () => {
            
    const mensagens = document.querySelectorAll('.mensagem-erro, .mensagem-ok');

    mensagens.forEach(msg => {
        
        setTimeout(() => {

            msg.classList.add('oculto');

            msg.remove();

        }, 2500);

    });
    
});