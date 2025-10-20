<?php
class Custom_Walker_Nav extends Walker_Nav_Menu {

  public function start_lvl(&$output, $depth = 0, $args = array()) {
    if ($depth === 0) {
      $output .= "\n<div class=\"dropdown-menu box-style\" aria-labelledby=\"navbarDropdown\">\n";
    }
  }

  public function end_lvl(&$output, $depth = 0, $args = array()) {
    if ($depth === 0) {
      $output .= "</div>\n";
    }
  }

  public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
    $classes = empty($item->classes) ? [] : (array) $item->classes;
    $has_children = in_array('menu-item-has-children', $classes);
    $is_dropdown = $has_children && $depth === 0;

    if ($depth === 0) {
      $output .= '<li class="nav-item' . ($is_dropdown ? ' dropdown' : '') . '">';

      // Main nav link
      $output .= '<div class="dropdown-wrapper"><a class="nav-link" href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';

      // Dropdown toggle link with SVG
      if ($is_dropdown) {
        $output .= '<a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
        $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21" fill="none">
          <path d="M4.32982 9.48485C3.52339 8.67842 4.09453 7.29956 5.23499 7.29956L15.3472 7.29956C16.4877 7.29956 17.0588 8.67842 16.2524 9.48484L11.1963 14.541C10.6964 15.0409 9.88583 15.0409 9.38592 14.5409L4.32982 9.48485Z" fill="#ffffff"></path>
        </svg>';
        $output .= '</a></div>';
      }

    } else {
      // Inside <div class="dropdown-menu"> — no <li>, just <a>
      $output .= '<a class="dropdown-item" href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
    }
  }

  public function end_el(&$output, $item, $depth = 0, $args = array()) {
    if ($depth === 0) {
      $output .= "</li>\n";
    }
  }
}
