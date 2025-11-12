<?php
/**
 * Custom Walker for Mobile Navigation
 */
class Custom_Walker_Nav_Mobile extends Walker_Nav_Menu {

  public function start_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);

    // Only wrap level 0 dropdowns
    if ( $depth === 0 ) {
      $output .= "\n{$indent}<div class=\"dropdown-menu box-style\">\n";
    }
  }

  public function end_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    if ( $depth === 0 ) {
      $output .= "{$indent}</div>\n";
    }
  }

  public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    $classes       = empty( $item->classes ) ? [] : (array) $item->classes;
    $has_children  = in_array( 'menu-item-has-children', $classes );
    $is_dropdown   = $has_children && $depth === 0;
    $is_submenu    = $has_children && $depth === 1;

    /* ---------- LEVEL 1 ---------- */
    if ( $depth === 0 ) {
      $output .= '<li class="nav-item' . ( $is_dropdown ? ' dropdown' : '' ) . '">';
      $output .= '<div class="dropdown-wrapper">';
      $output .= '<a class="nav-link" href="' . esc_url( $item->url ) . '">' . esc_html( $item->title ) . '</a>';
      if ( $is_dropdown ) {
        $output .= $this->get_toggle_svg();
      }
      $output .= '</div>';

    /* ---------- LEVEL 2 ---------- */
    } elseif ( $depth === 1 ) {
      $output .= '<div class="dropdown-item-wrapper">';

      // Inner flex container for item + toggle SVG
      $output .= '<div class="dropdown-item-inner">';
      $output .= '<a class="dropdown-item' . ( $is_submenu ? ' has-submenu' : '' ) . '" href="' . esc_url( $item->url ) . '">' . esc_html( $item->title ) . '</a>';
      if ( $is_submenu ) {
        $output .= $this->get_toggle_svg();
      }
      $output .= '</div>'; // close .dropdown-item-inner

      // Submenu lives below the inner wrapper
      if ( $is_submenu ) {
        $output .= '<div class="dropdown-submenu">';
      }

    /* ---------- LEVEL 3+ ---------- */
    } elseif ( $depth >= 2 ) {
      $output .= '<a class="dropdown-subitem" href="' . esc_url( $item->url ) . '">' . esc_html( $item->title ) . '</a>';
    }
  }

  public function end_el( &$output, $item, $depth = 0, $args = array() ) {
    $classes = empty( $item->classes ) ? [] : (array) $item->classes;

    // Close submenu if opened
    if ( $depth === 1 && in_array( 'menu-item-has-children', $classes ) ) {
      $output .= '</div>'; // close .dropdown-submenu
    }

    if ( $depth === 1 ) {
      $output .= '</div>'; // close .dropdown-item-wrapper
    }

    if ( $depth === 0 ) {
      $output .= "</li>\n";
    }
  }

  /* ---------- SVG Toggle Icon ---------- */
  private function get_toggle_svg() {
    return '<a class="dropdown-toggle" href="#" role="button" aria-haspopup="true" aria-expanded="false">'
         . '<svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21" fill="none">'
         . '<path d="M4.33 9.48C3.52 8.68 4.09 7.3 5.23 7.3h10.11c1.14 0 1.71 1.38.9 2.18l-5.06 5.06a1.1 1.1 0 0 1-1.81 0L4.33 9.48Z" fill="#ffffff"></path>'
         . '</svg></a>';
  }
}
