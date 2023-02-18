  // import Swiper JS
//   import ComponentRegistrar from 'laravel-mix/src/components/ComponentRegistrar';
    import Swiper from 'swiper';
  // import Swiper styles
  import 'swiper/swiper-bundle.css';

  import SwiperCore, { Navigation, Pagination} from 'swiper/core';

  SwiperCore.use([Navigation, Pagination]);

//   const swiper = new Swiper(...);

    // core version + navigation, pagination modules:
    // import Swiper, { Navigation, Pagination } from 'swiper';
    // // import Swiper and modules styles
    // import 'swiper/css';
    // import 'swiper/css/navigation';
    // import 'swiper/css/pagination';

    // init Swiper:
    // const swiper = new Swiper('.swiper', {
    //   // configure Swiper to use modules
    //   modules: [Navigation, Pagination],
    //   ...
    // });



    const swiper = new Swiper('.swiper-container', {
        // Optional parameters
        // direction: 'vertical',
        loop: true,

        // If we need pagination
        pagination: {
          el: '.swiper-pagination',
        },

        // Navigation arrows
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },

        // And if we need scrollbar
        scrollbar: {
          el: '.swiper-scrollbar',
        },
      });
