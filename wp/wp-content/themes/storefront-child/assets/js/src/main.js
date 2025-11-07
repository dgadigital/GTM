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
  $('.logoslider').each(function() {
    const $slider = $(this);
    const rows = parseInt($slider.data('rows')) || 1; // default 1 row

    $slider.slick({
      slidesToShow: 6,
      slidesToScroll: 3,
      arrows: false,
      dots: true,
      autoplay: true,
      autoplaySpeed: 2000,
      infinite: true,
      rows: rows, // 👈 dynamic rows support
      responsive: [
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            rows: rows
          }
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            rows: 1 // usually single row on mobile
          }
        }
      ]
    });
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
jQuery(document).ready(function ($) {
  $('.carousel').each(function () {
    const $carousel = $(this);
    const rows = parseInt($carousel.data('rows')) || 2; // 👈 pull from PHP

    $carousel.on('init reInit breakpoint setPosition', applySlickInner)
      .on('init reInit breakpoint setPosition', moveSlickArrows)
      .slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        rows: rows, // 👈 dynamic rows
        prevArrow:
          '<button type="button" class="slick-prev">swipe left to navigate</button>',
        nextArrow:
          '<button type="button" class="slick-next">swipe right to navigate</button>',
        responsive: [
          { breakpoint: 992, settings: { slidesToShow: 2 } },
          { breakpoint: 776, settings: { slidesToShow: 1, rows: 1 } }
        ]
      });
  });
});




// ==================================================================================================


jQuery(document).ready(function ($) {
  // Shared slider settings
  const testimonial_slickSettings = {
    dots: true,
    arrows: false,
    slidesToShow: 2,
    slidesToScroll: 1,
    adaptiveHeight: true,
    infinite: true,
    autoplay: false,
    responsive: [
      {
        breakpoint: 767,
        settings: { slidesToShow: 1 }
      }
    ]
  };
  const case_study_slickSettings = {
    dots: true,
    arrows: false,
    slidesToShow: 3,
    slidesToScroll: 1,
    adaptiveHeight: true,
    infinite: true,
    autoplay: false,
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
  };

  // Initialize Testimonial Slider
  if ($('.testimonial-slider').length && !$('.testimonial-slider').hasClass('slick-initialized')) {
    $('.testimonial-slider').slick(testimonial_slickSettings);
  }

  // Initialize Case Study Slider
  if ($('.case-study-slider').length && !$('.case-study-slider').hasClass('slick-initialized')) {
    $('.case-study-slider').slick(case_study_slickSettings);
  }
});


document.querySelectorAll('.grid-section .item').forEach(item => {
  const video = item.querySelector('.bg-video');
  if (!video) return;

  item.addEventListener('mouseenter', () => {
    video.play();
  });

  item.addEventListener('mouseleave', () => {
    video.pause();
  });
});


jQuery(document).ready(function ($) {
  const $leadershipSlider = $('.leadership-fullwidth-automatic-slider .is-slider');

  if ($leadershipSlider.length && !$leadershipSlider.hasClass('slick-initialized')) {
    $leadershipSlider.slick({
      slidesToShow: 5.35,           // 5 full + right-side peek
      slidesToScroll: 1,
      infinite: true,              // ✅ infinite loop stays on
      autoplay: true,
      autoplaySpeed: 3000,
      speed: 600,
      cssEase: 'ease',
      arrows: false,
      dots: false,
      pauseOnHover: true,
      centerMode: false,           // ❗ disable centering
      variableWidth: false,        // keep equal widths
      responsive: [
        { breakpoint: 992,  settings: { slidesToShow: 2.5 } },
        { breakpoint: 768,  settings: { slidesToShow: 1.5 } },
        { breakpoint: 480,  settings: { slidesToShow: 1 } }
      ]
    });
  }
});


document.querySelectorAll('.hero-video-banner').forEach(section => {
  const video  = section.querySelector('.hero-bg-video');
  const button = section.querySelector('.video-toggle');
  if (!video || !button) return;

  // Keep the class in sync with the real video state
  const sync = () => {
    const isPlaying = !video.paused && !video.ended && video.currentTime > 0;
    section.classList.toggle('playing', isPlaying);
  };

  // Initial sync after metadata is ready (duration/currentTime available)
  if (video.readyState >= 1) {
    sync();
  } else {
    video.addEventListener('loadedmetadata', sync, { once: true });
  }

  // Also handle common playback state events
  video.addEventListener('playing',  sync);
  video.addEventListener('play',     sync);
  video.addEventListener('pause',    sync);
  video.addEventListener('ended',    sync);

  // Button toggles play/pause
  button.addEventListener('click', () => {
    if (video.paused) {
      const p = video.play();
      if (p && typeof p.catch === 'function') p.catch(() => {}); // ignore autoplay block errors
    } else {
      video.pause();
    }
  });
});
