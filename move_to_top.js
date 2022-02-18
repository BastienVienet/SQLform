const button_fixed = document.querySelector('.button_fixed');

button_fixed.addEventListener('click', () => {

    window.scrollTo({
        top: 0,
        left: 0,
        behavior: "smooth"
    })

})