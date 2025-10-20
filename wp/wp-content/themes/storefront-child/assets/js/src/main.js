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
