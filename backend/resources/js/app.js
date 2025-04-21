import './bootstrap';

shopButton.addEventListener('mouseenter', () => {
    shopButton.classList.add('animate-bounce');

    setTimeout(() =>{
        shopButton.classList.remove('animate-bounce');
      }, 500)
  });

  