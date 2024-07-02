
  let images = ["images/image.jpg", "images/image2.jpg", "images/image3.jpg"];
  let currentIndex = 0;
  
  // Slideshow elementini seçme
  let slideshow = document.getElementById('slideshow');
  

  function changeImage() {
      // Şu anki indeksteki resmi göster
      slideshow.innerHTML = '<img class="h-full w-full" src="' + images[currentIndex] + '" alt="">';
      
      // Sonraki resme geç
      currentIndex++;
      if (currentIndex >= images.length) {
          currentIndex = 0; 
      }
      
      // Belirli bir süre sonra tekrar çağrılacak
      setTimeout(changeImage, 150000);
  }
  
  // İlk resmi göstermek için fonksiyonu çağır
  changeImage();