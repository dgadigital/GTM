// Default JS entry file
// Default JS entry file
import $ from 'jquery';

import 'slick-carousel';

// 🧹 Prevent multiple Bootstrap event bindings
if (!window._bootstrapCollapsePatched) {
  window._bootstrapCollapsePatched = true;

  document.addEventListener('DOMContentLoaded', () => {
    const nav = document.getElementById('mobileNav');
    if (!nav) return;

    // Ensure only one collapse instance exists
    const existingInstance = bootstrap.Collapse.getInstance(nav);
    if (existingInstance) existingInstance.dispose();

    // Reinitialize cleanly (Bootstrap still honors data attributes)
    const collapseInstance = new bootstrap.Collapse(nav, { toggle: false });

    // Debug events (will now fire once each)
    nav.addEventListener('show.bs.collapse', () => console.log('opening'));
    nav.addEventListener('hide.bs.collapse', () => console.log('closing'));

    // Inline style cleanup for animation
    nav.addEventListener('shown.bs.collapse', e => (e.target.style.height = ''));
    nav.addEventListener('hide.bs.collapse', e => (e.target.style.height = ''));
    nav.addEventListener('hidden.bs.collapse', e => {
      e.target.classList.remove('show');
      e.target.style.height = '';
    });
  });
}


jQuery(document).ready(function($) {
  const $navbar = $('.navbar');
  if (!$navbar.length) return;

  let scrolledOnce = false;

  $(window).on('scroll', function() {
    if ($(this).scrollTop() > 50) { // threshold for when effect starts
      $navbar.addClass('scrolled');
      scrolledOnce = true;
    } else if (scrolledOnce) {
      $navbar.removeClass('scrolled');
    }
  });
});



jQuery(function ($) {
  // Handle dropdown toggle clicks
  $(document).on("click", ".dropdown-toggle", function (e) {
    e.preventDefault();
    e.stopPropagation();

    // Find the dropdown menu relative to this toggle
    const $dropdown = $(this).closest(".nav-item.dropdown");
    const $menu = $dropdown.find(".dropdown-menu").first();

    // Close all other dropdowns
    $(".dropdown-menu.show").not($menu).removeClass("show");

    // Toggle current one
    $menu.toggleClass("show");
  });

  // Close when clicking outside
  $(document).on("click", function (e) {
    if (!$(e.target).closest(".nav-item.dropdown").length) {
      $(".dropdown-menu").removeClass("show");
    }
  });
});


document.addEventListener("DOMContentLoaded", function () {
  const nav = document.getElementById("mobileNav");

  if (nav) {
    // clean up Bootstrap inline styles so animation can finish
    nav.addEventListener("shown.bs.collapse", (e) => {
      e.target.style.height = "";
    });

    nav.addEventListener("hide.bs.collapse", (e) => {
      // remove Bootstrap’s inline height so CSS can animate close
      e.target.style.height = "";
    });

    nav.addEventListener("hidden.bs.collapse", (e) => {
      // safety net — force it back to real closed state
      e.target.classList.remove("show");
      e.target.style.height = "";
    });
  }
});

jQuery(document).ready(function($) {
  $('.logoslider').slick({
    slidesToShow: 6,
    slidesToScroll: 3,
    arrows: false,
    dots: true,
    autoplay: true,
    // autoplay: false,
    autoplaySpeed: 2000,
    infinite: true,
    responsive: [
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        }
      }
    ]
  });
});
jQuery(document).ready(function ($) {
  $('.hover-slider').slick({
    dots: false,
    arrows: false,
    infinite: true,
    speed: 400,
    slidesToShow: 3,
    slidesToScroll: 3,
    rows: 2,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
          rows: 2
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          rows: 1
        }
      }
    ]
  });
});


// ==================================================================================================
// function moveSlickArrows() {
//   $('.carousel').each(function () {
//     const $carousel = $(this);
//     const $existingWrapper = $carousel.next('.button-wrapper');

//     // Reuse or create wrapper
//     const $wrapper = $existingWrapper.length
//       ? $existingWrapper
//       : $('<div class="button-wrapper"></div>').insertAfter($carousel);

//     // Move arrows into wrapper
//     $carousel.find('.slick-prev, .slick-next').appendTo($wrapper);
//   });
// }

// // Attach before initialization
// $('.carousel').on('init reInit breakpoint', function (event, slick) {
//   moveSlickArrows();
// });

// // Initialize Slick
// $('.carousel').slick({
//   slidesToShow: 3,
//   slidesToScroll: 1,
//   rows: 2,
//   prevArrow:
//     '<button type="button" class="slick-prev">swipe left to navigate</button>',
//   nextArrow:
//     '<button type="button" class="slick-next">swipe right to navigate</button>',
//   responsive: [
//     {
//       breakpoint: 992,
//       settings: {
//         slidesToShow: 2
//       }
//     },
//     {
//       breakpoint: 776,
//       settings: {
//         slidesToShow: 1,
//         rows: 1
//       }
//     }
//   ]
// });

// // Add custom class after init
// $('.carousel').on('init', function () {
//   $(this)
//     .find('.slick-slide > div:not([class])')
//     .addClass('slick-inner');
// });

// Add class before initializing Slick

function applySlickInner(e, slick) {
  const $slider = $(slick.$slider);
  // Let Slick finish DOM tweaks this tick
  requestAnimationFrame(() => {
    $slider.find('.slick-track .slick-slide').each(function () {
      $(this).children('div').each(function () {
        const $child = $(this);
        if (!$child.attr('class')) {
          $child.addClass('slick-inner');
        }
      });
    });
  });
}

function moveSlickArrows(e, slick) {
  const $slider = slick.$slider; // the specific carousel instance

  // Run after Slick’s DOM changes for this tick
  requestAnimationFrame(() => {
    // Reuse or create wrapper right after THIS slider
    let $wrapper = $slider.next('.button-wrapper');
    if (!$wrapper.length) {
      $wrapper = $('<div class="button-wrapper"></div>').insertAfter($slider);
    }

    // Move the actual arrows Slick knows about
    if (slick.$prevArrow && slick.$prevArrow.length) {
      slick.$prevArrow.appendTo($wrapper);
    }
    if (slick.$nextArrow && slick.$nextArrow.length) {
      slick.$nextArrow.appendTo($wrapper);
    }
  });
}

// Attach BEFORE init
$('.carousel')
  .on('init reInit breakpoint setPosition', applySlickInner)
  .on('init reInit breakpoint setPosition', moveSlickArrows)
  .slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    rows: 2,
    prevArrow:
      '<button type="button" class="slick-prev">swipe left to navigate</button>',
    nextArrow:
      '<button type="button" class="slick-next">swipe right to navigate</button>',
    responsive: [
      { breakpoint: 992, settings: { slidesToShow: 2 } },
      { breakpoint: 776, settings: { slidesToShow: 1, rows: 1 } }
    ]
  });



// ==================================================================================================


jQuery(document).ready(function($) {
  $('.testimonial-slider').slick({
    dots: true,
    arrows: false,
    slidesToShow: 3,
    slidesToScroll: 1,
    adaptiveHeight: true,
    responsive: [
      {
        breakpoint: 991,
        settings: { slidesToShow: 2 }
      },
      {
        breakpoint: 767,
        settings: { slidesToShow: 1 }
      }
    ]
  });
});